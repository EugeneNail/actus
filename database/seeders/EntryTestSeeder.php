<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Collection;
use App\Models\Entry;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class EntryTestSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        Collection::factory()
            ->for($user)
            ->count(20)
            ->has(Activity::factory()->for($user)->count(20))
            ->create();
        Entry::factory()->for($user)->count(100)->create();


        $activities = Activity::all();
        Entry::all()->each(function (Entry $entry) use($activities) {
            $entry->activities()->attach(
                $activities->random(rand(15, 35))->pluck('id')->toArray()
            );
        });
    }
}
