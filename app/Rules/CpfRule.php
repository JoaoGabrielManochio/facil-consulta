<?php

namespace App\Rules;

use Bissolli\ValidadorCpfCnpj\CPF as CPFValidator;
use Illuminate\Contracts\Validation\Rule;

class CpfRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (new CPFValidator($value))->isValid();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O CPF informado não é válido';
    }
}
