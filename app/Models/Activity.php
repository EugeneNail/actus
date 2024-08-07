<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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


    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }


    public function collection(): BelongsTo {
        return $this->belongsTo(Collection::class);
    }


    public function entries(): BelongsToMany {
        return $this->belongsToMany(Entry::class);
    }
}
