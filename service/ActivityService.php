<?php

namespace service;

use App\Models\Activity;
use App\Models\Collection;
use Illuminate\Support\Facades\Auth;

class ActivityService implements ActivityServiceInterface
{
    public function verifyOwner(Activity $activity): void
    {
        if ($activity->user_id != Auth::user()->id) {
            abort(404);
        }
    }


    public function create(Collection $collection, array $data): void
    {
        $activity = new Activity($data);
        $activity->user()->associate(Auth::user());
        $activity->collection()->associate($collection);
        $activity->save();
    }


    public function hasNameDuplicate(string $name, Collection $collection, $excludedId = 0): bool
    {
        $query = $collection->activities()->where('name', $name);

        if ($excludedId) {
            $query = $query->where('id', '!=', $excludedId);
        }

        return $query->count() > 0;
    }


    public function update(Activity $activity, array $data): void
    {
        $activity->fill($data);
        $activity->save();
    }


    public function destroy(Activity $activity): void
    {
        $activity->delete();
    }


    public function exceededLimit(int $limit, Collection $collection): bool
    {
        return $collection->activities->count() >= $limit;
    }

}
