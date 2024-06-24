<?php

namespace Tests\Feature\Activity;

use App\Models\Activity;
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
        $user = User::first();
        $collection = Collection::factory()->for($user)->create();
        Activity::factory()->for($user)->for($collection)->create();
    }


    public function test_passes_data_to_page_successfully(): void
    {
        $collection = Collection::first();
        $activity = Activity::first();

        $this
            ->get(route('activities.delete', [$collection->id, $activity->id]))
            ->assertInertia(fn(AssertableInertia $assert) => $assert
                ->component('Activity/Delete')
                ->where('activityName', $activity->name)
                ->where('activityId', $activity->id)
                ->where('collectionId', $collection->id)
            );
    }


    public function test_destroys_successfully(): void
    {
        $collection = Collection::first();
        $activity = Activity::first();

        $this
            ->delete(route('activities.destroy', [$collection->id, $activity->id]))
            ->assertRedirect(route('collections.index'));

        $this
            ->assertDatabaseCount('collections', 1)
            ->assertDatabaseCount('activities', 0);
    }


    public function test_404_when_activity_does_not_belong_to_user(): void
    {
        $newUser = User::factory()->create();
        $collection = Collection::factory()->for($newUser)->create();
        $activity = Activity::factory()->for($newUser)->for($collection)->create();

        $this->get(route('activities.delete', [$collection->id, $activity->id]))->assertStatus(Response::HTTP_NOT_FOUND);
        $this->delete(route('activities.destroy', [$collection->id, $activity->id]))->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertDatabaseCount('activities', 2);
    }


}
