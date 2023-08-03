<?php

namespace App\Providers;

use App\Repositories\LogErrorRepository;
use App\Repositories\Interfaces\LogErrorRepositoryInterface;
use App\Services\LogErrorService;
use App\Services\Interfaces\LogErrorServiceInterface;
use Illuminate\Support\ServiceProvider;

class LogErrorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LogErrorServiceInterface::class, LogErrorService::class);
        $this->app->bind(LogErrorRepositoryInterface::class, LogErrorRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
