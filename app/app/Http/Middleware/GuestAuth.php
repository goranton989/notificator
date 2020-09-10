<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use Closure;
use Exception;
use Illuminate\Http\Request;

class GuestAuth
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    /**
     * Login by guest if user is not define
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user('api')) {
            return $next($request);
        }

        try {
            $user = $this->authService->findOrCreateGuest()
                ->validate()
                ->getUser();

            $request->setUserResolver(function () use ($user) {
                return $user;
            });
        } catch (Exception $e) {
            dd($e);
        }

        return $next($request);
    }
}
