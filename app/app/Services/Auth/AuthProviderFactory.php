<?php

namespace App\Services\Auth;

use App\Services\AuthService;
use App\Services\Error\ErrorService;
use App\Services\Validation\ValidationService;

final class AuthProviderFactory {
    /**
     * @param ErrorService $errorService
     * @param $request
     * @param ValidationService $validationService
     * @return AuthService
     */
    public static function build(
        ErrorService $errorService, $request, ValidationService $validationService
    ) {
        return (new AuthService($errorService, $validationService))
            ->setIp($request->ip());
    }
}
