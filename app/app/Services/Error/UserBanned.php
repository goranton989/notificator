<?php

namespace App\Services\Error;

final class UserBanned implements ErrorInterface
{
    public static int $STATUS_CODE = 403;

    public function getErrorResponseCode(): int
    {
        return self::$STATUS_CODE;
    }

    public function getMessage(): string
    {
        return 'User has been banned.';
    }

    public function getHeader(): array
    {
        return [];
    }
}
