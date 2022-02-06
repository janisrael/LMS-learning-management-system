<?php
namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Authors;
use Illuminate\Support\Facades\DB;

class AuthorsRepository extends Repository
{
    protected $model = null;

    public function __construct(Authors $model){
        $this->model = $model;
    }

    public function search($filter)
    {
        $term = $filter['term'];
        $query = Authors::query();
        return $query;
    }
}
