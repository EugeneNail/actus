<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'mood',
        'weather',
        'date',
        'diary'
    ];

    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'date' => 'date',
    ];


    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }


    public function activities(): BelongsToMany {
        return $this->belongsToMany(Activity::class);
    }
}
