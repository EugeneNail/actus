<?php

namespace App\Http\Requests\Entry;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $today = date('Y-m-d');
        return [
            'date' => ['required', 'date', 'date_format:Y-m-d', "before_or_equal:$today"],
            'mood' => ['required', 'numeric', 'integer', 'between:1,5'],
            'weather' => ['required', 'numeric', 'integer', 'between:1,9'],
            'sleeptime' => ['required', 'numeric', 'integer', 'between:1,10'],
            'worktime' => ['required', 'numeric', 'integer', 'between:0,9'],
            'diary' => ['nullable', 'string', 'max:10000'],
            'activities' => ['nullable', 'array'],
            'activities.*' => ['integer'],
            'photos' => ['nullable', 'array', 'max:10'],
            'photos.*' => ['string'],
        ];
    }
}
