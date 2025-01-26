<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\schedule;
use App\Models\outlet;
use App\StatusType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class scheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_return_all_schedules_with_success_message()
    {
        // Arrange: Create a outlet and an associated schedule
        $outlet = outlet::create([
            'email' => 'abc@gmail.com',
            'name' => 'abc',
            'phone_no' => '1234567890',
            'address' => 'qwertyuio'
        ]);

        $schedule = schedule::create([
            'outlet_id' => $outlet->id,
            'schedule_date' => date('Y-m-d', strtotime(now() . ' + 20 days')),
            'max_quantity' => 100,
            'available_quantity' => 100,
            'status' => StatusType::Pending->value
        ]);

        // Act: Call the index method
        $response = $this->withoutMiddleware()->get('/api/v1/schedule');

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Schedules retrieved successfully',
                'data' => [
                    [
                        'outlet_id' => $outlet->id,
                        'email' => $outlet->email,
                        'id' => $schedule->id,
                        'name' => $outlet->name,
                        'schedule_date' => $schedule->schedule_date,
                        'max_quantity' => $schedule->max_quantity,
                        'available_quantity' => $schedule->available_quantity,
                        'status' => $schedule->status
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_should_return_empty_if_no_schedules_found()
    {
        // Act: Call the index method when no schedules exist
        $response = $this->withoutMiddleware()->get('/api/v1/schedule');

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Schedules retrieved successfully',
                'data' => []
            ]);
    }

    /** @test */
    public function it_should_return_success_response_if_schedule_delete_success()
    {
        // Arrange: Create a outlet and an associated schedule
        $outlet = outlet::create([
            'email' => 'abc@gmail.com',
            'name' => 'abc',
            'phone_no' => '1234567890',
            'address' => 'qwertyuio'
        ]);

        $schedule = schedule::create([
            'outlet_id' => $outlet->id,
            'schedule_date' => date('Y-m-d', strtotime(now() . ' + 20 days')),
            'max_quantity' => 100,
            'available_quantity' => 100,
            'status' => StatusType::Pending->value
        ]);

        $response = $this->withoutMiddleware()->delete('/api/v1/schedule/' . $schedule->id);

        // Assert: Verify the response
        $response->assertStatus(204);
    }

    /** @test */
    public function it_should_return_success_response_if_schedule_update_success()
    {
        // Arrange: Create a outlet and an associated schedule
        $outlet = outlet::create([
            'email' => 'abc@gmail.com',
            'name' => 'abc',
            'phone_no' => '1234567890',
            'address' => 'qwertyuio'
        ]);

        $schedule = schedule::create([
            'outlet_id' => $outlet->id,
            'schedule_date' => date('Y-m-d', strtotime(now() . ' + 20 days')),
            'max_quantity' => 100,
            'available_quantity' => 100,
            'status' => StatusType::Pending->value
        ]);

        $response = $this->withoutMiddleware()->put('/api/v1/schedule/' . $schedule->id, [
            'schedule_date' => date('Y-m-d', strtotime(now() . ' + 22 days')),
            'max_quantity' => 80,
            'status' => StatusType::Pending->value
        ]);

        // Assert: Verify the response
        $response->assertStatus(201);
    }

    /** @test */
    public function it_should_return_schedule_with_success_message_when_search_by_id()
    {
        // Arrange: Create a outlet and an associated schedule
        $outlet = outlet::create([
            'email' => 'abc@gmail.com',
            'name' => 'abc',
            'phone_no' => '1234567890',
            'address' => 'qwertyuio'
        ]);

        $schedule = schedule::create([
            'outlet_id' => $outlet->id,
            'schedule_date' => date('Y-m-d', strtotime(now() . ' + 20 days')),
            'max_quantity' => 100,
            'available_quantity' => 100,
            'status' => StatusType::Pending->value
        ]);

        // Act: Call the index method
        $response = $this->withoutMiddleware()->get('/api/v1/schedule/' . $schedule->id);

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Schedule found successfully',
                'data' => [
                    'outlet_id' => $outlet->id,
                    'out_phone_no' => $outlet->phone_no,
                    'out_address' => $outlet->address,
                    'out_email' => $outlet->email,
                    'id' => $schedule->id,
                    'out_name' => $outlet->name,
                    'schedule_date' => $schedule->schedule_date,
                    'max_quantity' => $schedule->max_quantity,
                    'available_quantity' => $schedule->available_quantity,
                    'status' => $schedule->status
                ]
            ]);
    }

    /** @test */
    public function it_should_return_schedule_with_success_message_when_search_by_outlet_id()
    {
        // Arrange: Create a outlet and an associated schedule
        $outlet = outlet::create([
            'email' => 'abc@gmail.com',
            'name' => 'abc',
            'phone_no' => '1234567890',
            'address' => 'qwertyuio'
        ]);

        $schedule = schedule::create([
            'outlet_id' => $outlet->id,
            'schedule_date' => date('Y-m-d', strtotime(now() . ' + 20 days')),
            'max_quantity' => 100,
            'available_quantity' => 100,
            'status' => StatusType::Pending->value
        ]);

        // Act: Call the index method
        $response = $this->withoutMiddleware()->get('/api/v1/schedule/outlet/' . $outlet->id);

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Schedules found successfully',
                'data' => [
                    [
                        'outlet_id' => $outlet->id,
                        'out_phone_no' => $outlet->phone_no,
                        'out_address' => $outlet->address,
                        'out_email' => $outlet->email,
                        'id' => $schedule->id,
                        'out_name' => $outlet->name,
                        'schedule_date' => $schedule->schedule_date,
                        'max_quantity' => $schedule->max_quantity,
                        'available_quantity' => $schedule->available_quantity,
                        'status' => $schedule->status
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_should_return_success_status_when_create_new_schedule()
    {
        // Arrange: Create a outlet and an associated schedule
        $outlet = outlet::create([
            'email' => 'abc@gmail.com',
            'name' => 'abc',
            'phone_no' => '1234567890',
            'address' => 'qwertyuio'
        ]);

        // Act: Call the index method
        $response = $this->withoutMiddleware()->post('/api/v1/schedule', [
            'outlet_id' => $outlet->id,
            'schedule_date' => date('Y-m-d', strtotime(now() . ' + 20 days')),
            'max_quantity' => 100,
            'available_quantity' => 100,
        ]);

        // Assert: Verify the response
        $response->assertStatus(201)
            ->assertJson([
                'status' => true,
                'message' => 'Schedule created successfully',
                'data' => [
                    'outlet_id' => $outlet->id,
                    'id' => 9,
                    'schedule_date' => date('Y-m-d', strtotime(now() . ' + 20 days')),
                    'max_quantity' => 100,
                    'available_quantity' => 100,
                    'status' => StatusType::Pending->value
                ]
            ]);
    }
}
