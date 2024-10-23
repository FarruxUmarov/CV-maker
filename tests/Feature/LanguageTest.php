<?php

namespace Tests\Feature;

use App\Models\Language;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LanguageTest extends TestCase
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
        Language::factory(3)->create();

        $response = $this->getJson('/api/languages');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_store_creates_new_language()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/languages', [
            'name' => "eng",
            'level' => 'C1'
        ]);
        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'eng']);
    }

    public function test_store_fails_with_invalid_data()
    {
        $response = $this->postJson('/api/languages', [
            'name' => '',
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_show_returns_language()
    {

        $language = Language::factory()->create();

        $response = $this->getJson("/api/languages/{$language->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $language->name]);
    }

    public function test_show_fails_for_nonexistent_language()
    {
        $response = $this->getJson('/api/languages/999');

        $response->assertStatus(404);
    }

    public function test_update_modifies_existing_language()
    {
        $language = Language::factory()->create();

        $response = $this->putJson("/api/languages/{$language->id}", [
            'name' => "rus",
            'level' => 'C2'
        ]);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'rus']);
    }

    public function test_update_fails_with_invalid_data()
    {

        $language = Language::factory()->create();

        $response = $this->putJson("/api/languages/{$language->id}", [
            'name' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    public function test_destroy_removes_language()
    {
        $language = Language::factory()->create();

        $response = $this->deleteJson("/api/languages/{$language->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('languages', ['id' => $language->id]);
    }

    public function test_destroy_fails_for_nonexistent_language()
    {
        $response = $this->deleteJson('/api/languages/999');

        $response->assertStatus(404);
    }
}
