<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection as LaravelCollection;

/**
 * @property int $id
 * @property string $name
 * @property int $icon
 * @property int $user_id
 * @property int $collection_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 * @property Collection $collection
 * @property LaravelCollection|Entry[] $entries
 */
class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'icon',
    ];

    protected $hidden = [
        'user_id',
        'collection_id',
        'created_at',
        'updated_at',
        'pivot'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }


    public function entries(): BelongsToMany
    {
        return $this->belongsToMany(Entry::class);
    }
}
