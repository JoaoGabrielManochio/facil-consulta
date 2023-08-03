<?php

namespace App\Http\Requests;

use App\Repositories\Interfaces\PacienteRepositoryInterface;
use App\Rules\CpfRule;
use Illuminate\Foundation\Http\FormRequest;

class CreatePacienteRequest extends FormRequest
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
            ],
            'celular' => [
                'required',
                'string'
            ],
            'cpf' => [
                'required',
                new CpfRule(),
                function ($attribute, $value, $fail) {
                    self::validateCpf($attribute, $value, $fail);
                }
            ]
        ];
    }

    /**
     * Validates if the informed cpf exists.
     *
     * @return void
     */
    private static function validateCpf($attribute, $value, $fail): void
    {
        $repository = app(PacienteRepositoryInterface::class);

        $hasCpf = $repository->allQuery(
            [
                'cpf' => $value
            ]
        )->count();

        if ($hasCpf) {
            $fail('CPF informado já existente!');
        }
    }
}
