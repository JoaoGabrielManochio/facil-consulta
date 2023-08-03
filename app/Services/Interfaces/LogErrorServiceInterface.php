<?php

namespace App\Services\Interfaces;

/**
 * Interface LogErrorServiceInterface
 * @package App\Services\Interfaces
 */
interface LogErrorServiceInterface
{
    public function storeLog(array $params): void;
}
