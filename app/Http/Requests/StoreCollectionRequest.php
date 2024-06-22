<?php

namespace App\Http\Requests;

use App\Rules\Sand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:20', new Sand(), Rule::unique('collections', 'name')->where('user_id', $this->user_id)],
            'color' => ['required', 'numeric', 'integer', 'between:1,6'],
        ];
    }
}
