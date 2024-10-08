<?php

namespace App\Console\Commands\Photo;

use App\Models\Entry;
use App\Models\Photo;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;

class SyncDates extends Command
{
    protected $signature = 'photo:sync-dates {userIds?*}';

    protected $description = 'Command description';

    private $yyyymmdd = '/20\d{2}-(0[1-9]|1[0-2])-([0-3]\d|3[0-1])/';


    public function handle()
    {
        $userIds = $this->argument('userIds');
        $photosByEntryDate = Entry::query()
            ->with('photos')
            ->when($userIds, function ($query) use ($userIds) {return $query->whereIn('user_id', $userIds);})
            ->orderBy('date')
            ->get()
            ->groupBy(fn ($entry) => $entry->date->format('Y-m-d'))
            ->map(fn ($entries) => $this->entriesToPhotos($entries));

        $progressBar = $this->getProgressBar($photosByEntryDate);

        foreach ($photosByEntryDate as $date => $photos) {
            foreach ($photos as $photo) {
                $this->syncDate($photo, $date);
                $progressBar->advance();
            }
        }
    }


    private function entriesToPhotos($entries): iterable {
        $photos = new Collection();

        foreach($entries as $entry) {
            $photos = $photos->merge($entry->photos);
        }

        return $photos;
    }


    private function getProgressBar(Collection $photosByEntryDate): ProgressBar {
        $progressBarCounter = 0;
        
        foreach ($photosByEntryDate as $photos) {
            $progressBarCounter += $photos->count();
        }

        return $this->output->createProgressBar($progressBarCounter);
    }


    private function syncDate(Photo $photo, string $date): void {
        if (preg_match($this->yyyymmdd, $photo->name, $matches) && $matches[0] != $date) {
            $oldName = "photos/{$photo->name}";
            $photo->name = preg_replace($this->yyyymmdd, $date, $photo->name);
            Storage::move($oldName, "photos/{$photo->name}");
            $photo->save();
        }
    }
}
