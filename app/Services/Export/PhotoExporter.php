<?php

namespace App\Services\Export;

use App\Models\Photo;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class PhotoExporter implements ExporterInterface
{

    /**
     * Collects and writes all user's photos into a zip file
     * @inheritDoc
     * @throws Exception
     */
    public function export(User $user): array
    {
        Storage::makeDirectory('downloadable');

        $archive = new ZipArchive();
        $filename = storage_path("app/downloadable/user_{$user->id}_photos.zip");

        $successfullyOpens = $archive->open($filename, ZipArchive::CREATE);
        if (!$successfullyOpens) {
            throw new Exception("Unable to open the $filename file. Code $successfullyOpens");
        }

        $this->removeDeletedPhotos($archive, $user);

        foreach ($user->photos->pluck('name') as $photo) {
            // Already added files won't be duplicated because they have same names as these files
            $archive->addFile(storage_path("app/photos/$photo"), $photo);
        }

        $archive->close();

        return [$filename, sprintf("Фотографии %s.zip", date('Y-m-d'))];
    }


    /**
     * Removes each photo that was deleted from user's account since last export
     * @param ZipArchive $archive
     * @param User $user
     * @return void
     */
    private function removeDeletedPhotos(ZipArchive $archive, User $user): void
    {
        $actualPhotos = $user->photos->mapWithKeys(fn (Photo $photo) => [$photo->name => $photo->name]);

        for ($i = 0; $i < $archive->numFiles; $i++) {
            $name = $archive->getNameIndex($i);

            if (!isset($actualPhotos[$name])) {
                $archive->deleteName($name);
            }
        }
    }
}
