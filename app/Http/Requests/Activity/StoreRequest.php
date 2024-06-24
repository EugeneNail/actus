<?php

namespace App\Http\Requests\Activity;

use App\Rules\Sand;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:20', new Sand()],
            'icon' => ['required', 'integer', 'min:100', 'max:1000']
        ];
    }
}
