<?php

namespace App\Http\Requests;

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
                    self::validatePacient($attribute, $value, $fail);
                }
            ],
            'medico_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    self::validateDoctor($attribute, $value, $fail);
                }
            ]
        ];
    }

    /**
     * Validates if there is a pacient.
     *
     * @return void
     */
    private static function validatePacient($attribute, $value, $fail): void
    {
        $repositoryPacient = app(PacienteRepositoryInterface::class);

        if (!$repositoryPacient->find($value)) {
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
}
