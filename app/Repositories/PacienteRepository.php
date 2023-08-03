<?php

namespace App\Repositories;

use App\Models\Paciente;
use App\Repositories\Interfaces\PacienteRepositoryInterface;

/**
 * Class PacienteRepository
 * @package App\Repositories
 */
class PacienteRepository extends BaseRepository implements PacienteRepositoryInterface
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nome',
        'cpf',
        'celular',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Paciente::class;
    }
}
