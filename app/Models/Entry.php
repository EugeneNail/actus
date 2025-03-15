<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $mood
 * @property int $weather
 * @property float $weight
 * @property Carbon $date
 * @property string $diary
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 * @property Collection|Photo[] $photos
 * @property Collection|Goal[] $goals
 */
class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'mood',
        'weather',
        'sleeptime',
        'weight',
        'worktime',
        'date',
        'diary',
    ];

    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }


    public function goals(): BelongsToMany
    {
        return $this->belongsToMany(Goal::class, 'entries_goals');
    }
}
