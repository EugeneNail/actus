<?php

namespace App\Services\Photo;

use App\Models\Photo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoService implements PhotoServiceInterface
{
    public function isOwned(string $name, int $userId): bool
    {
        return str_starts_with($name, $userId);
    }


    public function exists(string $name): bool
    {
        return file_exists(storage_path("app/photos/$name"));
    }


    /** @inheritDoc */
    public function saveMany(array $photos, int $userId): array
    {
        $data = [];

        foreach ($photos as $photo) {
            $name = sprintf(
                '%d_%s_%s.%s',
                $userId,
                date('Y-m-d'),
                Str::uuid(),
                $photo->extension()
            );
            $photo->storeAs('photos', $name);
            $data[] = [
                'name' => $name,
                'user_id' => $userId
            ];
        }

        Photo::insert($data);

        return $data;
    }


    public function destroy(string $name): void
    {
        Photo::where('name', $name)->delete();
        Storage::delete("photos/$name");
    }


    /** @inheritDoc */
    public function allExist(array $photoNames): bool
    {
        return Photo::whereIn('name', $photoNames)->count() == count($photoNames);
    }


    /** @inheritDoc */
    public function ownsEach(array $photoNames, int $userId): bool
    {
        return Photo::whereIn('name', $photoNames)->get()->every(fn($photo) => $photo->user_id == $userId);
    }
}
