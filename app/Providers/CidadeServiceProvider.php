<?php

namespace App\Providers;

use App\Repositories\CidadeRepository;
use App\Repositories\Interfaces\CidadeRepositoryInterface;
use App\Services\CidadeService;
use App\Services\Interfaces\CidadeServiceInterface;
use Illuminate\Support\ServiceProvider;

class CidadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CidadeServiceInterface::class, CidadeService::class);
        $this->app->bind(CidadeRepositoryInterface::class, CidadeRepository::class);
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
