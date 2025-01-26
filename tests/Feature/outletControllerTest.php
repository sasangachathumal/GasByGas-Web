<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\outlet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class outletControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_return_all_outlets_with_success_message()
    {
        // Arrange: Create a outlet
        $outlet = outlet::create([
            'email' => 'abc@gmail.com',
            'name' => 'abc',
            'phone_no' => '1234567890',
            'address' => 'qwertyuio'
        ]);

        // Act: Call the index method
        $response = $this->withoutMiddleware()->get('/api/v1/outlet');

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Outlet retrieved successfully',
                'data' => [
                    [
                        'id' => $outlet->id,
                        'email' => $outlet->email,
                        'name' => $outlet->name,
                        'phone_no' => $outlet->phone_no,
                        'address' => $outlet->address,
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_should_return_error_if_no_outlets_found()
    {
        // Act: Call the index method when no outlets exist
        $response = $this->withoutMiddleware()->get('/api/v1/outlet');

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Outlet retrieved successfully',
                'data' => []
            ]);
    }

    /** @test */
    public function it_should_return_outlet_with_success_message_when_search_by_id()
    {
        // Arrange: Create a outlet
        $outlet = outlet::create([
            'email' => 'abc@gmail.com',
            'name' => 'abc',
            'phone_no' => '1234567890',
            'address' => 'qwertyuio'
        ]);

        $response = $this->withoutMiddleware()->get('/api/v1/outlet/' . $outlet->id);

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Outlet found successfully',
                'data' => [
                    'id' => $outlet->id,
                    'email' => $outlet->email,
                    'name' => $outlet->name,
                    'phone_no' => $outlet->phone_no,
                    'address' => $outlet->address,
                ]
            ]);
    }

    /** @test */
    public function it_should_return_success_status_when_create_new_outlet()
    {

        $response = $this->withoutMiddleware()->post('/api/v1/outlet', [
            'email' => 'abc@gmail.com',
            'name' => 'abc',
            'phone_no' => '1234567890',
            'address' => 'qwertyuio'
        ]);

        // Assert: Verify the response
        $response->assertStatus(201)
            ->assertJson([
                'status' => true,
                'message' => 'Outlet created successfully',
                'data' => [
                    'id' => '3',
                    'email' => 'abc@gmail.com',
                    'name' => 'abc',
                    'phone_no' => '1234567890',
                    'address' => 'qwertyuio'
                ]
            ]);
    }
}
