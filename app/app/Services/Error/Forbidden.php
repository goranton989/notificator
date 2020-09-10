<?php

namespace App\Services\Error;

final class Forbidden implements ErrorInterface
{
    public static int $STATUS_CODE = 403;

    public function getErrorResponseCode(): int
    {
        return self::$STATUS_CODE;
    }

    public function getMessage(): string
    {
        return 'Resource is forbidden.';
    }

    public function getHeader(): array
    {
        return [];
    }
}
