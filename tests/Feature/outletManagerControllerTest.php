<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\outlet_manager;
use App\Models\outlet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class outletManagerControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_return_all_managers_with_success_message()
    {
        // Arrange: Create a user and an associated manager
        $user = User::create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'type' => 'OUTLET_MANAGER',
        ]);

        $outlet = outlet::create([
            'email' => 'abc@gmail.com',
            'name' => 'abc',
            'phone_no' => '1234567890',
            'address' => 'qwertyuio'
        ]);

        $manager = outlet_manager::create([
            'user_id' => $user->id,
            'outlet_id' => $outlet->id,
            'name' => 'kumara',
            'phone_no' => '1234567890',
        ]);

        // Act: Call the index method
        $response = $this->withoutMiddleware()->get('/api/v1/outletManager');

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'outlet manager retrieved successfully',
                'data' => [
                    [
                        'user_id' => $user->id,
                        'outlet_name' => $outlet->name,
                        'user_email' => $user->email,
                        'id' => $manager->id,
                        'name' => $manager->name,
                        'phone_no' => $manager->phone_no,
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_should_return_error_if_no_manages_found()
    {
        // Act: Call the index method when no managers exist
        $response = $this->withoutMiddleware()->get('/api/v1/outletManager');

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'outlet manager retrieved successfully',
                'data' => []
            ]);
    }

    /** @test */
    public function it_should_return_success_response_if_manager_delete_success()
    {
        // Arrange: Create a user and an associated manager
        $user = User::create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'type' => 'OUTLET_MANAGER',
        ]);

        $outlet = outlet::create([
            'email' => 'abc@gmail.com',
            'name' => 'abc',
            'phone_no' => '1234567890',
            'address' => 'qwertyuio'
        ]);

        $manager = outlet_manager::create([
            'user_id' => $user->id,
            'outlet_id' => $outlet->id,
            'name' => 'kumara',
            'phone_no' => '1234567890',
        ]);

        $response = $this->withoutMiddleware()->delete('/api/v1/outletManager/' . $manager->id);

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'outlet manager deleted successfully'
            ]);
    }

    /** @test */
    public function it_should_return_success_response_if_manager_update_success()
    {
        // Arrange: Create a user and an associated manager
        $user = User::create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'type' => 'OUTLET_MANAGER',
        ]);

        $outlet = outlet::create([
            'email' => 'abc@gmail.com',
            'name' => 'abc',
            'phone_no' => '1234567890',
            'address' => 'qwertyuio'
        ]);

        $manager = outlet_manager::create([
            'user_id' => $user->id,
            'outlet_id' => $outlet->id,
            'name' => 'kumara',
            'phone_no' => '1234567890',
        ]);

        $response = $this->withoutMiddleware()->put('/api/v1/outletManager/' . $manager->id, [
            'name' => 'aravinda',
            'phone_no' => '1234567890'
        ]);

        // Assert: Verify the response
        $response->assertStatus(201);
    }

    /** @test */
    public function it_should_return_manager_with_success_message_when_search_by_id()
    {
        // Arrange: Create a user and an associated manager
        $user = User::create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'type' => 'OUTLET_MANAGER',
        ]);

        $outlet = outlet::create([
            'email' => 'abc@gmail.com',
            'name' => 'abc',
            'phone_no' => '1234567890',
            'address' => 'qwertyuio'
        ]);

        $manager = outlet_manager::create([
            'user_id' => $user->id,
            'outlet_id' => $outlet->id,
            'name' => 'kumara',
            'phone_no' => '1234567890',
        ]);

        // Act: Call the index method
        $response = $this->withoutMiddleware()->get('/api/v1/outletManager/' . $manager->id);

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'outlet manager retrieved successfully',
                'data' => [
                    'user_id' => $user->id,
                    'outlet_name' => $outlet->name,
                    'user_email' => $user->email,
                    'id' => $manager->id,
                    'name' => $manager->name,
                    'phone_no' => $manager->phone_no,
                ]
            ]);
    }

    /** @test */
    public function it_should_return_success_status_when_create_new_manager()
    {
        $outlet = outlet::create([
            'email' => 'abc@gmail.com',
            'name' => 'abc',
            'phone_no' => '1234567890',
            'address' => 'qwertyuio'
        ]);

        $response = $this->withoutMiddleware()->post('/api/v1/outletManager', [
            'email' => 'testuser@example.com',
            'outlet_id' => $outlet->id,
            'name' => 'sandeepa',
            'phone_no' => '0912340678',
        ]);

        // Assert: Verify the response
        $response->assertStatus(201)
            ->assertJson([
                'status' => true,
                'message' => 'outlet manager created successfully',
                'data' => [
                    'user_id' => 16,
                    'id' => 5,
                    'name' => 'sandeepa',
                    'phone_no' => '0912340678',
                    'outlet_id' => $outlet->id
                ]
            ]);
    }
}
