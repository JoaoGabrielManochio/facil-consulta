<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Interface BaseRepositoryInterface
 * @package App\Repositories\Interface
 */
interface BaseRepositoryInterface
{
    public function makeModel(): Model;
    public function paginate(
        int $perPage,
        array $columns = ['*']
    ): LengthAwarePaginator;
    public function allQuery(
        array $search = [],
        ?int $skip = null,
        ?int $limit = null
    ): Builder;
    public function all(
        array $search = [],
        ?int $skip = null,
        ?int $limit = null,
        array $columns = ['*']
    );
    public function create(array $input): Model;
    public function find(int $id, array $columns = ['*']);
    public function update(array $input, int $id);
    public function delete(int $id): ?bool;
    public function forceDelete(int $id): ?bool;
}
