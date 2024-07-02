<?php

namespace Tests\Feature\Entry;

use App\Http\Requests\Entry\StoreRequest;
use App\Models\Activity;
use App\Models\Collection;
use App\Models\Entry;
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
        Collection::factory()
            ->for($user)
            ->has(Activity::factory()->for($user, 'user')->count(3))
            ->count(2)
            ->create();
        $entry = Entry::factory()->for($user)->create();
        $entry->activities()->attach([1, 2, 3, 4, 5, 6]);
    }


    public function test_passes_data_to_the_page_successfully(): void
    {
        $entry = Entry::first();
        $this
            ->get(route('entries.edit', 1))
            ->assertInertia(fn(AssertableInertia $assert) => $assert
                ->component('Entry/Save')
                ->where('entry.id', $entry->id)
                ->where('entry.date', $entry->date->toISOString())
                ->where('entry.mood', $entry->mood)
                ->where('entry.weather', $entry->weather)
                ->where('entry.activities', $entry->activities->map(fn($activity) => $activity->id))
            );

    }


    /**
     * @throws JsonException
     */
    public function test_updates_successfully(): void
    {
        $this
            ->put(route('entries.update', 1), [
                'weather' => 1,
                'mood' => 1,
                'diary' => 'Что-то случилось',
                'activities' => [1, 2, 3, 4],
            ])
            ->assertRedirect(route('entries.index'))
            ->assertSessionHasNoErrors();

        $this
            ->assertDatabaseCount('entries', 1)
            ->assertDatabaseHas('entries', [
                'weather' => 1,
                'mood' => 1,
                'diary' => 'Что-то случилось',
            ])
            ->assertDatabaseCount('activity_entry', 4);
    }


    public function test_rejects_invalid_data(): void
    {
        $entry = Entry::first();
        $route = route('entries.edit', $entry->id);

        $this
            ->put(route('entries.update', 1), [
                'mood' => 0,
                'weather' => 10,
                'diary' => str_repeat('Что-то случилось', 500),
                'activities' => [1, 2, 3, 4],
            ], ['Referer' => $route])
            ->assertRedirect($route)
            ->assertSessionHasErrors(['mood', 'weather', 'diary']);

        $this
            ->assertDatabaseCount('entries', 1)
            ->assertDatabaseMissing('entries', [
                'mood' => 0,
                'weather' => 10,
                'diary' => str_repeat('Что-то случилось', 500),
            ])
            ->assertDatabaseHas('entries', [
                'mood' => $entry->mood,
                'weather' => $entry->weather,
                'diary' => $entry->diary,
            ])
            ->assertDatabaseCount('activity_entry', 6);
    }


    public function test_404_when_activity_does_not_exist(): void
    {
        $entry = Entry::first();

        $this
            ->put(route('entries.update', 1), [
                'mood' => 1,
                'weather' => 1,
                'diary' => '',
                'activities' => [1, 2, 3, 4, 5, 6, 7],
            ])
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $this
            ->assertDatabaseCount('entries', 1)
            ->assertDatabaseMissing('entries', [
                'mood' => 1,
                'weather' => 1,
                'diary' => '',
            ])
            ->assertDatabaseHas('entries', [
                'mood' => $entry->mood,
                'weather' => $entry->weather,
                'diary' => $entry->diary,
            ])
            ->assertDatabaseCount('activity_entry', 6);
    }


    public function test_404_when_activity_does_not_belong_to_user(): void
    {
        $newUser = User::factory()->create();
        $newCollection = Collection::factory()->for($newUser)->create();
        Activity::factory()->for($newUser)->for($newCollection)->create();
        $entry = Entry::first();

        $this
            ->put(route('entries.update', 1), [
                'mood' => 1,
                'weather' => 1,
                'diary' => '',
                'activities' => [1, 2, 3, 4, 5, 6, 7],
            ])
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $this
            ->assertDatabaseCount('entries', 1)
            ->assertDatabaseMissing('entries', [
                'mood' => 1,
                'weather' => 1,
                'diary' => '',
            ])
            ->assertDatabaseHas('entries', [
                'mood' => $entry->mood,
                'weather' => $entry->weather,
                'diary' => $entry->diary,
            ])
            ->assertDatabaseCount('activity_entry', 6);
    }


    public function test_validation(): void
    {
        $request = StoreRequest::class;

        $this->assertValidationPasses($request, 'mood', 'Mood 1', 1);
        $this->assertValidationPasses($request, 'mood', 'Mood 2', 2);
        $this->assertValidationPasses($request, 'mood', 'Mood 3', 3);
        $this->assertValidationPasses($request, 'mood', 'Mood 4', 4);
        $this->assertValidationPasses($request, 'mood', 'Mood 5', 5);
        $this->assertValidationPasses($request, 'weather', 'Weather 1', 1);
        $this->assertValidationPasses($request, 'weather', 'Weather 2', 2);
        $this->assertValidationPasses($request, 'weather', 'Weather 3', 3);
        $this->assertValidationPasses($request, 'weather', 'Weather 4', 4);
        $this->assertValidationPasses($request, 'weather', 'Weather 5', 5);
        $this->assertValidationPasses($request, 'weather', 'Weather 6', 6);
        $this->assertValidationPasses($request, 'weather', 'Weather 7', 7);
        $this->assertValidationPasses($request, 'weather', 'Weather 8', 8);
        $this->assertValidationPasses($request, 'weather', 'Weather 9', 9);
        $this->assertValidationPasses($request, 'diary', 'Short', 'Что-то случилось.');
        $this->assertValidationPasses($request, 'diary', 'Multiline', "Первый абзац. \n Второй абзац. \n Третий абзац.");
        $this->assertValidationPasses($request, 'diary', 'Long', str_repeat("Long.", 100));
        $this->assertValidationPasses($request, 'diary', 'Has symbols', '/*?!.,-+=');
        $this->assertValidationPasses($request, 'activities', 'Some', [1, 3, 5]);
        $this->assertValidationPasses($request, 'activities', 'Existing', [1, 2, 3, 4, 5, 6]);

        $this->assertValidationFails($request, 'mood', 'Nonexistent 1', '-1');
        $this->assertValidationFails($request, 'mood', 'Nonexistent 2', '0');
        $this->assertValidationFails($request, 'mood', 'Nonexistent 3', '6');
        $this->assertValidationFails($request, 'mood', 'Letters', 'Good');
        $this->assertValidationFails($request, 'weather', 'Nonexistent', '-1');
        $this->assertValidationFails($request, 'weather', 'Nonexistent', '0');
        $this->assertValidationFails($request, 'weather', 'Nonexistent', '10');
        $this->assertValidationFails($request, 'weather', 'Letters', 'Windy');
        $this->assertValidationFails($request, 'diary', 'Too long', str_repeat("Very long", 600));
    }
}
