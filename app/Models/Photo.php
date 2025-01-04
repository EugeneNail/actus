<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $name
 * @property int $user_id
 * @property User $user
 * @property Entry $entry
 */
class Photo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'name';

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'user_id'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function entry(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
    }
}
