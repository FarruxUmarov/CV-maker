<?php

namespace Tests\Unit;

use App\Models\Education;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EducationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Sanctum::actingAs($user);
    }

    public function test_index_returns_successful_response()
    {
        Education::factory(4)->create();

        $response = $this->getJson('/api/educations');

        $response->assertStatus(200)
            ->assertJsonCount(4);
    }

    public function test_store_creates_new_education()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/educations', [
            'user_id' => $user->id,
            'name' => 'Test Education',
            'description' => 'This is a test education description.',
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Test Education']);
    }

    public function test_store_fails_with_invalid_data()
    {
        $response = $this->postJson('/api/educations', [
            'name' => '',
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_show_returns_education()
    {

        $education = Education::factory()->create();

        $response = $this->getJson("/api/educations/{$education->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $education->name]);
    }

    public function test_show_fails_for_nonexistent_education()
    {
        $response = $this->getJson('/api/educations/999');

        $response->assertStatus(404);
    }

    public function test_update_modifies_existing_education()
    {
        $education = Education::factory()->create();

        $user = User::factory()->create();

        $response = $this->putJson("/api/educations/{$education->id}", [
            'user_id' => $user->id,
            'name' => 'Test Education',
            'description' => 'This is a test education description.',
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
        ]);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Test Education']);
    }

    public function test_update_fails_with_invalid_data()
    {

        $education = Education::factory()->create();

        $response = $this->putJson("/api/educations/{$education->id}", [
            'name' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    public function test_destroy_removes_education()
    {
        $education = Education::factory()->create();

        $response = $this->deleteJson("/api/educations/{$education->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('education', ['id' => $education->id]);
    }

    public function test_destroy_fails_for_nonexistent_education()
    {
        $response = $this->deleteJson('/api/educations/999');

        $response->assertStatus(404);
    }
}
