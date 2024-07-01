<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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


    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }


    public function activities(): HasMany {
        return $this->hasMany(Activity::class);
    }
}
