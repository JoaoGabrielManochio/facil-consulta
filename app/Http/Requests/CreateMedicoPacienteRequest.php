<?php

namespace App\Http\Requests;

use App\Repositories\Interfaces\MedicoPacienteRepositoryInterface;
use App\Repositories\Interfaces\MedicoRepositoryInterface;
use App\Repositories\Interfaces\PacienteRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class CreateMedicoPacienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'paciente_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    self::validatePatient($attribute, $value, $fail);
                }
            ],
            'medico_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    self::validateDoctor($attribute, $value, $fail);
                    self::validatePatientDoctor($attribute, $value, $fail);
                }
            ]
        ];
    }

    /**
     * Validates if there is a patient.
     *
     * @return void
     */
    private static function validatePatient($attribute, $value, $fail): void
    {
        $repositoryPatient = app(PacienteRepositoryInterface::class);

        if (!$repositoryPatient->find($value)) {
            $fail('Paciente ID informado não existente!');
        }
    }

    /**
     * Validates if there is a doctor.
     *
     * @return void
     */
    private static function validateDoctor($attribute, $value, $fail): void
    {
        $repositoryDoctor = app(MedicoRepositoryInterface::class);

        if (!$repositoryDoctor->find($value)) {
            $fail('Médico ID informado não existente!');
        }
    }

    /**
     * Validates if there is a doctor.
     *
     * @return void
     */
    private static function validatePatientDoctor($attribute, $value, $fail): void
    {
        $repository = app(MedicoPacienteRepositoryInterface::class);

        $hasDoctorPatient = $repository->allQuery(
            [
                'medico_id' => $value,
                'paciente_id' => request()->paciente_id
            ]
        )->count();

        if ($hasDoctorPatient) {
            $fail('O paciente inforamdo já está cadastrado para o médico informado!');
        }
    }
}
