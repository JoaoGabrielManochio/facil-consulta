<?php

namespace App\Services\Interfaces;

/**
 * Interface PacienteServiceInterface
 * @package App\Services\Interfaces
 */
interface PacienteServiceInterface
{
    public function listPatients(int $medicoId): array;
}
