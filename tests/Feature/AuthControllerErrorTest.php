<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

final class AuthControllerErrorTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterError(): void
    {
        // Provide incomplete data
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@mail.com',
            // 'password' => 'password', // Commented out to cause validation error
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(400); // Expecting validation error
    }

    public function testLoginError(): void
    {
        $user = User::factory()->create([
            'email' => 'john@mail.com',
            'password' => Hash::make('password'),
        ]);

        // Provide incorrect password
        $loginData = [
            'email' => 'john@mail.com',
            'password' => 'wrongpassword',
        ];

        $response = $this->postJson('/api/login', $loginData);

        $response->assertStatus(401); // Expecting unauthorized error
    }

    public function testLogoutError(): void
    {
        // Attempt to logout without being logged in
        $response = $this->postJson('/api/logout');

        $response->assertStatus(401); // Expecting unauthorized error
    }
}
