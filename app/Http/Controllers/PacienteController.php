<?php

namespace App\Http\Controllers;

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
}
