<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entry>
 */
class EntryFactory extends Factory
{
    public function definition(): array
    {
        $today = date('Y-m-d');
        $randomDate = rand(strtotime('Jan 1'), strtotime($today));

        return [
            'mood' => rand(1, 5),
            'weather' => rand(1, 6),
            'date' => date('Y-m-d', $randomDate),
            'diary' => fake()->words(10, true),
        ];
    }
}
