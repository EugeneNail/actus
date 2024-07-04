<?php

namespace Tests\Feature\Photo;

use App\Http\Requests\Photo\StoreRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\AuthorizedTestCase;
use Throwable;

class StoreTest extends AuthorizedTestCase
{
    /** * @throws Throwable */
    public function test_stores_successfully(): void
    {
        $files = [];
        $count = rand(1, 5);
        for ($i = 0; $i < $count; $i++) {
            $files[] = UploadedFile::fake()->image('image.png', 1000, 1000)->size(5192);
        }

        $names = $this
            ->post(route('photos.store'), ['photos' => $files])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonIsArray()
            ->assertJsonCount($count)
            ->decodeResponseJson();

        $this->assertDatabaseCount('photos', $count);

        for ($i = 0; $i < $count; $i++) {
            $this->assertFileExists(storage_path("app/photos/$names[$i]"));
            $this->assertDatabaseHas('photos', [
                'name' => $names[$i],
                'user_id' => 1,
            ]);
            Storage::delete("photos/$names[$i]");
        }

    }
}
