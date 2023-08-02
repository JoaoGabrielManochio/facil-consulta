<?php

namespace App\Repositories;

use App\Models\Medico;
use App\Repositories\Interfaces\MedicoRepositoryInterface;

/**
 * Class MedicoRepository
 * @package App\Repositories
 */
class MedicoRepository extends BaseRepository implements MedicoRepositoryInterface
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nome',
        'especialidade',
        'cidade_id',
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
        return Medico::class;
    }
}
