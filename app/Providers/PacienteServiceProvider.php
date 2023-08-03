<?php

namespace App\Providers;

use App\Repositories\PacienteRepository;
use App\Repositories\Interfaces\PacienteRepositoryInterface;
use App\Services\PacienteService;
use App\Services\Interfaces\PacienteServiceInterface;
use Illuminate\Support\ServiceProvider;

class PacienteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PacienteServiceInterface::class, PacienteService::class);
        $this->app->bind(PacienteRepositoryInterface::class, PacienteRepository::class);
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
