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


    public function saveMany(array $photos, int $userId): array
    {
        $names = [];

        foreach ($photos as $photo) {
            $name = sprintf(
                '%d_%s_%s.%s',
                $userId,
                date('Y-m-d'),
                Str::uuid(),
                $photo->extension()
            );
            $photo->storeAs('photos', $name);
            $names[] = $name;
        }

        Photo::insert(
            collect($names)->map(fn($name) => [
                'name' => $name,
                'user_id' => $userId
            ])->toArray()
        );

        return $names;
    }


    public function destroy(string $name): void
    {
        Photo::where('name', $name)->delete();
        Storage::delete("photos/$name");
    }


    public function allExist(array $photoNames): bool
    {
        return Photo::whereIn('name', $photoNames)->count() == count($photoNames);
    }


    public function ownsEach(array $photoNames, int $userId): bool
    {
        return Photo::whereIn('name', $photoNames)->get()->every(fn($photo) => $photo->user_id == $userId);
    }
}
