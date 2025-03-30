<?php

namespace App\Http\Resources;

use App\Models\Entry;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @mixin Entry
 */
class EntryCardResource extends JsonResource
{
    public static $wrap = null;

    /** @var Collection<Goal> */
    public Collection $userGoals;

    /** @var int[] */
    public array $latestGoalCompletions;


    /**
     * @param Entry $entry
     * @param Collection<Goal> $userGoals
     * @param int[] $latestGoalCompletions
     */
    public function __construct(Entry $entry, Collection $userGoals, array $latestGoalCompletions)
    {
        parent::__construct($entry);
        $this->userGoals = $userGoals;
        $this->latestGoalCompletions = $latestGoalCompletions;
    }


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'latestGoalCompletions' => null,
            'userGoals' => $this->userGoals,
            'goals' => $this->goals->map(fn(Goal $goal) => new GoalResource($goal)),
            'mood' => $this->mood,
            'weather' => $this->weather,
            'diary' => $this->diary ?? '',
            'photos' => $this->photos->map(fn($photo) => $photo->name)->toArray()
        ];
    }
}
