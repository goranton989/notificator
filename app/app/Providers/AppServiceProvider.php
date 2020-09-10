<?php

namespace App\Providers;

use App\Services\Auth\AuthProviderFactory;
use App\Services\AuthService;
use App\Services\Error\ErrorService;
use App\Services\Validation\User\IsBanned;
use App\Services\Validation\ValidationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        ErrorService::class => ErrorService::class,
    ];

    public $bindings = [
        ValidationService::class => ValidationService::class,
    ];


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AuthService::class, function ($app) {
            /** @var ValidationService $validationService */
            $validationService = $app->make(ValidationService::class);
            $validationService->pushValidation(new IsBanned());

            return AuthProviderFactory::build(
                $app->make(ErrorService::class), $app->make('request'), $validationService
            );
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
