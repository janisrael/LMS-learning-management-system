<?php
namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends Repository
{
    protected $model = null;

    public function __construct(User $model){
        $this->model = $model;
    }

    public function search($filter)
    {
        $term = $filter['term'];
        $query = User::query();
        return $query;
    }
}
