<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            "name" => ["required", "string", 'alpha', "min:3", "max:20"],
            "email" => ["required", "email", "unique:users"],
            "password" => ["required", Password::min(8)->max(50)->letters()->numbers()->mixedCase()],
            "passwordConfirmation" => ["required", "same:password"],
        ];
    }
}
