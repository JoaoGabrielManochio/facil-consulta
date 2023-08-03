<?php

namespace App\Services;

use App\Repositories\Interfaces\MedicoRepositoryInterface;
use App\Repositories\Interfaces\PacienteRepositoryInterface;
use App\Services\Interfaces\PacienteServiceInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PacienteService
 * @package App\Services
 */
class PacienteService implements PacienteServiceInterface
{
    private $patientRepository;
    private $doctorRepository;

    public function __construct(
        PacienteRepositoryInterface $patientRepository,
        MedicoRepositoryInterface $doctorRepository
    ) {
        $this->patientRepository = $patientRepository;
        $this->doctorRepository = $doctorRepository;
    }

    /**
     * Return list of patients
     *
     * @param array $params
     * @return Collection
     */
    public function listPatients(int $medicoId): array
    {
        $list = [];

        $doctor = $this->doctorRepository->find($medicoId);

        foreach ($doctor->medicosPacientes as $doctorPatient) {
            $list[] = $doctorPatient->pacientes;
        }

        return $list;
    }
}
