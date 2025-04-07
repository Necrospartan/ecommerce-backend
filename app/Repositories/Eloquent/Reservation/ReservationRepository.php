<?php
namespace App\Repositories\Eloquent\Reservation;

use App\Models\Reservation;
use App\Repositories\Contracts\Reservation\ReservationRepositoryInterface;
use App\Repositories\Eloquent\CrudBase\CrudBaseRepository;

class ReservationRepository extends CrudBaseRepository implements ReservationRepositoryInterface
{
    protected $model;
    public function __construct(Reservation $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }
}
