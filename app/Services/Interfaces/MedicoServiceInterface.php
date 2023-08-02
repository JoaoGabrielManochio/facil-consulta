<?php

namespace App\Services\Interfaces;

use App\Models\Medico;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface MedicoServiceInterface
 * @package App\Services\Interfaces
 */
interface MedicoServiceInterface
{
    public function listDoctors(): Collection;
    public function storeDoctor(array $params): ?Medico;
}
