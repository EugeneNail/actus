<?php

namespace App\Services\Export;

use App\Enums\Mood;
use App\Enums\Weather;
use App\Models\Entry;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DiaryExporter implements ExporterInterface
{
    /**
     * Collects and writes all entries with a non-empty diary to a file
     * @inheritDoc
     */
    public function export(User $user, int $year, int $month = 0): array
    {
        $file = Str::uuid();
        Storage::put($file, '');

        $user->entries
            ->where('diary', '!=', '')
            ->where('date', '>=', "$year-01-01")
            ->where('date', '<=', "$year-12-31")
            ->sortByDesc('date')
            ->each(fn($entry) => $this->write($entry, $file));

        return [
            storage_path("app/$file"),
            "Diaries $year.md"
        ];
    }


    /**
     * Formats plain text into markdown format
     * @param Entry $entry
     * @param string $file
     * @return void
     */
    private function write(Entry $entry, string $file): void
    {
        $date = $entry->date;
        $header = sprintf(
            '# %s, %d %s %d',
            $entry->date->format('l'),
            $date->day,
            $entry->date->format('F'),
            $date->year,
        );

        $subheader = sprintf(
            '#### %s, %s',
            Mood::from($entry->mood)->toString(),
            Weather::from($entry->weather)->toString(),
        );

        Storage::append(
            $file,
            sprintf(
                "%s\n%s\n\n%s\n\n\n\n\n\n",
                $header,
                $subheader,
                $entry->diary,
            )
        );
    }
}
