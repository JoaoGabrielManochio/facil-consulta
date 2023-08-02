<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface CidadeServiceInterface
 * @package App\Services\Interfaces
 */
interface CidadeServiceInterface
{
    public function listCitys(): Collection;
}
