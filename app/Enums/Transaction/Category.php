<?php

namespace App\Enums\Transaction;

enum Category: int
{
    case BILLS = 1;
    case FOOD = 2;
    case TRANSPORTATION = 3;
    case PERSONAL_ITEMS = 4;
    case HOME_MAINTENANCE = 5;
    case BEAUTY = 6;
    case FUN_MONEY = 7;
    case GIFTS = 8;
    case SAVINGS = 9;
    case SALARY = 10;
    case OTHER_INCOMES = 11;


    public function toString(): string
    {
        return match ($this) {
            self::BILLS => 'Bills',
            self::FOOD => 'Food',
            self::TRANSPORTATION => 'Transportation',
            self::PERSONAL_ITEMS => 'Personal items',
            self::HOME_MAINTENANCE => 'Home maintenance',
            self::BEAUTY => 'Beauty',
            self::FUN_MONEY => 'Fun money',
            self::GIFTS => 'Gifts',
            self::SAVINGS => 'Savings',
            self::SALARY => 'Salary',
            self::OTHER_INCOMES => 'Other incomes',
        };
    }
}
