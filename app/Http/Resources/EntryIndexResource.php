<?php

namespace App\Http\Resources;

use App\Models\Entry;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Entry
 */
class EntryIndexResource extends JsonResource
{
    public static $wrap = null;

    public int $userGoalCount;


    public function __construct(Entry $entry, $userGoalCount)
    {
        parent::__construct($entry);
        $this->userGoalCount = $userGoalCount;
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
            'mood' => $this->mood,
            'weather' => $this->weather,
            'goalsTotal' => $this->userGoalCount,
            'goals' => GoalResource::collection($this->goals),
            'date' => $this->date,
            'diary' => $this->diary ?? '',
            'photos' => $this->photos->map(fn($photo) => $photo->name)->toArray()
        ];
    }
}
