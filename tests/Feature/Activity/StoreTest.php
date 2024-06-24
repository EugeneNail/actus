<?php

namespace Tests\Feature\Activity;

use App\Http\Requests\Activity\StoreRequest;
use App\Models\Activity;
use App\Models\Collection;
use App\Models\User;
use JsonException;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\AuthorizedTestCase;

class StoreTest extends AuthorizedTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Collection::factory()->for(User::first())->create();
    }

    /**
     * @throws JsonException
     */
    public function test_stores_successfully(): void
    {
        $collection = Collection::first();

        $this
            ->post(route('activities.store', $collection->id), [
                'name' => 'Работа по дому',
                'icon' => 305,
            ])
            ->assertRedirect(route('collections.index'))
            ->assertSessionHasNoErrors();

        $this
            ->assertDatabaseCount('activities', 1)
            ->assertDatabaseHas('activities', [
                'name' => 'Работа по дому',
                'icon' => 305,
                'collection_id' => $collection->id,
            ]);
    }


    public function test_rejects_invalid_data(): void
    {
        $this->assertDatabaseCount('activities', 0);
        $collection = Collection::first();
        $route = route('activities.create', $collection->id);

        $this
            ->post(route('activities.store', $collection->id), [
                'name' => 'Очень и очень много работы* по дому',
                'icon' => 99,
            ], ['Referer' => $route])
            ->assertRedirect($route)
            ->assertSessionHasErrors(['name', 'icon']);

        $this->assertDatabaseCount('activities', 0);
    }


    public function test_404_when_collection_does_not_belong_to_user(): void
    {
        $collection = Collection::factory()->for(User::factory())->create();
        $this->get(route('activities.create', $collection->id))->assertStatus(Response::HTTP_NOT_FOUND);
        $this->post(route('activities.store', $collection->id), ['name' => 'Название', 'icon' => 100])->assertStatus(Response::HTTP_NOT_FOUND);
    }


    public function test_avoids_creating_name_duplicates(): void
    {
        $collection = Collection::first();
        $existing = Activity::factory()->for(User::first())->for($collection)->create();
        $route = route('activities.create', $collection->id);

        $this
            ->post(route('activities.store', $collection->id), [
                'name' => $existing->name,
                'icon' => 200,
            ], ['Referer' => $route])
            ->assertRedirect($route)
            ->assertSessionHasErrors(['name']);

        $this
            ->assertDatabaseCount('activities', 1)
            ->assertDatabaseMissing('activities', [
                'icon' => 200,
            ]);
    }


    public function test_refuses_to_create_too_many_activities(): void
    {
        $collection = Collection::first();
        Activity::factory()
            ->for(User::first())
            ->for($collection)
            ->count(20)
            ->create();

        $route = route('activities.create', $collection->id);
        $this->assertDatabaseCount('activities', 20)
            ->post(route('activities.store', $collection->id), [
                'name' => 'Валидное название',
                'icon' => 100
            ], ['Referer' => $route])
            ->assertRedirect($route)
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseCount('activities', 20);
    }


    public function test_validation(): void
    {
        $request = StoreRequest::class;

        $this->assertValidationPasses($request, "name", "Short", "Бег");
        $this->assertValidationPasses($request, "name", "Long", "Название  активности");
        $this->assertValidationPasses($request, "name", "One word", "Душ");
        $this->assertValidationPasses($request, "name", "Multiple words", "Встал рано");
        $this->assertValidationPasses($request, "name", "Numbers", "Встал в 6 утра");
        $this->assertValidationPasses($request, "name", "Only numbers", "123534");
        $this->assertValidationPasses($request, "name", "Dash", "Работал 9-10 часов");
        $this->assertValidationPasses($request, "icon", "First group", 100);
        $this->assertValidationPasses($request, "icon", "Ninth group", 903);
        $this->assertValidationPasses($request, "icon", "Third group", 333);

        $this->assertValidationFails($request, "name", "Too short", "Не");
        $this->assertValidationFails($request, "name", "Too long", "Очень длинное название");
        $this->assertValidationFails($request, "name", "Has comma", "Спать, спать и спать");
        $this->assertValidationFails($request, "name", "Period", "Лучше. Быстрее.");
        $this->assertValidationFails($request, "name", "Other symbols", "[]/\\?!");
        $this->assertValidationFails($request, "icon", "Zero group", 99);
        $this->assertValidationFails($request, "icon", "Negative group", -100);
        $this->assertValidationFails($request, "icon", "Nonexistent group", 1001);
    }
}
