<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Project;
use App\Models\User;
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

    public function test_store_creates_new_project()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/projects', [
            'user_id' => $user->id,
            'name' => "CV maker",
            'description' => 'This project is a tool for creating CVs easily.',
            'source_link' => 'https://github.com/example/cv-maker',
            'demo_link' => 'https://example.com/cv-maker-demo',
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
            ->assertJsonValidationErrors('name');
    }

    public function test_show_returns_project()
    {
        $project = Project::factory()->create();

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

        $project = Project::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->patchJson('/api/projects/' . $project->id, [
            'user_id' => $user->id,
            'name' => "PHP",
            'description' => 'This projecttool for creating CVs easily.',
            'source_link' => 'https://mail.com/exaple/cv-maker',
            'demo_link' => 'https://gmail.com/cv-aker-demo',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'PHP']);
    }

    public function test_update_fails_with_invalid_data()
    {
        $project = User::factory()->create();

        $response = $this->putJson("/api/projects/{$project->id}", [
            'last_name' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    public function test_destroy_removes_project()
    {
        $user = User::factory()->create();

        $project = Project::factory()->create([
            'user_id' => $user->id,
        ]);

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
