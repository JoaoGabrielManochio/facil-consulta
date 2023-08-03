<?php

namespace App\Repositories;

use App\Models\MedicoPaciente;
use App\Repositories\Interfaces\MedicoPacienteRepositoryInterface;

/**
 * Class MedicoPacienteRepository
 * @package App\Repositories
 */
class MedicoPacienteRepository extends BaseRepository implements MedicoPacienteRepositoryInterface
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'paciente_id',
        'medico_id',
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
        return MedicoPaciente::class;
    }
}
