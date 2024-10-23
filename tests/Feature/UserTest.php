<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Sanctum::actingAs($user);
    }

    /**
     * A basic test example.
     */
    public function test_index_returns_successful_response()
    {
        User::factory(3)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonCount(4);
    }

    public function test_store_creates_new_user()
    {
        $response = $this->postJson('/api/users', [
            'last_name' => 'New User',
            'first_name' => 'John',
            'nt_id' => 100123,
            'image' => null,
            'phone' => '+998912345678',
            'profession' => 'Engineer',
            'biography' => 'This is a sample biography',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(201)
            ->assertJsonFragment(['last_name' => 'New User']);
    }

    public function test_store_fails_with_invalid_data()
    {
        $response = $this->postJson('/api/users', [
            'first_name' => '',
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors('first_name');
    }

    public function test_show_returns_user()
    {

        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['last_name' => $user->last_name]);
    }

    public function test_show_fails_for_nonexistent_user()
    {
        $response = $this->getJson('/api/users/999');

        $response->assertStatus(404);
    }

    public function test_update_modifies_existing_user()
    {

        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", [
            'last_name' => 'Updated User',
            'first_name' => 'Updated John',
            'nt_id' => 100456,
            'image' => null,
            'phone' => '+998912345678',
            'profession' => 'Senior Engineer',
            'biography' => 'This is an updated biography.',
            'email' => 'john@examaple.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(200)
            ->assertJsonFragment(['last_name' => 'Updated User']);
    }

    public function test_update_fails_with_invalid_data()
    {
        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", [
            'last_name' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('last_name');
    }

    public function test_destroy_removes_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_destroy_fails_for_nonexistent_user()
    {
        $response = $this->deleteJson('/api/users/999');

        $response->assertStatus(404);
    }
}
