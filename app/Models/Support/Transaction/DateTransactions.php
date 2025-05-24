<?php

namespace App\Models\Support\Transaction;

use App\Models\Transaction;
use Carbon\Carbon;

class DateTransactions
{
    public readonly  int $day;

    public readonly  int $month;

    public readonly int $year;

    public readonly float $total;

    /** @var Transaction[] */
    public readonly  iterable $transactions;


    /**
     * @param string $date
     * @param Transaction[] $transactions
     */
    public function __construct(string $date, iterable $transactions)
    {
        $carbon = Carbon::createFromFormat('Y-m-d', $date);
        $this->day = $carbon->day;
        $this->month = $carbon->month;
        $this->year = $carbon->year;
        $this->transactions = $transactions;

        $total = 0;
        foreach($transactions as $transaction) {
            $total += $transaction->sign * $transaction->value;
        }

        $this->total = $total;
    }
}

