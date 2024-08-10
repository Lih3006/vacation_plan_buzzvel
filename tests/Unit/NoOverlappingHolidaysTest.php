<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\HolidayPlan;
use App\Rules\NoOverlappingHolidays;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class NoOverlappingHolidaysTest extends TestCase
{
    use RefreshDatabase;

    public function test_overlap(): void
    {
        // Create a user and authenticate
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        // Create a HolidayPlan
        $holidayPlan = HolidayPlan::create([
            'title' => 'Christmas Holiday',
            'description' => 'Christmas holiday plan',
            'date_from' => '2024-12-25',
            'date_to' => '2025-01-01',
            'location' => 'New York, USA',
            'user_id' => $user->id
        ]);

        // Create a NoOverlappingHolidays rule
        $rule = new NoOverlappingHolidays('2024-12-30', '2025-01-10');

        // Define a closure to handle the validation failure
        $fail = function ($message) {
            $this->fail($message);
        };

        // Call the validate method and expect it to fail
        try {
            $rule->validate('date', '2024-12-30', $fail);
        } catch (\Exception $e) {
            $this->assertEquals('The holiday dates overlap with existing holidays', $e->getMessage());
        }
    }
}
