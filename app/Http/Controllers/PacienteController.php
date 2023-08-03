<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePacienteRequest;
use App\Http\Requests\UpdatePacienteRequest;
use App\Services\Interfaces\LogErrorServiceInterface;
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
    private $logError;

    public function __construct(
        PacienteServiceInterface $patientInterface,
        LogErrorServiceInterface $logErrorInterface
    ) {
        $this->patient = $patientInterface;
        $this->logError = $logErrorInterface;
    }

    /**
     * Return a list of doctors by medico_id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function listPatientByMedicoId($medicoId): JsonResponse
    {
        try {
            return response()->json(
                $this->patient->listPatients($medicoId)
            );
        } catch (Exception $e) {

            $params = [
                'route' => 'medicos.listPatientDoctor',
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(CreatePacienteRequest $request): JsonResponse
    {
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

            $params = [
                'route' => 'pacientes.store',
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function update(UpdatePacienteRequest $request, int $patientId): JsonResponse
    {
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

            $params = [
                'route' => 'pacientes.update',
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
