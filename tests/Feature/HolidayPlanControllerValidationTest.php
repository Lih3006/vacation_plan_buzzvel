<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\HolidayPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class HolidayPlanControllerValidationTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreValidationErrors():void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        // Provide incomplete data
        $holidayPlanData = [
            'title' => '', // Empty title to cause validation error
            'description' => 'Description for Holiday Plan 1',
            'date_from' => '2024-12-25',
            'date_to' => '2025-01-01',
            'location' => 'New York, USA',
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])->postJson('/api/holidays', $holidayPlanData);

        $response->assertStatus(400); // Expecting validation error
    }

    public function testUpdateValidationErrors():void
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

        // Provide incomplete data
        $updatedData = [
            'title' => '', // Empty title to cause validation error
            'description' => 'Updated description',
            'date_from' => '2025-01-10',
            'date_to' => '2025-01-16',
            'location' => 'Los Angeles, USA',
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])->putJson('/api/holidays/' . $holidayPlan->id, $updatedData);

        $response->assertStatus(400); // Expecting validation error
    }
}
