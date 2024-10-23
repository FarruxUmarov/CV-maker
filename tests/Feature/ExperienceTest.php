<?php

namespace Tests\Feature;

use App\Models\Experience;
use App\Models\SocialNetwork;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ExperienceTest extends TestCase
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
        Experience::factory(3)->create();

        $response = $this->getJson('/api/experiences');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_store_creates_new_socialNetwork()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/experiences', [
            'user_id' => $user->id,
            'name' => 'GitHub',
            'position' => 'Developer',
            'description' => 'Open Source Contributor',
            'start_date' => '2023-01-01',
            'end_date' => '2023-12-31',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'GitHub']);
    }

    public function test_store_fails_with_invalid_data()
    {
        $response = $this->postJson('/api/experiences', [
            'name' => '',
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_show_returns_socialNetwork()
    {

        $experience = Experience::factory()->create();

        $response = $this->getJson("/api/experiences/{$experience->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $experience->name]);
    }

    public function test_show_fails_for_nonexistent_socialNetwork()
    {
        $response = $this->getJson('/api/experiences/999');

        $response->assertStatus(404);
    }

    public function test_update_modifies_existing_socialNetwork()
    {
        $experience = Experience::factory()->create();

        $user = User::factory()->create();

        $response = $this->putJson("/api/experiences/{$experience->id}", [
            'user_id' => $user->id,
            'name' => 'GitHub',
            'position' => 'Developer',
            'description' => 'Open Source Contributor',
            'start_date' => '2023-01-01',
            'end_date' => '2023-12-31',
        ]);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'GitHub']);
    }

    public function test_update_fails_with_invalid_data()
    {

        $experience = Experience::factory()->create();

        $response = $this->putJson("/api/experiences/{$experience->id}", [
            'name' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    public function test_destroy_removes_socialNetwork()
    {
        $experience = Experience::factory()->create();

        $response = $this->deleteJson("/api/experiences/{$experience->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('experiences', ['id' => $experience->id]);
    }

    public function test_destroy_fails_for_nonexistent_socialNetwork()
    {
        $response = $this->deleteJson('/api/experiences/999');

        $response->assertStatus(404);
    }
}
