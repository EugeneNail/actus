<?php

namespace App\Services\Export;

use App\Enums\DateMonth;
use App\Enums\DayOfWeek;
use App\Enums\Mood;
use App\Enums\Weather;
use App\Models\Entry;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MarkdownExporter implements ExporterInterface
{
    public function export(User $user): array
    {
        $file = Str::uuid();
        Storage::put($file, '');

        foreach($user->entries->sortByDesc('date') as $entry) {
            $this->write($entry, $file);
        }

        return [
            storage_path("app/$file"),
            sprintf("Дневники %s.md", date('Y-m-d'))
        ];
    }


    private function write(Entry $entry, string $file): void
    {
        if (strlen($entry->diary) == 0) {
            return;
        }

        $date = $entry->date;
        $header = sprintf(
            '# %s, %d %s %d',
            DayOfWeek::from($date->dayOfWeek)->toString(),
            $date->day,
            DateMonth::from($date->month)->toString(),
            $date->year,
        );

        $subheader = sprintf(
            '#### %s, %s',
            Mood::from($entry->mood)->toString(),
            Weather::from($entry->weather)->toString(),
        );

        Storage::append($file, sprintf(
            "%s\n\n%s\n\n%s\n",
            $header,
            $subheader,
            $entry->diary,
        ));
    }
}
