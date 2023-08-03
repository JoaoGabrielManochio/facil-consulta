<?php

namespace App\Providers;

use App\Repositories\MedicoPacienteRepository;
use App\Repositories\Interfaces\MedicoPacienteRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class MedicoPacienteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MedicoPacienteRepositoryInterface::class, MedicoPacienteRepository::class);
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
