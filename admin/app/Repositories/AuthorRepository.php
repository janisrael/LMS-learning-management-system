<?php
namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Author;
use Illuminate\Support\Facades\DB;

class AuthorRepository extends Repository
{
    protected $model = null;

    public function __construct(Author $model){
        $this->model = $model;
    }

    public function search($filter)
    {
        $term = $filter['term'];
        $query = Author::query();
        return $query;
    }
}
