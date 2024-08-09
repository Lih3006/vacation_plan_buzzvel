<?php

namespace App\Http\Requests;


use App\Rules\NoOverlappingHolidays;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreHolidayPlanRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array

    {
        $date_from = $this->input('date_from');
        $date_to = $this->input('date_to');
        $user_id = auth()->id();

        return ['title' => ['required', 'string'], 'description' => ['required', 'string'], 'date_to' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:date_from', new NoOverlappingHolidays($date_from, $date_to, $user_id)], 'date_from' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:today', 'before_or_equal:date_to', new NoOverlappingHolidays($date_from, $date_to, $user_id)], 'location' => ['required', 'string'],

        ];
    }

    public function messages(): array
    {
        return ['title.required' => 'Title is required', 'description.required' => 'Description is required', 'date_from.required' => 'Date from is required', 'date_from.after_or_equal' => 'Date from must be after or equal to today', 'date_from.before_or_equal' => 'Date from must be before or equal to date to', 'date_to.required' => 'Date to is required', 'date_to.after_or_equal' => 'Date to must be after or equal to date from', 'date_from.format' => 'Date from must be in format Y-m-d', 'date_to.format' => 'Date to must be in format Y-m-d', 'location.required' => 'Location is required',];
    }


}
