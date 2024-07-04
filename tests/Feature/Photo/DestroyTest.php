<?php

namespace Tests\Feature\Photo;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\AuthorizedTestCase;

class DestroyTest extends AuthorizedTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this
            ->post(route('photos.store'), [
                'photos' => [UploadedFile::fake()->image('image.png')]
            ])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonCount(1)
            ->assertJsonIsArray();
    }


    public function test_destroys_successfully(): void
    {
        $name = Photo::first()->name;

        $this
            ->delete(route('photos.destroy', $name))
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseCount('photos', 0);

        Storage::assertMissing("photos/$name");
    }


    public function test_404_when_file_does_not_exist(): void
    {
        $name = Photo::first()->name;

        $nonexistent = sprintf(
            '1_%s_%s.png',
            date('Y-m-d'),
            Str::uuid(),
        );

        $this
            ->delete(route('photos.destroy', $nonexistent))
            ->assertStatus(Response::HTTP_NOT_FOUND);

        Storage::delete("photos/$name");
    }


    public function test_404_when_photo_does_not_belong_to_user(): void
    {
        $name = Photo::first()->name;

        $this
            ->actingAs(User::factory()->create())
            ->delete(route('photos.destroy', $name))
            ->assertStatus(Response::HTTP_NOT_FOUND);

        Storage::delete("photos/$name");
    }
}
