<?php

namespace App\Services\Export;

use App\Models\Entry;
use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Support\Str;
use ZipArchive;

class PhotoExporter implements ExporterInterface
{

    /**
     * Collects and writes all user's photos into a zip file
     * @inheritDoc
     * @throws Exception
     */
    public function export(User $user, int $year, int $month): array
    {
        $archive = new ZipArchive();
        $path = storage_path(Str::uuid());

        if ($archive->open($path, ZipArchive::CREATE)) {
            $user->entries()->with('photos')
                ->where('date', '>=', date("$year-$month-01"))
                ->where('date', '<=', date("$year-$month-t"))
                ->whereHas('photos')
                ->get()
                ->flatMap(fn (Entry $entry) => $entry->photos)
                ->pluck('name')
                ->each(fn ($name) => $archive->addFile(storage_path("app/photos/$name"), $name));

            $archive->close();
        }

        return [
            $path,
            sprintf(
                "Photos %s %d.zip",
                DateTime::createFromFormat('m', $month)->format('F'),
                $year
            )
        ];
    }
}
