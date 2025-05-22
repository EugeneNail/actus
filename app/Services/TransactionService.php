<?php

namespace App\Services;

use App\Enums\Transaction\Category;
use App\Http\Resources\CategoryResource;
use App\Models\Support\DateTransactions;
use App\Models\Support\TransactionPeriod;
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
     * Maps last $monthCount months into array of ['from' => d/m/Y, 'to' => d/m/Y] objects
     * @param int $monthCount
     * @return TransactionPeriod[]
     */
    public function collectPeriods(int $monthCount): array
    {
        $periods = [];
        for ($i = 0; $i < $monthCount; $i++) {
            $current = (new Carbon())->subMonths($i);

            $periods[] = new TransactionPeriod(
                $current->clone()->startOfMonth()->addDays(4),
                $current->clone()->startOfMonth()->addMonth()->addDays(3),
            );
        }

        return $periods;
    }


    public function collectTransactions(string $from, string $to, User $user): iterable
    {
        $from = Carbon::createFromFormat(TransactionPeriod::FORMAT, $from)->format('Y-m-d');
        $to = Carbon::createFromFormat(TransactionPeriod::FORMAT, $to)->format('Y-m-d');

        return $user->transactions
            ->where('date', '>=', $from)
            ->where('date', '<=', $to)
            ->sortByDesc(['date', 'id'])
            ->groupBy('date')
            ->map(fn($transactions, $date) => new DateTransactions($date, $transactions))
            ->values();
    }
}
