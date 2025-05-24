<?php

namespace App\Http\Requests\Transaction;

use App\Models\Support\Transaction\Period;
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
            'from' => ['string', 'date', "date_format:" . Period::FORMAT],
            'to' => ['string', 'date', "date_format:" . Period::FORMAT],
        ];
    }
}
