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
            'sleeptime' => ['required', 'numeric', 'integer', 'between:1,10'],
            'weight' => ['required', 'numeric', 'decimal:0,10', 'between:40,200'],
            'worktime' => ['required', 'numeric', 'integer', 'between:0,9'],
            'diary' => ['nullable', 'string', 'max:10000'],
            'activities' => ['nullable', 'array'],
            'activities.*' => ['integer'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['string'],
        ];
    }
}
