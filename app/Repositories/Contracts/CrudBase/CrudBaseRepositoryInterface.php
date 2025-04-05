<?php

namespace App\Repositories\Contracts\CrudBase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface CrudBaseRepositoryInterface
{
    public function getAll(bool $trashed) : Collection;
    public function getById(int $id) : ?Model;
    public function create(array $data) : ?Model;
    public function update(int $id, array $data) : ?Model;
    public function delete(int $id) : bool;
    public function restore(int $id) : bool;
}