<?php

namespace App\Services;

use App\Models\Medico;
use App\Repositories\Interfaces\CidadeRepositoryInterface;
use App\Repositories\Interfaces\MedicoPacienteRepositoryInterface;
use App\Repositories\Interfaces\MedicoRepositoryInterface;
use App\Repositories\Interfaces\PacienteRepositoryInterface;
use App\Services\Interfaces\MedicoServiceInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class MedicoService
 * @package App\Services
 */
class MedicoService implements MedicoServiceInterface
{
    private $doctorRepository;
    private $cityRepository;
    private $doctorPatientRepository;
    private $patientRepository;

    public function __construct(
        MedicoRepositoryInterface $doctorRepository,
        CidadeRepositoryInterface $cityRepository,
        MedicoPacienteRepositoryInterface $doctorPatientRepository,
        PacienteRepositoryInterface $patientRepository
    ) {
        $this->doctorRepository = $doctorRepository;
        $this->cityRepository = $cityRepository;
        $this->doctorPatientRepository = $doctorPatientRepository;
        $this->patientRepository = $patientRepository;
    }

    /**
     * Return list of doctors
     *
     * @param array $params
     * @return Collection
     */
    public function listDoctors(array $params = []): Collection
    {
        return $this->doctorRepository->all($params);
    }

    /**
     * Create a new doctor
     *
     * @param array $params
     * @return Medico|null
     */
    public function storeDoctor(array $params): ?Medico
    {
        if (!self::validateDoctorInput($params)) {
            return null;
        }

        return $this->doctorRepository->create($params);
    }

    /**
     * Validate if the array has all the requeried index
     *
     * @param array $input
     * @return bool
     */
    private function validateDoctorInput(array $input): bool
    {
        $validate = true;

        $allQueryParams = [
            'nome' => $input['nome'] ?? '',
            'especialidade' => $input['especialidade'] ?? ''
        ];

        if (
            empty($input['nome']) ||
            empty($input['especialidade']) ||
            empty($input['cidade_id']) ||
            !$this->cityRepository->find($input['cidade_id']) ||
            $this->doctorRepository->allQuery($allQueryParams)->count()
        ) {
            $validate = false;
        }

        return $validate;
    }

    /**
     * Store a new patient to a doctor
     *
     * @param array $params
     */
    public function storePatientToDoctor(array $params)
    {
        if (!self::validatePatientDoctorInput($params)) {
            return null;
        }

        $doctorPatient = $this->doctorPatientRepository->create($params);

        return [
            'medico' => $doctorPatient->medicos()->first(),
            'paciente' => $doctorPatient->pacientes()->first()
        ];
    }

    /**
     * Validate if the array has all the requeried index
     *
     * @param array $input
     * @return bool
     */
    private function validatePatientDoctorInput(array $input): bool
    {
        $validate = true;

        $allQueryParams = [
            'medico_id' => $input['medico_id'] ?? '',
            'paciente_id' => $input['paciente_id'] ?? ''
        ];

        if (
            empty($input['medico_id']) ||
            empty($input['paciente_id']) ||
            !$this->doctorRepository->find($input['medico_id']) ||
            !$this->patientRepository->find($input['paciente_id']) ||
            $this->doctorPatientRepository->allQuery($allQueryParams)->count()
        ) {
            $validate = false;
        }

        return $validate;
    }
}
