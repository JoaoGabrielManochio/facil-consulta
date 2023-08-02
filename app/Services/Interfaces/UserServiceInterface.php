<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface UserServiceInterface
{
    public function listUsers(): Collection;
}
