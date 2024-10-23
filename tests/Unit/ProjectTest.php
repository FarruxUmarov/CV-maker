<?php

namespace Tests\Unit;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProjectTest extends TestCase
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
        Project::factory(3)->create();

        $response = $this->getJson('/api/projects');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_store_creates_new_project()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/projects', [
            'user_id' => $user->id,
            'name' => "CV maker",
            'description' => 'This project is a tool for creating CVs easily.',
            'source_link' => 'https://githb.com/example/cv-maker',
            'demo_link' => 'https://examle.com/cv-maker-demo',
        ]);
        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'CV maker']);
    }

    public function test_store_fails_with_invalid_data()
    {
        $response = $this->postJson('/api/projects', [
            'name' => '',
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['user_id', 'name', 'description', 'source_link', 'demo_link']);
    }

    public function test_show_returns_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'user_id' => $user->id,
        ]);
        $response = $this->getJson("/api/projects/{$project->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $project->name]);
    }

    public function test_show_fails_for_nonexistent_project()
    {
        $response = $this->getJson('/api/projects/999');

        $response->assertStatus(404);
    }

    public function test_update_modifies_existing_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        $response = $this->putJson("/api/projects/{$project->id}", [
            'user_id' => $user->id,
            'name' => "CV maker",
            'description' => 'This project is a tool for creating CVs easily.',
            'source_link' => 'https://githb.com/example/cv-maker',
            'demo_link' => 'https://examle.com/cv-maker-demo',
        ]);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'CV maker']);
    }

    public function test_update_fails_with_invalid_data()
    {
        $user = User::factory()->create();

        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->putJson("/api/projects/{$project->id}", [
            'name' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    public function test_destroy_removes_project()
    {
        $user = User::factory()->create();

        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson("/api/projects/{$project->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_destroy_fails_for_nonexistent_project()
    {
        $response = $this->deleteJson('/api/projects/999');

        $response->assertStatus(404);
    }
}
