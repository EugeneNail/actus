<?php

namespace Tests\Feature\Collection;

use App\Http\Requests\Collection\StoreRequest;
use App\Models\Collection;
use App\Models\User;
use Exception;
use Tests\Feature\AuthorizedTestCase;

class StoreTest extends AuthorizedTestCase
{
    /**
     * @throws Exception
     */
    public function test_successful(): void
    {
        $this
            ->post(route('collections.store'), [
                'name' => 'Здоровый образ жизни',
                'color' => 6
            ])
            ->assertRedirect(route('collections.index'))
            ->assertSessionHasNoErrors();

        $this
            ->assertDatabaseCount('collections', 1)
            ->assertDatabaseHas('collections', [
                'name' => 'Здоровый образ жизни',
                'color' => 6,
                'user_id' => 1
            ]);
    }


    public function test_has_invalid_data(): void
    {
        $this
            ->post(route('collections.store'), [
                'name' => 'Чрезмерно длинное название для коллекции',
                'color' => 0
            ], ['Referer' => route('collections.create')]
            )
            ->assertRedirect(route('collections.create'))
            ->assertSessionHasErrors(['name', 'color']);

        $this->assertDatabaseCount('collections', 0);
    }


    public function test_too_many(): void
    {
        Collection::factory()->count(20)->for(User::first())->create();

        $this
            ->assertDatabaseCount('collections', 20)
            ->get(route('collections.create'), ['Referer' => route('collections.index')])
            ->assertRedirect(route('collections.index'));

        $this
            ->post(route('collections.store'), [
                'name' => 'Supervalid name',
                'color' => 1,
            ], ['Referer' => route('collections.create')])
            ->assertRedirect(route('collections.create'))
            ->assertSessionHasErrors(['name']);

        $this
            ->assertDatabaseCount('collections', 20)
            ->assertDatabaseMissing('collections', [
                'name' => 'Supervalid name',
                'color' => 1,
                'user_id' => 1
            ]);
    }


    public function test_avoids_creating_name_duplicates(): void
    {
        $existing = Collection::factory()->for(User::first())->create();
        $route = route('collections.create');

        $this
            ->post(route('collections.store'), [
                'name' => $existing->name,
                'color' => 1,
            ], ['Referer' => $route])
            ->assertRedirect($route)
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseCount('collections', 1)->assertDatabaseMissing('collections', ['id' => 2]);
    }


    /**
     * @throws Exception
     */
    public function test_validation(): void
    {
        $request = StoreRequest::class;

        $this->assertValidationPasses($request, 'name', 'Short', 'Бег');
        $this->assertValidationPasses($request, 'name', 'One word', 'Спорт');
        $this->assertValidationPasses($request, 'name', 'Multiple words', 'Уборка дома');
        $this->assertValidationPasses($request, 'name', 'Numbers', 'Играл 8 часов');
        $this->assertValidationPasses($request, 'name', 'Only numbers', '1263 123 6662 123');
        $this->assertValidationPasses($request, 'name', 'Dash', 'Спал 3-4 часа');
        $this->assertValidationPasses($request, 'name', 'Long', 'Ходил туда в магазин');
        $this->assertValidationPasses($request, 'color', 'Color 1', 1);
        $this->assertValidationPasses($request, 'color', 'Color 2', 2);
        $this->assertValidationPasses($request, 'color', 'Color 3', 3);
        $this->assertValidationPasses($request, 'color', 'Color 4', 4);
        $this->assertValidationPasses($request, 'color', 'Color 5', 5);
        $this->assertValidationPasses($request, 'color', 'Color 6', 6);

        $this->assertValidationFails($request, 'name', 'Too short', 'Ад');
        $this->assertValidationFails($request, 'name', 'Too long', 'Поешь этих мягких булок');
        $this->assertValidationFails($request, 'name', 'Has comma', 'Вчера, сегодня');
        $this->assertValidationFails($request, 'name', 'Has period', 'Бегать. Спать.');
        $this->assertValidationFails($request, 'name', 'Has other symbols', '@"!?;');
        $this->assertValidationFails($request, 'color', 'Less than min', 0);
        $this->assertValidationFails($request, 'color', 'Nonexistent', 7);
    }
}
