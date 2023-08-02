<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\MedicoServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class MedicoController
 * @package App\Http\Controllers
 */
class MedicoController extends Controller
{
    private $doctor;

    public function __construct(MedicoServiceInterface $doctorInterface)
    {
        $this->doctor = $doctorInterface;
    }

    /**
     * Return a list of doctors
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function list(): JsonResponse
    {
        try {
            return response()->json(
                $this->doctor->listDoctors()
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
