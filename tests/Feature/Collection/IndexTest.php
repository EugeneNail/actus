<?php

namespace Tests\Feature\Collection;

use App\Models\Collection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\Feature\AuthorizedTestCase;
use Tests\TestCase;

class IndexTest extends AuthorizedTestCase
{
    public function test_index(): void
    {
        $collections = Collection::factory()->count(rand(0, 20))->for(User::first())->create();

        $this
            ->assertDatabaseCount('collections', $collections->count())
            ->get(route('collections.index'))
            ->assertInertia(function (AssertableInertia $assert) use ($collections) {
                foreach ($collections as $i => $collection) {
                    $assert->component('Collection/Index')
                        ->has('collections', $collections->count())
                        ->where("collections.$i.id", $collection->id)
                        ->where("collections.$i.name", $collection->name)
                        ->where("collections.$i.color", $collection->color);
                }
            });
    }
}
