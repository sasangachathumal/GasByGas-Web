<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class adminControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_return_all_admins_with_success_message()
    {
        // Arrange: Create a user and an associated admin
        $user = User::create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'type' => 'ADMIN',
        ]);

        $admin = Admin::create([
            'user_id' => $user->id,
            'name' => 'kumara',
            'phone_no' => '1234567890',
        ]);

        // Act: Call the index method
        $response = $this->withoutMiddleware()->get('/api/v1/admin');

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Admins retrieved successfully',
                'data' => [
                    [
                        'user_id' => $user->id,
                        'type' => $user->type,
                        'email' => $user->email,
                        'id' => $admin->id,
                        'name' => $admin->name,
                        'phone_no' => $admin->phone_no,
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_should_return_error_if_no_admins_found()
    {
        // Act: Call the index method when no admins exist
        $response = $this->withoutMiddleware()->get('/api/v1/admin');

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Admins retrieved successfully',
                'data' => []
            ]);
    }

    /** @test */
    public function it_should_return_success_response_if_admin_delete_success()
    {
        // Arrange: Create a user and an associated admin
        $user = User::create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'type' => 'ADMIN',
        ]);

        $admin = Admin::create([
            'user_id' => $user->id,
            'name' => 'kumara',
            'phone_no' => '1234567890',
        ]);

        // Act: Call the index method when no admins exist
        $response = $this->withoutMiddleware()->delete('/api/v1/admin/' . $admin->id);

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Admin user deleted successfully'
            ]);
    }

    /** @test */
    public function it_should_return_success_response_if_admin_update_success()
    {
        // Arrange: Create a user and an associated admin
        $user = User::create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'type' => 'ADMIN',
        ]);

        $admin = Admin::create([
            'user_id' => $user->id,
            'name' => 'kumara',
            'phone_no' => '1234567890',
        ]);

        // Act: Call the index method when no admins exist
        $response = $this->withoutMiddleware()->put('/api/v1/admin/' . $admin->id, [
            'name' => 'sandeepa',
            'phone_no' => '0912345678',
        ]);

        // Assert: Verify the response
        $response->assertStatus(201);
    }

    /** @test */
    public function it_should_return_admin_with_success_message_when_search_by_id()
    {
        // Arrange: Create a user and an associated admin
        $user = User::create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'type' => 'ADMIN',
        ]);

        $admin = Admin::create([
            'user_id' => $user->id,
            'name' => 'kumara',
            'phone_no' => '1234567890',
        ]);

        // Act: Call the index method
        $response = $this->withoutMiddleware()->get('/api/v1/admin/' . $admin->id);

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Admin retrieved successfully',
                'data' => [
                    'user_id' => $user->id,
                    'user_type' => $user->type,
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'phone_no' => $admin->phone_no,
                ]
            ]);
    }

    /** @test */
    public function it_should_return_success_status_when_create_new_admin()
    {

        // Act: Call the index method
        $response = $this->withoutMiddleware()->post('/api/v1/admin', [
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'type' => 'ADMIN',
            'name' => 'sandeepa',
            'phone_no' => '0912340678',
        ]);

        // Assert: Verify the response
        $response->assertStatus(201)
            ->assertJson([
                'status' => true,
                'message' => 'Admin created successfully',
                'data' => [
                    'user_id' => '5',
                    'id' => '5',
                    'name' => 'sandeepa',
                    'phone_no' => '0912340678',
                ]
            ]);
    }
}
