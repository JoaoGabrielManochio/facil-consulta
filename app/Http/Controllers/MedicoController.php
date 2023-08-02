<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMedicoRequest;
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
        // -> verificar catch

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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(CreateMedicoRequest $request): JsonResponse
    {
        // -> verificar catch

        $params = $request->only(
            'nome',
            'especialidade',
            'cidade_id'
        );

        try {
            return response()->json(
                $this->doctor->storeDoctor($params),
                201
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'error' => $e->getMessage(),
                    'success' => false
                ],
                400
            );
        }
    }
}
