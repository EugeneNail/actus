<?php

namespace Tests\Feature\Collection;

use App\Models\Collection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\AuthorizedTestCase;
use Tests\TestCase;

class DestroyTest extends AuthorizedTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Collection::factory()->for(User::first())->create();
    }


    public function test_passes_data_to_page_successfully(): void
    {
        $collection = Collection::first();
        $this
            ->get(route('collections.delete', $collection->id))
            ->assertInertia(fn(AssertableInertia $assert) => $assert
                ->component('Collection/Delete')
                ->where('id', $collection->id)
                ->where('name', $collection->name)
                ->where('color', $collection->color)
            );
    }


    public function test_deletes_successfully(): void
    {
        $this->assertDatabaseCount("collections", 1)
            ->delete(route('collections.destroy', Collection::first()->id))
            ->assertRedirect(route('collections.index'));

        $this->assertDatabaseCount('collections', 0);
    }


    public function test_404_when_collection_does_not_exist(): void
    {
        $this->assertDatabaseCount('collections', 1);

        $this->get(route('collections.delete', 99))->assertStatus(Response::HTTP_NOT_FOUND);
        $this->delete(route('collections.destroy', 99))->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertDatabaseCount('collections', 1);
    }


    public function test_404_when_collection_does_not_belong_to_user(): void
    {
        $collection = Collection::factory()->for(User::factory())->create();
        $this->assertDatabaseCount('collections', 2);

        $this->get(route('collections.delete', $collection->id))->assertStatus(Response::HTTP_NOT_FOUND);
        $this->delete(route('collections.destroy', $collection->id))->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertDatabaseCount('collections', 2);
    }
}
