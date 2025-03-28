<?php

namespace App\Services;

use App\Models\Photo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoService
{
    /**
     * Checks if the user owns the photo
     * @param string $name
     * @param int $userId
     * @return bool
     */
    public function isOwned(string $name, int $userId): bool
    {
        return str_starts_with($name, $userId . '_');
    }


    /**
     * Checks if the photo exists
     * @param string $name
     * @return bool
     */
    public function exists(string $name): bool
    {
        return file_exists(storage_path("app/photos/$name"));
    }


    /**
     * Writes multiple photos into storage and database and returns their names
     * @param UploadedFile[] $photos
     * @param int $userId
     * @return string[] names of saved files
     */
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

        return collect($data)->pluck('name')->toArray();
    }


    /**
     * Deletes the photo from storage and database
     * @param string $name
     * @return void
     */
    public function destroy(string $name): void
    {
        Photo::where('name', $name)->delete();
        Storage::delete("photos/$name");
    }


    /**
     * Checks whether each photo exists
     * @param $photoNames string[]
     * @return bool
     */
    public function allExist(array $photoNames): bool
    {
        return Photo::whereIn('name', $photoNames)->count() == count($photoNames);
    }


    /**
     * Check whether the user owns each photo
     * @param $photoNames string[]
     * @param int $userId
     * @return bool
     */
    public function ownsEach(array $photoNames, int $userId): bool
    {
        return Photo::whereIn('name', $photoNames)->get()->every(fn($photo) => $photo->user_id == $userId);
    }
}
