<?php

namespace App\Services\Collection;

use App\Models\Collection;

interface CollectionServiceInterface
{
    public function verifyOwner(Collection $collection): void;
    public function createCollection(array $data): void;
    public function updateCollection(Collection $collection, array $data): void;
    public function deleteCollection(Collection $collection): void;
    public function hasNameDuplicate(string $name, int $excludedId): bool;
    public function exceededLimit(int $limit): bool;
}
