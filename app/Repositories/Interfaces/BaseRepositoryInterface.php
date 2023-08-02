<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface BaseRepositoryInterface
 * @package App\Repositories\Interface
 */
interface BaseRepositoryInterface
{
    // -> verificar
    public function makeModel(): Model;
    public function paginate(?int $perPage, array $columns = ['*']): LengthAwarePaginator;
    public function allQuery();
    public function all();
    public function create($input): Model;
    public function find($id, $columns = ['*']);
    public function update($input, $id);
    public function delete($id);
    public function forceDelete(int $id);
}
