<?php

namespace App\Services\Error;

interface ErrorInterface
{
    public function getErrorResponseCode(): int;
    public function getMessage(): string;
    public function getHeader(): array;
}
