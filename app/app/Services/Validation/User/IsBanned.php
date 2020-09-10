<?php

namespace App\Services\Validation\User;

use App\Models\User;
use App\Services\Error\ErrorInterface;
use App\Services\Error\UserBanned;
use App\Services\Validation\Interfaces\ValidationInterface;

/**
 * Validate is user banned.
 * Class IsBanned
 * @package App\Services\Validations
 */
class IsBanned implements ValidationInterface
{
    public function getErrorInstance(): ErrorInterface
    {
        return new UserBanned();
    }

    /**
     * Return user banned status
     * @param User|null $user
     * @return bool
     */
    public function validate($user = null): bool
    {
        if (!$user) {
            return false;
        }

        return !$user->isBanned();
    }
}
