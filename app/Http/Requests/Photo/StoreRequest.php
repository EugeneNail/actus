<?php

namespace App\Http\Requests\Photo;

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
            'photos' => ['required', 'array', 'max:15'],
            'photos.*' => ['required', 'image', "max:20000"]
        ];
    }
}
