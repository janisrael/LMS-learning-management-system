<?php
namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Chapter;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
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
        $course_id = $filter['course_id'];
        $query = Chapter::query();

        if($id) {
            $query = $query->where('id','=', $id);
        }
        if($course_id) {
            $query = $query->where('course_id','=', $course_id);
        }
        
        return $query;
    }

    public function getLessonByChapter($request) {
        $queryd = Chapter::query();
        // dd($query);
        return response(['status' => 'success', 'data' => $query], 200);
    }
}
