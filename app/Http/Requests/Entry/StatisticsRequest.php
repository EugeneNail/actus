<?php

namespace App\Http\Requests\Entry;

use App\Enums\Statistics\Period;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StatisticsRequest extends FormRequest
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
        $periods = [
            Period::MONTH->toString(),
            Period::SEASON->toString(),
            Period::YEAR->toString()
        ];

        return [
            'period' => ['required', 'string', Rule::in($periods)]
        ];
    }
}
