<?php

namespace App\Services;

use App\Repositories\Interfaces\CidadeRepositoryInterface;
use App\Services\Interfaces\CidadeServiceInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CidadeService
 * @package App\Services
 */
class CidadeService implements CidadeServiceInterface
{
    private $cityRepository;

    public function __construct(CidadeRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * Return list of citys
     *
     * @return Collection
     */
    public function listCitys(): Collection
    {
        return $this->cityRepository->all();
    }
}
