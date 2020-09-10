<?php

namespace App\Services\Auth;

use App\Services\Auth\Interfaces\AuthDriverInterface;
use App\Services\AuthService;
use App\Services\Error\ErrorService;
use App\Services\Validation\ValidationService;

final class AuthProviderFactory
{
    /**
     * @param ErrorService $errorService
     * @param $request
     * @param ValidationService $validationService
     * @param AuthDriverInterface $driver
     * @return AuthService
     */
    public static function build(
        ErrorService $errorService,
        $request,
        ValidationService $validationService,
        AuthDriverInterface $driver
    ) {
        return (new AuthService($errorService, $validationService, $driver))
            ->setIp($request->ip());
    }
}
