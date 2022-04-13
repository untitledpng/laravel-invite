<?php

namespace Untitledpng\LaravelInvite;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../resources/migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(
            \Untitledpng\LaravelInvite\Contracts\Services\InviteServiceContract::class,
            \Untitledpng\LaravelInvite\Services\InviteService::class
        );
        $this->app->singleton(
            \Untitledpng\LaravelInvite\Contracts\Repositories\InviteRepositoryContract::class,
            \Untitledpng\LaravelInvite\Repositories\InviteRepository::class
        );
    }
}
