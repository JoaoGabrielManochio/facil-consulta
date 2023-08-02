<?php

namespace App\Services;

use App\Models\Medico;
use App\Repositories\Interfaces\CidadeRepositoryInterface;
use App\Repositories\Interfaces\MedicoRepositoryInterface;
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

    public function __construct(
        MedicoRepositoryInterface $doctorRepository,
        CidadeRepositoryInterface $cityRepository
    ) {
        $this->doctorRepository = $doctorRepository;
        $this->cityRepository = $cityRepository;
    }

    /**
     * Return list of doctors
     *
     * @return Collection
     */
    public function listDoctors(): Collection
    {
        return $this->doctorRepository->all();
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
}
