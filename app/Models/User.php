<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property Carbon $email_verified_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $remember_token
 * @property Collection|Entry[] $entries
 * @property Collection|Photo[] $photos
 * @property Collection|Goal[] $goals
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'name',
        'email',
        'email_verified_at',
        'created_at',
        'updated_at',
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }


    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }


    public function goals(): hasMany
    {
        return $this->hasMany(Goal::class);
    }


    public function transactions(): hasMany {
        return $this->hasMany(Transaction::class);
    }
}
