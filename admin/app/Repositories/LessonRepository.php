<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;
class LessonRepository extends Repository
{
    protected $model = null;

    public function __construct(Lesson $model){
        $this->model = $model;
    }

    public function search($filter)
    {
        $term = $filter['term'];
        $query = Lesson::query();

        return $query;
    }
}
