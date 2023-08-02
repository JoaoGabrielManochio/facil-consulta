<?php

namespace App\Services;

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

    public function __construct(MedicoRepositoryInterface $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
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
}
