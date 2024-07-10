<?php

namespace Tests\Traits;

use App\Models\Entry;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

trait HasPhotos
{
    /** @param array<string> $photos */
    protected array $photos = [];


    /**
     * @throws Throwable
     */
    protected function createPhotos(User $user, Entry $entry = null): void {
        $files = [];
        for ($i = 0; $i < 5; $i++) {
            $files[] = UploadedFile::fake()->image('image.png', 1000, 1000)->size(5192);
        }

        $this->photos = $this
            ->post(route('photos.store'), ['photos' => $files])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonIsArray()
            ->assertJsonCount(5)
            ->decodeResponseJson()
            ->json();

        if ($entry != null) {
            DB::table('photos')->whereIn('name', $this->photos)->update(['entry_id' => $entry->id]);
        }
    }


    protected function deletePhotos(): void {
        foreach($this->photos as $photo) {
            Storage::delete("photos/$photo");
        }
    }
}
