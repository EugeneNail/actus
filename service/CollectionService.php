<?php

namespace service;

use App\Models\Collection;
use Illuminate\Support\Facades\Auth;

class CollectionService implements CollectionServiceInterface
{
    public function verifyOwner(Collection $collection): void
    {
        if ($collection->user_id != Auth::user()->id) {
            abort(404);
        }
    }


    public function createCollection(array $data): void
    {
        $collection = new Collection($data);
        Auth::user()->collections()->save($collection);
        $collection->save();
    }


    public function updateCollection(Collection $collection, array $data): void
    {
        $collection->update($data);
    }


    public function deleteCollection(Collection $collection): void
    {
        $collection->delete();
    }


    public function hasNameDuplicate(string $name, int $excludedId = 0): bool
    {
        $query = Auth::user()->collections->where('name', '=', $name);

        if ($excludedId) {
            $query = $query->where('id', '!=', $excludedId);
        }

        return $query->count() > 0;
    }


    public function exceededLimit(int $limit): bool
    {
        return Auth::user()->collections->count() >= 20;
    }
}
