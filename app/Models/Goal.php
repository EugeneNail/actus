<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'created_at',
        'updated_at',
    ];


    public function user(): belongsTo {
        return $this->belongsTo(User::class);
    }


    public function entries(): BelongsToMany {
        return $this->belongsToMany(Entry::class, 'entries_goals');
    }
}
