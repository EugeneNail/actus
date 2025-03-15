<?php

namespace App\Http\Requests\Entry;

use Illuminate\Foundation\Http\FormRequest;

class SaveRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'numeric', 'integer', 'min:0'],
            'date' => ['required', 'date', 'date_format:Y-m-d'],
            'goals' => ['nullable', 'array'],
            'goals.*' => ['integer'],
            'mood' => ['required', 'numeric', 'integer', 'between:1,5'],
            'weather' => ['required', 'numeric', 'integer', 'between:1,9'],
            'diary' => ['nullable', 'string', 'max:10000'],
            'photos' => ['nullable', 'array', 'max:10'],
            'photos.*' => ['string'],
        ];
    }
}
