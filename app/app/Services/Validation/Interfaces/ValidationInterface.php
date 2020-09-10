<?php

namespace App\Services\Validation\Interfaces;

use App\Services\Error\ErrorInterface;

interface ValidationInterface {
    public function getErrorInstance(): ErrorInterface;
    public function validate($payload = null): bool;
}
