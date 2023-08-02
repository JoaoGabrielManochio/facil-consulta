<?php

namespace App\Http\Controllers;

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

    public function __construct(UserServiceInterface $userInterface)
    {
        $this->user = $userInterface;
    }

    /**
     * Return a list of users
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function list(): JsonResponse
    {
        // -> verificar catch
        try {
            return response()->json(
                $this->user->listUsers()
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    $e->getMessage()
                ],
                400
            );
        }
    }
}
