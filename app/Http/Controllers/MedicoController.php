<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMedicoPacienteRequest;
use App\Http\Requests\CreateMedicoRequest;
use App\Services\Interfaces\LogErrorServiceInterface;
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
    private $logError;

    public function __construct(
        MedicoServiceInterface $doctorInterface,
        LogErrorServiceInterface $logErrorInterface
    ) {
        $this->doctor = $doctorInterface;
        $this->logError = $logErrorInterface;
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
            $params = [
                'route' => 'medicos.list',
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
    public function store(CreateMedicoRequest $request): JsonResponse
    {
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

            $params = [
                'route' => 'medicos.store',
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
     * Return a list of doctors by cidade_id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function listDoctorByCidadeId($cidadeId): JsonResponse
    {
        try {

            $params = [
                'cidade_id' => $cidadeId
            ];

            return response()->json(
                $this->doctor->listDoctors($params)
            );
        } catch (Exception $e) {

            $params = [
                'route' => 'cidades.listDoctorByCidadeId',
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
    public function storePatientToDoctor(CreateMedicoPacienteRequest $request): JsonResponse
    {
        $params = $request->only(
            'paciente_id',
            'medico_id'
        );

        try {
            return response()->json(
                $this->doctor->storePatientToDoctor($params),
                201
            );
        } catch (Exception $e) {

            $params = [
                'route' => 'medicos.storePatientToDoctor',
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
