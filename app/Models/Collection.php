<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection as LaravelCollection;

/**
 * @property int $id
 * @property string $name
 * @property int $color
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 * @property LaravelCollection|Activity[] $activities
 */
class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'color',
    ];

    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}
