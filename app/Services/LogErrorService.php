<?php

namespace App\Services;

use App\Repositories\Interfaces\LogErrorRepositoryInterface;
use App\Services\Interfaces\LogErrorServiceInterface;

/**
 * Class LogErrorService
 * @package App\Services
 */
class LogErrorService implements LogErrorServiceInterface
{
    private $logErrorRepository;

    public function __construct(LogErrorRepositoryInterface $logErrorRepository)
    {
        $this->logErrorRepository = $logErrorRepository;
    }

    /**
     * Store log error
     *
     * @return void
     */
    public function storeLog(array $params): void
    {
        $this->logErrorRepository->create($params);
    }
}
