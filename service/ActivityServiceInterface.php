<?php

namespace service;

use App\Models\Collection;

interface ActivityServiceInterface
{
    public function create(Collection $collection, array $data): void;
    public function hasNameDuplicate(string $name, Collection $collection, $excludedId): bool;
    public function exceededLimit(int $limit, Collection $collection): bool;
}
