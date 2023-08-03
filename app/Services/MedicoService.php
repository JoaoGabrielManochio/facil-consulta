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
    private $doctorPacientRepository;
    private $pacientRepository;

    public function __construct(
        MedicoRepositoryInterface $doctorRepository,
        CidadeRepositoryInterface $cityRepository,
        MedicoPacienteRepositoryInterface $doctorPacientRepository,
        PacienteRepositoryInterface $pacientRepository
    ) {
        $this->doctorRepository = $doctorRepository;
        $this->cityRepository = $cityRepository;
        $this->doctorPacientRepository = $doctorPacientRepository;
        $this->pacientRepository = $pacientRepository;
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
     * Store a new pacient to a doctor
     *
     * @param array $params
     */
    public function storePacientToDoctor(array $params)
    {
        if (!self::validatePacientDoctorInput($params)) {
            return null;
        }

        $doctorPacient = $this->doctorPacientRepository->create($params);

        return [
            'medico' => $doctorPacient->medicos()->first(),
            'paciente' => $doctorPacient->pacientes()->first()
        ];
    }

    /**
     * Validate if the array has all the requeried index
     *
     * @param array $input
     * @return bool
     */
    private function validatePacientDoctorInput(array $input): bool
    {
        $validate = true;

        if (
            empty($input['medico_id']) ||
            empty($input['paciente_id']) ||
            !$this->doctorRepository->find($input['medico_id']) ||
            !$this->pacientRepository->find($input['paciente_id'])
        ) {
            $validate = false;
        }

        return $validate;
    }
}
