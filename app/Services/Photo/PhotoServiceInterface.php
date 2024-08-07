<?php

namespace App\Services\Photo;

use Illuminate\Http\UploadedFile;

interface PhotoServiceInterface
{
    public function isOwned(string $name, int $userId): bool;

    public function exists(string $name): bool;

    /**
     * @param array<UploadedFile> $photos
     * @return array<string> names of saved files
     */
    public function saveMany(array $photos, int $userId): array;

    public function destroy(string $name): void;

    /** @param $photoNames array<string> */
    public function allExist(array $photoNames): bool;

    /** @param $photoNames array<string> */
    public function ownsEach(array $photoNames, int $userId): bool;
}
