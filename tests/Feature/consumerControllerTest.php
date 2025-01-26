<?php

namespace Tests\Feature;

use App\ConsumerType;
use Tests\TestCase;
use App\Models\consumer;
use App\Models\User;
use App\StatusType;
use App\UserType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class consumerControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_return_all_consumers_with_success_message()
    {
        // Arrange: Create a user and an associated consumer
        $user = User::create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'type' => 'CONSUMER',
        ]);

        $consumer = consumer::create([
            'user_id' => $user->id,
            'phone_no' => '1234567890',
            'type' => ConsumerType::Customer->value,
            'nic' => '1234567890',
            'business_no' => null,
            'status' => StatusType::Approved->value
        ]);

        // Act: Call the index method
        $response = $this->withoutMiddleware()->get('/api/v1/consumer');

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJsonFragment([
                'status' => true,
                'message' => 'consumer retrieved successfully',
                'data' => [
                    [
                        'user_id' => $user->id,
                        'type' => $user->type,
                        'user_email' => $user->email,
                        'id' => $consumer->id,
                        'nic' => $consumer->nic,
                        'phone_no' => $consumer->phone_no,
                        'type' => $consumer->type,
                        'business_no' => $consumer->business_no,
                        'status' => $consumer->status,
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_should_return_error_if_no_consumers_found()
    {
        // Act: Call the index method when no consumers exist
        $response = $this->withoutMiddleware()->get('/api/v1/consumer');

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'consumer retrieved successfully',
                'data' => []
            ]);
    }

    /** @test */
    public function it_should_return_success_response_if_consumer_delete_success()
    {
        // Arrange: Create a user and an associated consumer
        $user = User::create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'type' => 'CONSUMER',
        ]);

        $consumer = consumer::create([
            'user_id' => $user->id,
            'phone_no' => '1234567890',
            'type' => ConsumerType::Customer->value,
            'nic' => '1234567890',
            'business_no' => null,
            'status' => StatusType::Approved->value
        ]);

        // Act: Call the index method when no consumers exist
        $response = $this->withoutMiddleware()->delete('/api/v1/consumer/' . $consumer->id);

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Consumer user deleted successfully'
            ]);
    }

    /** @test */
    public function it_should_return_consumer_with_success_message_when_search_by_id()
    {
        // Arrange: Create a user and an associated consumer
        $user = User::create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'type' => 'CONSUMER',
        ]);

        $consumer = consumer::create([
            'user_id' => $user->id,
            'phone_no' => '123454367890',
            'type' => ConsumerType::Customer->value,
            'nic' => '123456767890',
            'business_no' => null,
            'status' => StatusType::Approved->value
        ]);

        // Act: Call the index method
        $response = $this->withoutMiddleware()->get('/api/v1/consumer/' . $consumer->id);

        // Assert: Verify the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'consumer retrieved successfully',
                'data' => [
                    'user_id' => $user->id,
                    'type' => $user->type,
                    'user_email' => $user->email,
                    'id' => $consumer->id,
                    'nic' => $consumer->nic,
                    'phone_no' => $consumer->phone_no,
                    'type' => $consumer->type,
                    'business_no' => $consumer->business_no,
                    'status' => $consumer->status,
                ]
            ]);
    }
}
