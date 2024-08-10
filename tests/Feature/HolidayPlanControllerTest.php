<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\HolidayPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class HolidayPlanControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexWithAuthentication():void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])->getJson('/api/holidays');

        $response->assertStatus(200);
    }

    public function testStoreWithAuthentication():void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $holidayPlanData = [
            'title' => 'Holiday Plan 1',
            'description' => 'Description for Holiday Plan 1',
            'date_from' => '2024-12-25',
            'date_to' => '2025-01-01',
            'location' => 'New York, USA',];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])->postJson('/api/holidays', $holidayPlanData);
        $response->assertStatus(201);

    }

    public function testShowWithAuthentication():void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;
        $holidayPlan = HolidayPlan::create([
            'title' => 'Holiday Plan 1',
            'description' => 'Description for Holiday Plan 1',
            'date_from' => '2024-12-25',
            'date_to' => '2025-01-01',
            'location' => 'New York, USA',
            'user_id' => $user->id
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])->getJson('/api/holidays/' . $holidayPlan->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'title', 'description', 'date_from', 'date_to', 'location', 'user_id', 'status']);
    }

    public function testUpdateWithAuthentication():void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;
        $holidayPlan = HolidayPlan::create([
            'title' => 'Holiday Plan 1',
            'description' => 'Description for Holiday Plan 1',
            'date_from' => '2024-12-25',
            'date_to' => '2025-01-01',
            'location' => 'New York, USA',
            'user_id' => $user->id]);

        $updatedData = ['title' => 'Updated Holiday Plan', 'description' => 'Updated description', 'date_from' => '2025-01-10', 'date_to' => '2025-01-16', 'location' => 'Los Angeles, USA',];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])->putJson('/api/holidays/' . $holidayPlan->id, $updatedData);

        $response->assertStatus(200);

        $response->assertJsonStructure(['id', 'title', 'description', 'date_from', 'date_to', 'location', 'user_id', 'status']);
    }

    public function testDestroyWithAuthentication():void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;
        $holidayPlan = HolidayPlan::create([
            'title' => 'Holiday Plan 1',
            'description' => 'Description for Holiday Plan 1',
            'date_from' => '2024-12-25',
            'date_to' => '2025-01-01',
            'location' => 'New York, USA',
            'user_id' => $user->id]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])->deleteJson('/api/holidays/' . $holidayPlan->id);
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Holiday plan deleted successfully']);
    }
}
