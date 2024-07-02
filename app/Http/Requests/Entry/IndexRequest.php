<?php

namespace App\Http\Requests\Entry;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'month' => ['numeric', 'integer', "min:1", "max:12"],
            'year' => ['numeric', 'integer', "min:2020", "max:2099"],
        ];
    }
}
