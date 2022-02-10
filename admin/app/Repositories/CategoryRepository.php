<?php
namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Categories;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends Repository
{
    protected $model = null;

    public function __construct(Categories $model){
        $this->model = $model;
    }

    public function search($filter)
    {
        $term = $filter['term'];
        $query = Categories::query();
        return $query;
    }
}
