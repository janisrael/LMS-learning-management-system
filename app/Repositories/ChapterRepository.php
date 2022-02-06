<?php
namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Chapter;
use Illuminate\Support\Facades\DB;

class ChapterRepository extends Repository
{
    protected $model = null;

    public function __construct(Chapter $model){
        $this->model = $model;
    }

    public function search($filter)
    {
        $term = $filter['term'];
        $query = Chapter::query();
        return $query;
    }
}
