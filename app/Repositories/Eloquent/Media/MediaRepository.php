<?php
namespace App\Repositories\Eloquent\Media;

use App\Models\Media;
use App\Repositories\Contracts\Media\MediaRepositoryInterface;
use App\Repositories\Eloquent\CrudBase\CrudBaseRepository;

class MediaRepository extends CrudBaseRepository implements MediaRepositoryInterface
{
    protected $model;
    public function __construct(Media $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }
}
