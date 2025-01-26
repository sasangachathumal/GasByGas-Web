<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\gas;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class gasControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_return_all_gas_with_success_message()
    {

        $gas = gas::create([
            'weight' => '2KG',
            'price' => 2000,
        ]);

        // Act: Call the index method
        $response = $this->withoutMiddleware()->get('/api/v1/gas');

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Gas retrieved successfully',
                'data' => [
                    [
                        'id' => $gas->id,
                        'weight' => $gas->weight,
                        'price' => $gas->price,
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_should_return_error_if_no_Gas_found()
    {
        // Act: Call the index method when no Gas exist
        $response = $this->withoutMiddleware()->get('/api/v1/gas');

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Gas retrieved successfully',
                'data' => []
            ]);
    }

    /** @test */
    public function it_should_return_success_response_if_gas_update_success()
    {
        // Arrange: Create a gas and an associated gas
        $gas = gas::create([
            'weight' => '2KG',
            'price' => 2000,
        ]);

        // Act: Call the index method when no gas exist
        $response = $this->withoutMiddleware()->put('/api/v1/gas/' . $gas->id, [
            'weight' => '3KG'
        ]);

        // Assert: Verify the response
        $response->assertStatus(201);
    }

    /** @test */
    public function it_should_return_gas_with_success_message_when_search_by_id()
    {
        // Arrange: Create a gas and an associated gas
        $gas = gas::create([
            'weight' => '2KG',
            'price' => 2000,
        ]);

        // Act: Call the index method
        $response = $this->withoutMiddleware()->get('/api/v1/gas/' . $gas->id);

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Gas found successfully',
                'data' => [
                    'id' => $gas->id,
                    'weight' => $gas->weight,
                    'price' => 2000.00,
                ]
            ]);
    }

    /** @test */
    public function it_should_return_success_status_when_create_new_gas()
    {

        // Act: Call the index method
        $response = $this->withoutMiddleware()->post('/api/v1/gas', [
            'weight' => '2KG',
            'price' => 2000,
        ]);

        // Assert: Verify the response
        $response->assertStatus(201)
            ->assertJson([
                'status' => true,
                'message' => 'Gas created successfully',
                'data' => [
                    'id' => '4',
                    'weight' => '2KG',
                    'price' => 2000,
                ]
            ]);
    }
}
