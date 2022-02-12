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
        $id = $filter['id'];
        $query = Chapter::query();

        if($id) {
            $query = $query->where('id','=', $id);
        }
        return $query;
    }
}
