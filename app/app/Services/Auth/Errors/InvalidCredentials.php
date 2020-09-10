<?php

namespace App\Services\Auth\Errors;

use App\Services\Error\ErrorInterface;

final class InvalidCredentials implements ErrorInterface
{
    public static int $STATUS_CODE = 403;

    public function getErrorResponseCode(): int
    {
        return self::$STATUS_CODE;
    }

    public function getMessage(): string
    {
        return 'Pass credentials is invalid.';
    }

    public function getHeader(): array
    {
        return [];
    }
}
