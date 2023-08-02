<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UserService
 * @package App\Services
 */
class UserService implements UserServiceInterface
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Return list of users
     *
     * @return Collection
     */
    public function listUsers(): Collection
    {
        return $this->userRepository->all();
    }
}
