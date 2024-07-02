<?php

namespace Tests\Feature\Entry;

use App\Http\Requests\Entry\StoreRequest;
use App\Models\Activity;
use App\Models\Collection;
use App\Models\Entry;
use App\Models\User;
use JsonException;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\AuthorizedTestCase;


class StoreTest extends AuthorizedTestCase
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
    }


    /**
     * @throws JsonException
     */
    public function test_store_successfully(): void
    {
        $this
            ->post(route('entries.store'), [
                'date' => date('Y-m-d'),
                'weather' => 3,
                'mood' => 2,
                'diary' => 'Сегодня произошло что-то хорошее',
                'activities' => [1, 2, 3, 4, 5, 6],
            ])
            ->assertRedirect(route('entries.index'))
            ->assertSessionHasNoErrors();

        $this
            ->assertDatabaseCount('entries', 1)
            ->assertDatabaseHas('entries', [
                'date' => date('Y-m-d'),
                'weather' => 3,
                'mood' => 2,
                'diary' => 'Сегодня произошло что-то хорошее',
            ])
            ->assertDatabaseCount('activity_entry', 6);

        for ($activityId = 1; $activityId <= 6; $activityId++) {
            $this->assertDatabaseHas('activity_entry', [
                'entry_id' => 1,
                'activity_id' => $activityId,
            ]);
        }
    }


    public function test_rejects_invalid_data(): void
    {
        $route = route('entries.create');

        $this
            ->post(route('entries.store'), [
                'date' => '2020-12-32',
                'weather' => -1,
                'mood' => 9,
                'diary' => str_repeat("characters", 501),
                'activities' => [1, 2, 3, 4, 5, 6],
            ], ['Referer' => $route])
            ->assertRedirect($route)
            ->assertSessionHasErrors(['date', 'weather', 'mood', 'diary']);

        $this
            ->assertDatabaseCount('entries', 0)
            ->assertDatabaseCount('activity_entry', 0);
    }


    public function test_avoids_creating_date_duplicates(): void
    {
        $existing = Entry::factory()->for(User::first())->create();
        $route = route('entries.create');

        $this
            ->post(route('entries.store'), [
                'date' => $existing->date,
                'weather' => 1,
                'mood' => 1,
                'diary' => '',
                'activities' => [1, 2, 3, 4, 5, 6],
            ], ['Referer' => $route])
            ->assertRedirect($route)
            ->assertSessionHasErrors(['date']);

        $this
            ->assertDatabaseCount('entries', 1)
            ->assertDatabaseCount('activity_entry', 0);
    }


    public function test_404_when_activity_does_not_exist(): void
    {
        $this
            ->post(route('entries.store'), [
                'date' => date('Y-m-d'),
                'weather' => 1,
                'mood' => 1,
                'diary' => '',
                'activities' => [1, 2, 3, 4, 5, 6, 7],
            ])
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $this
            ->assertDatabaseCount('entries', 0)
            ->assertDatabaseCount('activity_entry', 0);
    }


    public function test_404_when_activity_does_not_belong_to_user(): void
    {
        $newUser = User::factory()->create();
        $newCollection = Collection::factory()->for($newUser)->create();
        Activity::factory()->for($newUser)->for($newCollection)->create();

        $this
            ->post(route('entries.store'), [
                'date' => date('Y-m-d'),
                'weather' => 1,
                'mood' => 1,
                'diary' => '',
                'activities' => [1, 2, 3, 4, 5, 6, 7],
            ])
            ->assertStatus(Response::HTTP_NOT_FOUND);

        $this
            ->assertDatabaseCount('entries', 0)
            ->assertDatabaseCount('activity_entry', 0);
    }


    public function test_validation(): void
    {
        $request = StoreRequest::class;

        $this->assertValidationPasses($request, 'date', 'Date 1', '2020-01-01');
        $this->assertValidationPasses($request, 'date', 'Date 2', '2023-12-31');
        $this->assertValidationPasses($request, 'date', 'Today', date('Y-m-d'));
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

        $this->assertValidationFails($request, 'date', 'Has letters', '202o-02-02');
        $this->assertValidationFails($request, 'date', 'Invalid day', '2024-01-32');
        $this->assertValidationFails($request, 'date', 'Invalid month', '2024-00-01');
        $this->assertValidationFails($request, 'date', 'Invalid year', '20-01-01');
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
