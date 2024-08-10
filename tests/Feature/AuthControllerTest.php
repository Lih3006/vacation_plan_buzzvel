<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

final class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegister():void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@mail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(201);
        $response->assertJsonStructure(['user', 'token']);
    }

    public function testLogin():void
    {
        $user = User::factory()->create([
            'email' => 'john@mail.com',
            'password' => Hash::make('password'),
        ]);

        $loginData = [
            'email' => 'john@mail.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/login', $loginData);

        $response->assertStatus(200);
        $response->assertJsonStructure(['user', 'token']);
    }

    public function testLogout():void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/logout');

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Logged out']);
    }
}
