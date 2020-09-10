<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 *
 * @OA\Schema(
     * required={"password"},
     * @OA\Xml(name="User"),
     * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
     * @OA\Property(property="email", type="string", readOnly="true", format="email", description="User unique email address", example="user@gmail.com"),
     * @OA\Property(property="email_verified_at", type="string", readOnly="true", format="date-time", description="Datetime marker of verification status", example="2019-02-25 12:59:20"),
     * @OA\Property(property="name", type="string", maxLength=32, example="Anton"),
 * )
 *
 * @property string name user name
 * @property string password user password
 * @property string ip user ip
 * @property boolean banned is user is blocked
 * @property MessageAttempt messageAttempt
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

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
