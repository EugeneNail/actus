<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection as LaravelCollection;

/**
 * @property string $name
 * @property int $icon
 * @property int $user_id
 * @property User $user
 * @property LaravelCollection|Entry[] $entries
 */
class Goal extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'icon',
    ];

    protected $hidden = [
        'user_id',
    ];


    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function entries(): BelongsToMany
    {
        return $this->belongsToMany(Entry::class, 'entries_goals');
    }
}
