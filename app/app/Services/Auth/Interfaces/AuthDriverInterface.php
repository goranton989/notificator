<?php

namespace App\Services\Auth\Interfaces;

use App\Models\User;

interface AuthDriverInterface {
    public function login(array $credentials);
    public function logout(User $user);
}
