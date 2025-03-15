<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property int $icon
 * @property int $user_id
 * @property User $user
 * @property Collection|Entry[] $entries
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
