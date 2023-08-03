<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\LogErrorServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    private $user;
    private $logError;

    public function __construct(
        UserServiceInterface $userInterface,
        LogErrorServiceInterface $logErrorInterface
    ) {
        $this->user = $userInterface;
        $this->logError = $logErrorInterface;
    }

    /**
     * Return a list of users
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function list(): JsonResponse
    {
        try {
            return response()->json(
                $this->user->listUsers()
            );
        } catch (Exception $e) {
            $params = [
                'route' => 'users.list',
                'error' => $e
            ];

            $this->logError->storeLog($params);

            return response()->json(
                [
                    'Algo inesperado ocorreu, tente novamente ou entre em contato via e-mail'
                ],
                400
            );
        }
    }
}
