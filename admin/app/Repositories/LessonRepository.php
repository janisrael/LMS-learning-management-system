<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LessonRepository extends Repository
{
    protected $model = null;

    public function __construct(Lesson $model){
        $this->model = $model;
    }

    public function search($filter)
    {
        $term = $filter['term'];
        $lessons = Lesson::orderBy('course_id','DESC')->get();

        $collections = [];
        foreach($lessons as $lesson) {
            if($lesson->course_id != null) {
               $course = Course::where('id','=',$lesson->course_id)->first();

               if($course) {
                   $lesson['course'] = $course;
               } else {
                $lesson['course'] = null;
               }
            } else {
                $lesson['course'] = null;
            }
        }

        return $lessons;
    }
}
