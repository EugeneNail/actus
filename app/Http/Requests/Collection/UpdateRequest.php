<?php

namespace App\Http\Requests\Collection;

use App\Rules\Sand;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:20', new Sand()],
            'color' => ['required', 'numeric', 'integer', 'between:1,6'],
        ];
    }
}
