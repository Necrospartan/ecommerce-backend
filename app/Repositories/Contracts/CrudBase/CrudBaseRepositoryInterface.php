<?php

namespace App\Repositories\Contracts\CrudBase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface CrudBaseRepositoryInterface
{
    public function getAll(bool $trashed, int $perPage) : LengthAwarePaginator;
    public function getById(int $id) : ?Model;
    public function create(array $data) : ?Model;
    public function update(int $id, array $data) : ?Model;
    public function delete(int $id) : bool;
    public function restore(int $id) : bool;
}
