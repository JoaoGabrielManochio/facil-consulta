<?php

namespace App\Services;

use App\Models\Paciente;
use App\Repositories\Interfaces\MedicoRepositoryInterface;
use App\Repositories\Interfaces\PacienteRepositoryInterface;
use App\Rules\CpfRule;
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

     /**
     * Create a new doctor
     *
     * @param array $params
     * @return Paciente|null
     */
    public function storePatient(array $params): ?Paciente
    {
        if (!self::validatePatientInput($params)) {
            return null;
        }

        return $this->patientRepository->create($params);
    }

     /**
     * Validate if the array has all the requeried index
     *
     * @param array $input
     * @return bool
     */
    private function validatePatientInput(array $input): bool
    {
        $validate = true;

        $cpfRule = new CpfRule();

        $allQueryParams = [
            'cpf' => $input['cpf'] ?? ''
        ];

        if (
            empty($input['nome']) ||
            empty($input['cpf']) ||
            empty($input['celular']) ||
            !$cpfRule->passes($input['cpf'], $input['cpf']) ||
            $this->patientRepository->allQuery($allQueryParams)->count()
        ) {
            $validate = false;
        }

        return $validate;
    }
}
