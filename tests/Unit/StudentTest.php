<?php

namespace Tests\Unit;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

//    protected function setUp(): void
//    {
//        parent::setUp();
//
//        // Create a user and authenticate
//        $user = Student::factory()->create();
//        Sanctum::actingAs($user);
//    }

//    public function test_index_returns_successful_response()
//    {
//        Student::factory(3)->make();
//
//        $response = $this->getJson('/api/students');
//
//        $response->assertStatus(200)
//            ->assertJsonCount(3);
//    }

    public function test_store_creates_new_student()
    {
        $student = Student::factory()->create();
        $response = $this->postJson('/api/student', [
            'last_name' => 'New Student',
            'first_name' => 'John',
            'nt_id' => 100123,
            'image' => null,
            'phone' => '+998912345678',
            'profession' => 'Engineer',
            'biography' => 'This is a sample biography',
        ]);
        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'New Student']);
    }
//
//    public function test_store_fails_with_invalid_data()
//    {
//        $response = $this->postJson('/api/products', [
//            'name' => '',
//
//        ]);
//        $response->assertStatus(422)
//            ->assertJsonValidationErrors('name');
//    }
//
//    public function test_show_returns_product()
//    {
//        $product = Student::factory()->create();
//
//        $response = $this->getJson("/api/products/$product->id");
//
//        $response->assertStatus(200)
//            ->assertJsonFragment(['name' => $product->name]);
//    }
//
//    public function test_show_fails_for_nonexistent_product()
//    {
//        $response = $this->getJson('/api/products/8');
//
//        $response->assertStatus(404);
//    }
//
//    public function test_update_modifies_existing_product()
//    {
//        $product = Student::factory()->create();
//
//        $response = $this->putJson("/api/products/{$product->id}", [
//            'name' => 'Updated Student',
//            'description' => 'This is a new product',
//            'price' => 100,
//            'category_id' => $product->category_id,
//        ]);
//        $response->assertStatus(200)
//            ->assertJsonFragment(['name' => 'Updated Student']);
//    }
//
//    public function test_update_fails_with_invalid_data()
//    {
//        $product = Student::factory()->create();
//
//        $response = $this->putJson("/api/products/$product->id", [
//            'name' => '', // Invalid name
//        ]);
//
//        $response->assertStatus(422)
//            ->assertJsonValidationErrors('name');
//    }
//
//    public function test_destroy_removes_product()
//    {
//        $product = Student::factory()->create();
//
//        $response = $this->deleteJson("/api/products/{$product->id}");
//
//        $response->assertStatus(204);
//        $this->assertDatabaseMissing('products', ['id' => $product->id]);
//    }
//
//    public function test_destroy_fails_for_nonexistent_product()
//    {
//        $response = $this->deleteJson('/api/categories/999');
//
//        $response->assertStatus(404);
//    }

}
