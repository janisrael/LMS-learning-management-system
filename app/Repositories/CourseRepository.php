<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class CourseRepository extends Repository
{
    protected $model = null;

    public function __construct(Course $model){
        $this->model = $model;
    }

    public function search($filter)
    {
        $term = $filter['term'];
        $author_id = $filter['author_id'];
        $query = Course::query();
      
        if($term) {
            $query = $query->where('name','like','%' .$term. '%')
            ->orwhere('description','like','%' .$term. '%');
        }

        if($author_id) {
            $query = $query->where('author_id','=', $author_id);
        }
        // return $user->makeHidden('attribute')->toArray();
        // $query = $query->makeHidden(['chapters']);
        // $query->makeHidden(['id']);
    
        return $query;
    }
}
