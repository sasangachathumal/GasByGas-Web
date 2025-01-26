<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class authenticationControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_login_successfully()
    {
        // Arrange: Create a test user
        $user = User::create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'type' => 'ADMIN',
        ]);

        // Act: Send login request
        $response = $this->withoutMiddleware()->postJson('/api/v1/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Assert: Check the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Login successful',
            ]);
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_should_fail_login_with_invalid_credentials()
    {
        // Act: Send login request with invalid credentials
        $response = $this->withoutMiddleware()->postJson('/api/v1/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);

        // Assert: Check the response
        $response->assertStatus(422); // Validation failed
        $this->assertGuest();
    }

    /** @test */
    public function it_should_reset_password_successfully()
    {
        // Arrange: Create a test user
        $user = User::create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Simulate password reset token
        $token = Password::createToken($user);

        // Act: Reset the password
        $response = $this->withoutMiddleware()->postJson('/api/v1/reset-password', [
            'token' => $token,
            'email' => 'test@example.com',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        // Assert: Check the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => trans(Password::PASSWORD_RESET),
            ]);

        // Verify the password is updated
        $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
    }


    /** @test */
    public function it_should_logout_successfully()
    {
        // Arrange: Create and authenticate a test user
        $user = User::create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($user);

        // Act: Call the logout route
        $response = $this->withoutMiddleware()->postJson('/api/v1/logout');

        // Assert: Check the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Logged out successfully',
            ]);
        $this->assertGuest();
    }
}
