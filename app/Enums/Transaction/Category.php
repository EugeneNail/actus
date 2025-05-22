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


    public function toIcon(): string
    {
        return match ($this) {
            self::BILLS => 'request_quote',
            self::FOOD => 'restaurant',
            self::TRANSPORTATION => 'local_taxi',
            self::PERSONAL_ITEMS => 'accessibility_new',
            self::HOME_MAINTENANCE => 'house',
            self::BEAUTY => 'health_and_beauty',
            self::FUN_MONEY => 'celebration',
            self::GIFTS => 'featured_seasonal_and_gifts',
            self::SAVINGS => 'savings',
            self::SALARY => 'payments',
            self::OTHER_INCOMES => 'money_bag',
        };
    }
}
