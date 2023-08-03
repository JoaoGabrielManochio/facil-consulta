<?php

namespace App\Services\Interfaces;

use App\Models\Paciente;

/**
 * Interface PacienteServiceInterface
 * @package App\Services\Interfaces
 */
interface PacienteServiceInterface
{
    public function listPatients(int $medicoId): array;
    public function storePatient(array $params): ?Paciente;
    public function updatePatient(int $patientId, array $params): ?Paciente;
}
