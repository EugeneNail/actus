<?php

namespace App\Services;

use App\Enums\Transaction\Category;
use App\Http\Resources\CategoryResource;

class TransactionService
{
    /**
     * Converts all values of the Category enum into array of their object representations
     * @return string[]
     */
    public function categoriesToList(): array {
        return collect(Category::cases())
            ->map(fn (Category $category) => new CategoryResource($category))
            ->toArray();
    }
}
