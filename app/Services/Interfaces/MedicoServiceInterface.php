<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface MedicoServiceInterface
 * @package App\Services\Interfaces
 */
interface MedicoServiceInterface
{
    public function listDoctors(): Collection;
}
