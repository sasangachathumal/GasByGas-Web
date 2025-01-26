<?php

namespace Tests\Feature;

use App\ConsumerType;
use Tests\TestCase;
use App\Models\requestModel;
use App\Models\consumer;
use App\Models\gas;
use App\Models\outlet;
use App\Models\outlet_manager;
use App\Models\schedule;
use App\Models\User;
use App\RequestStatusType;
use App\RequestType;
use App\StatusType;
use App\UserType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class requestControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_return_all_requests_with_success_message()
    {
        // Arrange: Create a user and an associated consumer
        $user = User::create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'type' => 'CONSUMER',
        ]);

        $outlet = outlet::create([
            'email' => 'abc@gmail.com',
            'name' => 'abc',
            'phone_no' => '12323567890',
            'address' => 'qwertyuio'
        ]);

        $schedule = schedule::create([
            'outlet_id' => $outlet->id,
            'schedule_date' => date('Y-m-d', strtotime(now() . ' + 20 days')),
            'max_quantity' => 100,
            'available_quantity' => 100,
            'status' => StatusType::Pending->value
        ]);

        $gas = gas::create([
            'weight' => '2KG',
            'price' => 2000,
        ]);

        $consumer = consumer::create([
            'user_id' => $user->id,
            'phone_no' => '1254327890',
            'type' => ConsumerType::Customer->value,
            'nic' => '1234567890',
            'business_no' => null,
            'status' => StatusType::Approved->value
        ]);

        $token = 'GAS-' . Str::random(3) . '-' . Str::random(3);

        $newRequest = requestModel::create([
            'schedule_id' => $schedule->id,
            'gas_id' => $gas->id,
            'consumer_id' => $consumer->id,
            'type' => RequestType::Customer->value,
            'quantity' => 1,
            'status' => RequestStatusType::Pending->value,
            'expired_at' => date('Y-m-d', strtotime(now() . ' + 14 days')),
            'token' => $token
        ]);

        // Act: Call the index method
        $response = $this->withoutMiddleware()->get('/api/v1/request');

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Requests retrieved successfully',
                'data' => [
                    [
                        'request' => [
                            'id' => $newRequest->id,
                            'schedule_id' => $newRequest->schedule_id,
                            'gas_id' => $newRequest->gas_id,
                            'consumer_id' => $newRequest->consumer_id,
                            'type' => $newRequest->type,
                            'quantity' => $newRequest->quantity,
                            'status' => $newRequest->status,
                            'expired_at' => $newRequest->expired_at,
                            'token' => $newRequest->token
                        ],
                        'gas' => [
                            'id' => $gas->id,
                            'weight' => $gas->weight,
                            'price' => $gas->price,
                        ],
                        'consumer' => [
                            'user_id' => $user->id,
                            'email' => $user->email,
                            'id' => $consumer->id,
                            'nic' => $consumer->nic,
                            'phone_no' => $consumer->phone_no,
                            'type' => $consumer->type,
                            'business_no' => $consumer->business_no,
                            'status' => $consumer->status,
                        ],
                        'schedule' => [
                            'outlet_id' => $outlet->id,
                            'id' => $schedule->id,
                            'schedule_date' => $schedule->schedule_date,
                            'max_quantity' => $schedule->max_quantity,
                            'available_quantity' => $schedule->available_quantity,
                            'status' => $schedule->status
                        ],
                        'outlet' => [
                            'id' => $outlet->id,
                            'email' => $outlet->email,
                            'name' => $outlet->name,
                            'phone_no' => $outlet->phone_no,
                            'address' => $outlet->address,
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_should_return_empty_response_if_no_schedules_found()
    {
        // Act: Call the index method when no schedule exist
        $response = $this->withoutMiddleware()->get('/api/v1/request');

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Requests retrieved successfully',
                'data' => []
            ]);
    }

    /** @test */
    public function it_should_return_success_response_if_schedule_status_update_success()
    {
        // Arrange: Create a user and an associated consumer
        $user = User::create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'type' => 'CONSUMER',
        ]);

        $outlet = outlet::create([
            'email' => 'abc@gmail.com',
            'name' => 'abc',
            'phone_no' => '12323567890',
            'address' => 'qwertyuio'
        ]);

        $schedule = schedule::create([
            'outlet_id' => $outlet->id,
            'schedule_date' => date('Y-m-d', strtotime(now() . ' + 20 days')),
            'max_quantity' => 100,
            'available_quantity' => 100,
            'status' => StatusType::Pending->value
        ]);

        $gas = gas::create([
            'weight' => '2KG',
            'price' => 2000,
        ]);

        $consumer = consumer::create([
            'user_id' => $user->id,
            'phone_no' => '1254327890',
            'type' => ConsumerType::Customer->value,
            'nic' => '1234567890',
            'business_no' => null,
            'status' => StatusType::Approved->value
        ]);

        $token = 'GAS-' . Str::random(3) . '-' . Str::random(3);

        $newRequest = requestModel::create([
            'schedule_id' => $schedule->id,
            'gas_id' => $gas->id,
            'consumer_id' => $consumer->id,
            'type' => RequestType::Customer->value,
            'quantity' => 1,
            'status' => RequestStatusType::Pending->value,
            'expired_at' => date('Y-m-d', strtotime(now() . ' + 14 days')),
            'token' => $token
        ]);

        $response = $this->withoutMiddleware()->put('/api/v1/request/status/' . $newRequest->id, [
            'status' => RequestStatusType::Paid->value,
        ]);

        // Assert: Verify the response
        $response->assertStatus(201);
    }

    /** @test */
    public function it_should_return_success_response_if_schedule_re_assign_success()
    {
        // Arrange: Create a user and an associated consumer
        $user = User::create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'type' => 'CONSUMER',
        ]);

        $user2 = User::create([
            'email' => 'testuse2r@example.com',
            'password' => bcrypt('password'),
            'type' => 'CONSUMER',
        ]);

        $outlet = outlet::create([
            'email' => 'abc@gmail.com',
            'name' => 'abc',
            'phone_no' => '12323567890',
            'address' => 'qwertyuio'
        ]);

        $schedule = schedule::create([
            'outlet_id' => $outlet->id,
            'schedule_date' => date('Y-m-d', strtotime(now() . ' + 20 days')),
            'max_quantity' => 100,
            'available_quantity' => 100,
            'status' => StatusType::Pending->value
        ]);

        $gas = gas::create([
            'weight' => '2KG',
            'price' => 2000,
        ]);

        $consumer = consumer::create([
            'user_id' => $user->id,
            'phone_no' => '1254327890',
            'type' => ConsumerType::Customer->value,
            'nic' => '1234567890',
            'business_no' => null,
            'status' => StatusType::Approved->value
        ]);

        $consumer2 = consumer::create([
            'user_id' => $user2->id,
            'phone_no' => '125433427890',
            'type' => ConsumerType::Customer->value,
            'nic' => '123456767890',
            'business_no' => null,
            'status' => StatusType::Approved->value
        ]);

        $token = 'GAS-' . Str::random(3) . '-' . Str::random(3);

        $newRequest = requestModel::create([
            'schedule_id' => $schedule->id,
            'gas_id' => $gas->id,
            'consumer_id' => $consumer->id,
            'type' => RequestType::Customer->value,
            'quantity' => 1,
            'status' => RequestStatusType::Pending->value,
            'expired_at' => date('Y-m-d', strtotime(now() . ' + 14 days')),
            'token' => $token
        ]);

        $response = $this->withoutMiddleware()->put('/api/v1/request/consumer/' . $newRequest->id, [
            'consumer_id' => $consumer2->id,
        ]);

        // Assert: Verify the response
        $response->assertStatus(201);
    }
}
