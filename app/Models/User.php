<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Collection as LaravelCollection;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property Carbon $email_verified_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $remember_token
 * @property LaravelCollection|Collection[] $collections
 * @property LaravelCollection|Activity[] $activities
 * @property LaravelCollection|Entry[] $entries
 * @property LaravelCollection|Photo[] $photos
 * @property LaravelCollection|Goal[] $goals
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


    public function collections(): HasMany
    {
        return $this->hasMany(Collection::class);
    }


    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }


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
}
