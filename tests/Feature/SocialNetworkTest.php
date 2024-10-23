<?php

namespace Tests\Feature;

use App\Models\SocialNetwork;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SocialNetworkTest extends TestCase
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
        SocialNetwork::factory(3)->create();

        $response = $this->getJson('/api/socialNetworks');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_store_creates_new_socialNetwork()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/socialNetworks', [
            'name' => 'GitHub',
            'link' => 'https://www.GitHub.com'
        ]);
        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'GitHub']);
    }

    public function test_store_fails_with_invalid_data()
    {
        $response = $this->postJson('/api/socialNetworks', [
            'name' => '',
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_show_returns_socialNetwork()
    {

        $socialNetwork = SocialNetwork::factory()->create();

        $response = $this->getJson("/api/socialNetworks/{$socialNetwork->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $socialNetwork->name]);
    }

    public function test_show_fails_for_nonexistent_socialNetwork()
    {
        $response = $this->getJson('/api/socialNetworks/999');

        $response->assertStatus(404);
    }

    public function test_update_modifies_existing_socialNetwork()
    {
        $socialNetwork = SocialNetwork::factory()->create();

        $response = $this->putJson("/api/socialNetworks/{$socialNetwork->id}", [
            'name' => 'laravel',
            'link' => 'https://www.Laravel.com'
        ]);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'laravel']);
    }

    public function test_update_fails_with_invalid_data()
    {

        $socialNetwork = SocialNetwork::factory()->create();

        $response = $this->putJson("/api/socialNetworks/{$socialNetwork->id}", [
            'name' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    public function test_destroy_removes_socialNetwork()
    {
        $socialNetwork = SocialNetwork::factory()->create();

        $response = $this->deleteJson("/api/socialNetworks/{$socialNetwork->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('social_networks', ['id' => $socialNetwork->id]);
    }

    public function test_destroy_fails_for_nonexistent_socialNetwork()
    {
        $response = $this->deleteJson('/api/socialNetworks/999');

        $response->assertStatus(404);
    }
}
