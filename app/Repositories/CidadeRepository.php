<?php

namespace App\Repositories;

use App\Models\Cidade;
use App\Repositories\Interfaces\CidadeRepositoryInterface;

/**
 * Class CidadeRepository
 * @package App\Repositories
 */
class CidadeRepository extends BaseRepository implements CidadeRepositoryInterface
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nome',
        'estado',
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
        return Cidade::class;
    }
}
