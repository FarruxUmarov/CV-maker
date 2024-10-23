<?php

namespace Tests\Unit;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SkillTest extends TestCase
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
        Skill::factory(3)->create();

        $response = $this->getJson('/api/skills');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_store_creates_new_skill()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/skills', [
            'name' => "Laravel",
        ]);
        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Laravel']);
    }

    public function test_store_fails_with_invalid_data()
    {
        $response = $this->postJson('/api/skills', [
            'name' => '',
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_show_returns_skill()
    {

        $skill = Skill::factory()->create();

        $response = $this->getJson("/api/skills/{$skill->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $skill->name]);
    }

    public function test_show_fails_for_nonexistent_skill()
    {
        $response = $this->getJson('/api/skills/999');

        $response->assertStatus(404);
    }

    public function test_update_modifies_existing_skill()
    {
        $skill = Skill::factory()->create();

        $response = $this->putJson("/api/skills/{$skill->id}", [
            'name' => "Laravel",
        ]);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Laravel']);
    }

    public function test_update_fails_with_invalid_data()
    {

        $skill = Skill::factory()->create();

        $response = $this->putJson("/api/skills/{$skill->id}", [
            'name' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    public function test_destroy_removes_skill()
    {
        $skill = Skill::factory()->create();

        $response = $this->deleteJson("/api/skills/{$skill->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('skills', ['id' => $skill->id]);
    }

    public function test_destroy_fails_for_nonexistent_skill()
    {
        $response = $this->deleteJson('/api/skills/999');

        $response->assertStatus(404);
    }
}
