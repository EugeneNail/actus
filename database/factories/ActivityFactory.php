<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    private array $iconIds;


    public function __construct($count = null, ?Collection $states = null, ?Collection $has = null, ?Collection $for = null, ?Collection $afterMaking = null, ?Collection $afterCreating = null, $connection = null, ?Collection $recycle = null)
    {
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection, $recycle);
        $this->iconIds = [
            ...range(100, 129),
            ...range(200, 226),
            ...range(300, 339),
            ...range(400, 419),
            ...range(500, 511),
            ...range(600, 619),
            ...range(700, 734),
            ...range(800, 809),
            ...range(900, 918),
        ];
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'icon' => $this->iconIds[array_rand($this->iconIds)]
        ];
    }
}
