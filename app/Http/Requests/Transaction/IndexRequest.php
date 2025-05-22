<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Support\TransactionPeriod;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'from' => ['string', 'date', "date_format:" . TransactionPeriod::FORMAT],
            'to' => ['string', 'date', "date_format:" . TransactionPeriod::FORMAT],
        ];
    }
}
