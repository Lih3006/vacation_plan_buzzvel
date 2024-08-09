<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules;


class StoreAuthRequest extends BaseRequest
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
        return ['name' => ['required', 'string', 'max:255'], 'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class], 'password' => ['required', 'confirmed', Rules\Password::defaults()],];


    }

    public function messages(): array
    {
        return ['name.required' => 'Name is required', 'name.string' => 'Name must be a string', 'name.max' => 'Name must not be greater than 255 characters', 'email.required' => 'Email is required', 'email.email' => 'Email is invalid', 'email.max' => 'Email must not be greater than 255 characters', 'email.unique' => 'Email is already taken', 'password.required' => 'Password is required', 'password.confirmed' => 'Password confirmation does not match',

        ];

    }
}
