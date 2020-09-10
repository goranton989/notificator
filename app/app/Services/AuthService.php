<?php

namespace App\Services;

use App\Models\User;
use App\Services\Auth\Interfaces\AuthDriverInterface;
use App\Services\Error\ErrorService;
use App\Services\Validation\ValidationService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AuthService {
    protected string $ip;

    private User $user;
    private ErrorService $errorService;
    private ValidationService $validationService;
    private AuthDriverInterface $driver;

    public function __construct(ErrorService $errorService,
                                ValidationService $validationService,
                                AuthDriverInterface $driver)
    {
        $this->errorService = $errorService;
        $this->validationService = $validationService;
        $this->driver = $driver;
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
     * @return User|Builder|Model|object
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
     * @return User|Builder|Model
     */
    public function create(array $credentials, string $password)
    {
        $password = $this->hashPassword($password);
        $ip = $this->ip;

        return User::query()
            ->updateOrCreate(compact('ip'), array_merge(
                $credentials,
                compact('password'),
                ['ip' => null],
            ));
    }

    public function login($credentials) {
        return $this->driver->login($credentials);
    }

    public function logout(User $user)
    {
        return $this->driver->logout($user);
    }

    public function getUser(): User {
        return $this->user;
    }
}
