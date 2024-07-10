<?php

namespace App\Services\Export;

use App\Models\User;
use Illuminate\Support\Str;
use ZipArchive;

class PhotoExporter implements ExporterInterface
{

    public function export(User $user): array
    {
        $archive = new ZipArchive();
        $path = storage_path(Str::uuid());

        if ($archive->open($path, ZipArchive::CREATE)) {
            foreach ($user->photos->pluck('name') as $photo) {
                $archive->addFile(storage_path("app/photos/$photo"), $photo);
            }
            $archive->close();
        }

        return [
            $path,
            sprintf("Фотографии %s.md", date('Y-m-d'))
        ];
    }
}
