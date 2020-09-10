<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property string name user name
 * @property string password user password
 * @property string ip user ip
 * @property boolean banned is user is blocked
 * @property MessageAttempt messageAttempt
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'ip', 'banned',
    ];

    protected $hidden = [
        'password', 'remember_token', 'ip',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'banned' => 'boolean',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function isBanned(): bool
    {
        return !!$this->banned;
    }

    public static function makeGuest(string $ip)
    {
        return self::query()->create(compact('ip'));
    }

    public function messageAttempt(): HasOne
    {
        return $this->hasOne('App\Models\MessageAttempt');
    }
}
