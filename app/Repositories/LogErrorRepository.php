<?php

namespace App\Repositories;

use App\Models\LogError;
use App\Repositories\Interfaces\LogErrorRepositoryInterface;

/**
 * Class LogErrorRepository
 * @package App\Repositories
 */
class LogErrorRepository extends BaseRepository implements LogErrorRepositoryInterface
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'route',
        'error',
        'created_at',
        'updated_at',
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
        return LogError::class;
    }
}
