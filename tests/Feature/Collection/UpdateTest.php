<?php

namespace Tests\Feature\Collection;

use App\Http\Requests\Collection\UpdateRequest;
use App\Models\Collection;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\AuthorizedTestCase;

class UpdateTest extends AuthorizedTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $collection = Collection::factory()->for(User::first())->create();
        $this->assertDatabaseCount('collections', 1);
        $this->assertDatabaseHas('collections', [
            'id' => 1,
            'name' => $collection->name,
            'color' => $collection->color,
        ]);
    }


    /**
     * @throws \JsonException
     */
    public function test_updates_successfully(): void
    {
        $this
            ->put(route('collections.update', Collection::first()->id), [
                'name' => 'Занятия спортом',
                'color' => 3,
            ])
            ->assertRedirect(route('collections.index'))
            ->assertSessionHasNoErrors();

        $this
            ->assertDatabaseCount('collections', 1)
            ->assertDatabaseHas('collections', [
                'name' => 'Занятия спортом',
                'color' => 3,
            ]);
    }


    public function test_rejects_invalid_data(): void {
        $route = route('collections.create');

        $this
            ->put(route('collections.update', Collection::first()->id), [
                'name' => 'Название с символом!',
                'color' => 7,
            ], ['Referer' => $route])
            ->assertRedirect($route)
            ->assertSessionHasErrors(['name', 'color']);

        $this
            ->assertDatabaseCount('collections', 1)
            ->assertDatabaseMissing('collections', [
                'name' => 'Название с символом!',
                'color' => 7,
            ]);
    }


    public function test_page_loading_passes_current_state_successfully(): void
    {
        $collection = Collection::first();
        $this->get(route('collections.update', $collection->id))
            ->assertInertia(fn(AssertableInertia $assert) => $assert
                ->component('Collection/Save')
                ->where('id', $collection->id)
                ->where('name', $collection->name)
                ->where('color', $collection->color)
            );
    }


    public function test_redirects_when_collections_does_not_exist(): void
    {
        $this->get(route('collections.edit', 99))->assertStatus(Response::HTTP_NOT_FOUND);
        $this->put(route('collections.update', 99), ['name' => 'Название', 'color' => 1])->assertStatus(Response::HTTP_NOT_FOUND);
    }


    public function test_404_when_collections_does_not_belong_to_user(): void
    {
        $collection = Collection::factory()->for(User::factory())->create();
        $this->get(route('collections.edit', $collection->id))->assertStatus(Response::HTTP_NOT_FOUND);
        $this->put(route('collections.update', $collection->id), ['name' => 'Название', 'color' => 1])->assertStatus(Response::HTTP_NOT_FOUND);
    }


    public function test_avoids_creating_name_duplicates(): void
    {
        $first = Collection::first();
        $second = Collection::factory()->for(User::first())->create();
        $route = route('collections.update', $first->id);
        $this
            ->put(route('collections.update', $first->id), [
                'name' => $second->name,
                'color' => 5
            ], ['Referer' => $route])
            ->assertRedirect($route)
            ->assertSessionHasErrors(['name']);
    }


    /**
     * @throws \Exception
     */
    public function test_validation(): void
    {
        $request = UpdateRequest::class;

        $this->assertValidationPasses($request, "name", "Short", "Сон");
        $this->assertValidationPasses($request, "name", "One word", "Сидение");
        $this->assertValidationPasses($request, "name", "Multiple words", "Вставание рано");
        $this->assertValidationPasses($request, "name", "Numbers", "От 8 до 9");
        $this->assertValidationPasses($request, "name", "Only numbers", "234 4524");
        $this->assertValidationPasses($request, "name", "Dash", "С дефисом - во");
        $this->assertValidationPasses($request, "name", "Long", "Принарядил   котейку");
        $this->assertValidationPasses($request, "color", "Color 1", 1);
        $this->assertValidationPasses($request, "color", "Color 2", 2);
        $this->assertValidationPasses($request, "color", "Color 3", 3);
        $this->assertValidationPasses($request, "color", "Color 4", 4);
        $this->assertValidationPasses($request, "color", "Color 5", 5);
        $this->assertValidationPasses($request, "color", "Color 6", 6);

        $this->assertValidationFails($request, "name", "Too short", "Мб");
        $this->assertValidationFails($request, "name", "Too long", "Тут написано что-то очень длинное");
        $this->assertValidationFails($request, "name", "Has comma", "Ем, сплю, работаю");
        $this->assertValidationFails($request, "name", "Has period", "Вчера. Сегодня");
        $this->assertValidationFails($request, "name", "Has other symbols", "@'!?;");
        $this->assertValidationFails($request, "color", "Less than min", 0);
        $this->assertValidationFails($request, "color", "Nonexistent", 7);
    }
}
