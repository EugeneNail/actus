<?php

namespace App\Http\Requests\Entry;

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
            'mood' => ['required', 'numeric', 'integer', 'between:1,5'],
            'weather' => ['required', 'numeric', 'integer', 'between:1,9'],
            'diary' => ['nullable', 'string', 'max:5000'],
            'activities' => ['nullable', 'array'],
            'activities.*' => ['integer'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['string'],
        ];
    }
}
