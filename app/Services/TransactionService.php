<?php

namespace App\Services;

use App\Enums\Transaction\Category;
use App\Http\Resources\CategoryResource;
use App\Models\Support\Transaction\DateTransactions;
use App\Models\Support\Transaction\Period;
use App\Models\User;
use Carbon\Carbon;

class TransactionService
{
    /**
     * Converts all values of the Category enum into array of their object representations
     * @return string[]
     */
    public function categoriesToList(): array
    {
        return collect(Category::cases())
            ->map(fn(Category $category) => new CategoryResource($category))
            ->toArray();
    }
    
    
    /**
     * Wraps transactions of each date with precise information about the date
     * @param string $from
     * @param string $to
     * @param User $user
     * @return iterable
     */
    public function collectDateTransactions(string $from, string $to, User $user): iterable
    {
        $from = Carbon::createFromFormat(Period::FORMAT, $from)->format('Y-m-d');
        $to = Carbon::createFromFormat(Period::FORMAT, $to)->format('Y-m-d');

        return $user->transactions
            ->where('date', '>=', $from)
            ->where('date', '<=', $to)
            ->sortByDesc(['date', 'id'])
            ->groupBy('date')
            ->map(fn($transactions, $date) => new DateTransactions($date, $transactions))
            ->values();
    }
}
