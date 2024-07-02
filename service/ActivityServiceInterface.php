<?php

namespace service;

use App\Models\Activity;
use App\Models\Collection;

interface ActivityServiceInterface
{
    public function verifyOwner(Activity $activity): void;

    public function create(Collection $collection, array $data): void;

    public function update(Activity $activity, array $data): void;

    public function destroy(Activity $activity): void;

    public function hasNameDuplicate(string $name, Collection $collection, $excludedId): bool;

    public function exceededLimit(int $limit, Collection $collection): bool;

    /** @param $activityIds array<int> */
    public function allExist(array $activityIds): bool;

    /** @param $activityIds array<int> */
    public function ownsEach(array $activityIds, int $userId): bool;
}
