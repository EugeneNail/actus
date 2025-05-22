<?php

namespace App\Http\Resources;

use App\Enums\Transaction\Category;

class CategoryResource
{
    public string $name = '';

    public int $value = 0;

    public string $icon = '';


    public function __construct(Category $category)
    {
        $this->name = $category->toString();
        $this->value = $category->value;
        $this->icon = $category->toIcon();
    }
}
