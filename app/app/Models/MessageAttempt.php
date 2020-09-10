<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Carbon updated_at
 * @property integer number
 */
class MessageAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'number',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
        'number' => 'integer',
    ];

    public function lastAttemptInSeconds()
    {
        return $this->updated_at->diffInSeconds($this->updated_at);
    }

    public function touch() {
        if (config('notificator.attempts') <= $this->number) {
            return $this;
        }

        $this->number += 1;
        return parent::touch();
    }

    public function reset()
    {
        $this->number = 0;
        return $this->save();
    }
}
