<?php

namespace App\Http\Requests\Transaction;

use App\Enums\Transaction\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'category' => ['required', 'numeric', 'integer', Rule::in(Category::cases())],
            'value' => ['required', 'numeric', 'decimal:0,4', 'min:0', 'max:1000000'],
            'sign' => ['required', 'numeric', 'integer', Rule::in([-1, +1])],
            'description' => ['string', 'nullable', 'max:50'],
        ];
    }
}
