<?php

namespace Tests\Feature\Activity;

use App\Http\Requests\Activity\UpdateRequest;
use App\Models\Activity;
use App\Models\Collection;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use JsonException;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\AuthorizedTestCase;

class UpdateTest extends AuthorizedTestCase
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
            ->get(route('activities.edit', [$collection->id, $activity->id]))
            ->assertInertia(fn(AssertableInertia $assert) => $assert
                ->component('Activity/Save')
                ->where('collection.id', $collection->id)
                ->where('collection.name', $collection->name)
                ->where('collection.color', $collection->color)
                ->where('activity.id', $activity->id)
                ->where('activity.name', $activity->name)
                ->where('activity.icon', $activity->icon)
            );
    }


    /**
     * @throws JsonException
     */
    public function test_updates_successfully(): void
    {
        $collection = Collection::first();
        $activity = Activity::first();

        $this
            ->put(route('activities.update', [$collection->id, $activity->id]), [
                'name' => 'Новое название',
                'icon' => 404,
            ])
            ->assertRedirect(route('collections.index'))
            ->assertSessionHasNoErrors();

        $this
            ->assertDatabaseCount('activities', 1)
            ->assertDatabaseHas('activities', [
                'name' => 'Новое название',
                'icon' => 404,
            ]);
    }


    public function test_rejects_invalid_data(): void
    {
        $collection = Collection::first();
        $activity = Activity::first();
        $route = route('activities.edit', [$collection->id, $activity->id]);


        $this
            ->put(route('activities.update', [$collection->id, $activity->id]), [
                'name' => 'Крайне неэффективное название /для активности',
                'icon' => 1001,
            ], ['Referer' => $route])
            ->assertRedirect($route)
            ->assertSessionHasErrors('name', 'icon');

        $this
            ->assertDatabaseCount('activities', 1)
            ->assertDatabaseMissing('activities', [
                'name' => 'Крайне неэффективное название /для активности',
                'icon' => 1001,
            ]);
    }


    public function test_avoids_updating_with_name_duplicate(): void
    {
        $collection = Collection::first();
        $activity = Activity::first();
        $existing = Activity::factory()->for(User::first())->for($collection)->create();
        $route = route('activities.edit', [$collection->id, $activity->id]);

        $this
            ->put(route('activities.update', [$collection->id, $activity->id]), [
                'name' => $existing->name,
                'icon' => 333,
            ], ['Referer' => $route])
            ->assertRedirect($route)
            ->assertSessionHasErrors(['name']);

        $this
            ->assertDatabaseCount('activities', 2)
            ->assertDatabaseMissing('activities', [
                'id' => 1,
                'name' => $existing->name,
                'icon' => 333,
            ]);
    }


    public function test_404_when_activity_does_not_belong_to_user(): void
    {
        $newUser = User::factory()->create();
        $collection = Collection::factory()->for($newUser)->create();
        $activity = Activity::factory()->for($newUser)->for($collection)->create();

        $this->get(route('activities.edit', [$collection->id, $activity->id]))->assertStatus(Response::HTTP_NOT_FOUND);
        $this->put(route('activities.update', [$collection->id, $activity->id]), ['name' => 'Название', 'icon' => 100])->assertStatus(Response::HTTP_NOT_FOUND);
    }


    public function test_validation(): void
    {
        $request = UpdateRequest::class;

        $this->assertValidationPasses($request, "name", "Short", "Сон");
        $this->assertValidationPasses($request, "name", "Long", "Сходил купил сахара");
        $this->assertValidationPasses($request, "name", "One word", "Сахар");
        $this->assertValidationPasses($request, "name", "Multiple words", "Много сахара");
        $this->assertValidationPasses($request, "name", "Numbers", "Целых 10 кг сахара");
        $this->assertValidationPasses($request, "name", "Only numbers", "100");
        $this->assertValidationPasses($request, "name", "Dash", "Купил 9-10 кг сахара");
        $this->assertValidationPasses($request, "icon", "First group", 100);
        $this->assertValidationPasses($request, "icon", "Ninth group", 903);
        $this->assertValidationPasses($request, "icon", "Third group", 333);

        $this->assertValidationFails($request, "name", "Too short", "Ор");
        $this->assertValidationFails($request, "name", "Too long", "Сахара много не бывает");
        $this->assertValidationFails($request, "name", "Has comma", "Сахара, много сахара");
        $this->assertValidationFails($request, "name", "Period", "Углевод. Сахар.");
        $this->assertValidationFails($request, "name", "Other symbols", "Тут нет сахара[]/\?!");
        $this->assertValidationFails($request, "icon", "Zero group", 99);
        $this->assertValidationFails($request, "icon", "Negative group", -100);
        $this->assertValidationFails($request, "icon", "Nonexistent group", 1001);
    }
}
