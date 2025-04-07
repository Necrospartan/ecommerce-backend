<?php
namespace App\Repositories\Eloquent\CrudBase;

use App\Repositories\Contracts\CrudBase\CrudBaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class CrudBaseRepository implements CrudBaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll(bool $trashed = false, int $perPage = 10) : LengthAwarePaginator
    {
        try {
            if ($trashed) {
                return $this->model->withTrashed()->paginate($perPage);
            } else {
                return $this->model->paginate($perPage);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return new LengthAwarePaginator(collect(), 0, $perPage);
        }
    }

    public function getById(int $id) : ?Model
    {
        try {
            $user = $this->model->findOrfail($id);
            return $user;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function create(array $data) : ?Model
    {
        try {
            $model = $this->model->create($data);
            return $model;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function update(int $id, array $data) : ?Model
    {
        try {
            $model = $this->model->findOrfail($id);
            $model->update($data);
            return $model;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function delete(int $id) : bool
    {
        try {
            $model = $this->model->findOrfail($id);
            $model->delete();
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function restore(int $id) : bool
    {
        try {
            $model = $this->model->withTrashed()->findOrfail($id);
            if (!$model->trashed()) {
                return false;
            }
            $model->restore();
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
