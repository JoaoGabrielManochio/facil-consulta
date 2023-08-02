<?php

namespace App\Providers;

use App\Repositories\MedicoRepository;
use App\Repositories\Interfaces\MedicoRepositoryInterface;
use App\Services\MedicoService;
use App\Services\Interfaces\MedicoServiceInterface;
use Illuminate\Support\ServiceProvider;

class MedicoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MedicoServiceInterface::class, MedicoService::class);
        $this->app->bind(MedicoRepositoryInterface::class, MedicoRepository::class);
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
