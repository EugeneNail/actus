<?php

namespace Tests\Feature\Collection;

use App\Models\Activity;
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
        $user = User::first();
        $collections = Collection::factory()
            ->count(rand(0, 20))
            ->for($user)
            ->has(
                Activity::factory()
                    ->for($user)
                    ->count(rand(0, 20))
            )
            ->create();

        $this
            ->assertDatabaseCount('collections', $collections->count())
            ->get(route('collections.index'))
            ->assertInertia(function (AssertableInertia $assert) use ($collections) {
                foreach ($collections as $ci => $collection) {
                    foreach ($collection->activities as $ai => $activity) {
                        $assert->component('Collection/Index')
                            ->has('collections', $collections->count())
                            ->has("collections.$ci.activities", $collection->activities->count())
                            ->where("collections.$ci.id", $collection->id)
                            ->where("collections.$ci.name", $collection->name)
                            ->where("collections.$ci.color", $collection->color)
                            ->where("collections.$ci.activities.$ai.name", $activity->name)
                            ->where("collections.$ci.activities.$ai.icon", $activity->icon);
                    }
                }
            });
    }
}
