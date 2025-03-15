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
        Entry::factory()->for($user)->count(100)->create();
    }
}
