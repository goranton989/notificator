<?php

namespace App\Services\Auth\Drivers;

use App\Models\User;
use App\Services\Auth\Errors\InvalidCredentials;
use App\Services\Auth\Interfaces\AuthDriverInterface;
use App\Services\Error\ErrorService;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

/**
 * Login using bearer token
 * Class JWTAuth
 * @package App\Services\Auth\Drivers
 */
class JWTAuth implements AuthDriverInterface {
    /**
     * Create and return access token by pass credentials
     * @param array $credentials
     * @return string
     * @throws Exception
     */
    public function login(array $credentials): string
    {
        $credentials = Arr::only($credentials, ['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return false;
        }

        /** @var User $user */
        $user = Auth::user();

        return $user->createToken(config('app.name'))->accessToken;
    }

    /**
     * Revoke access token
     * @param User $user
     * @return bool
     */
    public function logout(User $user)
    {
        $user->token()->revoke();
        return true;
    }
}
