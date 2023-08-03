<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePacienteRequest;
use App\Http\Requests\UpdatePacienteRequest;
use App\Services\Interfaces\PacienteServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class PacienteController
 * @package App\Http\Controllers
 */
class PacienteController extends Controller
{
    private $patient;

    public function __construct(PacienteServiceInterface $patientInterface)
    {
        $this->patient = $patientInterface;
    }

     /**
     * Return a list of doctors by medico_id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function listPatientByMedicoId($medicoId): JsonResponse
    {
        // -> verificar catch
        try {
            return response()->json(
                $this->patient->listPatients($medicoId)
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
    public function store(CreatePacienteRequest $request): JsonResponse
    {
        // -> verificar catch

        $params = $request->only(
            'nome',
            'cpf',
            'celular'
        );

        try {
            return response()->json(
                $this->patient->storePatient($params),
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function update(UpdatePacienteRequest $request, int $patientId): JsonResponse
    {
        // -> verificar catch

        $params = $request->only(
            'nome',
            'celular'
        );

        try {
            return response()->json(
                $this->patient->updatePatient($patientId, $params),
                200
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
