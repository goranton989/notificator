<?php

namespace App\Services;

use App\Models\User;
use App\Services\Error\ErrorService;
use App\Services\Validation\ValidationService;
use Exception;

class AuthService {
    protected string $ip;

    private User $user;
    private ErrorService $errorService;
    private ValidationService $validationService;

    public function __construct(ErrorService $errorService, ValidationService $validationService)
    {
        $this->errorService = $errorService;
        $this->validationService = $validationService;
    }


    /**
     * Store client ip
     * @param $ip string client ip
     * @return $this
     */
    public function setIp(string $ip): AuthService
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * Return user model instance find by ip
     * @param null|callable $notFoundCb - raise when user not found
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public function findByIp(callable $notFoundCb = null)
    {
        $instance = User::query()->where('ip', $this->ip);

        if (!$notFoundCb || !is_callable($notFoundCb)) {
            return $instance->first();
        }

        return $instance->firstOr($notFoundCb);
    }

    /**
     * Return user model instance by ip
     * @return AuthService
     */
    public function findOrCreateGuest(): AuthService
    {
        $this->user = $this->findByIp(function () {
            return User::makeGuest($this->ip);
        });

        return $this;
    }

    /**
     * Run passed validation rules
     * @throws Exception
     * @see ValidationService
     */
    public function validate(): AuthService {
        $this->validationService->runValidations($this->user);
        return $this;
    }

    /**
     * Return hash value of password
     * @param string $password
     * @return string
     */
    public function hashPassword(string $password): string {
        return bcrypt($password);
    }


    /**
     * Return new user instance
     * @param array $credentials
     * @param string $password
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $credentials, string $password)
    {
        $password = $this->hashPassword($password);
        return User::query()->create(array_merge($credentials, compact('password')));
    }

    public function getUser(): User {
        return $this->user;
    }
}
