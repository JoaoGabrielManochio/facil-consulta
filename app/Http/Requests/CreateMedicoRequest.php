<?php

namespace App\Http\Requests;

use App\Repositories\Interfaces\CidadeRepositoryInterface;
use App\Repositories\Interfaces\MedicoRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class CreateMedicoRequest extends FormRequest
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
            'nome' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    self::validateNomeAndEspecialidade($attribute, $value, $fail);
                }
            ],
            'especialidade' => [
                'required',
                'string'
            ],
            'cidade_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    self::validateCidadeId($attribute, $value, $fail);
                }
            ]
        ];
    }

    /**
     * Validates if the informed city_id exists.
     *
     * @return array
     */
    private static function validateCidadeId($attribute, $value, $fail): void
    {
        $repositoryCity = app(CidadeRepositoryInterface::class);

        if (!$repositoryCity->find($value)) {
            $fail('O ID informado no cidade_id não existe!');
        }
    }

    /**
     * Validates if there is a doctor with the same name and specialty.
     *
     * @return array
     */
    private static function validateNomeAndEspecialidade($attribute, $value, $fail): void
    {
        $repositoryDoctor = app(MedicoRepositoryInterface::class);

        $hasDoctor = $repositoryDoctor->allQuery(
            [
                'nome' => $value,
                'especialidade' => request()->especialidade
            ]
        )->count();

        if ($hasDoctor) {
            $fail('Médico informado já existente!');
        }
    }
}
