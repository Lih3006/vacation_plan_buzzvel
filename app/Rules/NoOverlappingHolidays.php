<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\HolidayPlan;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class NoOverlappingHolidays implements ValidationRule
{
    private $date_from;
    private $date_to;

    public function __construct($date_from, $date_to)
    {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = HolidayPlan::where(function ($query) {
            $query->where(function ($query) {
                $query->where('date_from', '<=', $this->date_to)->where('date_to', '>=', $this->date_to);
            })->orWhere(function ($query) {
                $query->where('date_from', '<=', $this->date_from)->where('date_to', '>=', $this->date_from);
            });
        })->exists();

        if ($exists) {
            $fail('The holiday dates overlap with existing holidays');
        }
    }
}
