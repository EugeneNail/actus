<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    ];


    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }


    public function collection(): BelongsTo {
        return $this->belongsTo(Collection::class);
    }
}
