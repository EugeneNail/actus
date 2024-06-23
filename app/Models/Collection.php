<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'color',
        'user_id',
    ];

    protected $hidden = [
        'user_id',
    ];


    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
