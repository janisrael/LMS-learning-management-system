<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Course;
use App\Models\CourseHasSubscriptions;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
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

    public function handleUpdate($request, $data, $id) {
        
        $query = Course::findorfail($id);
        $subs_collection = $request->subs_list;
        if (!$subs_collection) {
            return response(['status' => 'error', 'message' => 'Please Select atleast 1 Subscriptions'], 400);
        }
        else {
            DB::transaction(function () use ($id, $subs_collection, $request) {
                $check_subs = CourseHasSubscriptions::where('course_id', '=', $request->id)->get();

                foreach($check_subs as $check => $check_value) {
                    $item_to_delete = CourseHasSubscriptions::find($check_value->id);
                    $item_to_delete->delete();
                };

                foreach($subs_collection as $item => $value){
                    $subscriptions = new CourseHasSubscriptions;
                    $subscriptions->course_id = $id;
                    $subscriptions->subscription_id = $value;
                    $subscriptions->created_by = 1;
                    $subscriptions->save();
                };
        
            });
            $query->update($data);
            return response(['status' => 'success', 'data' => $query], 200);
        }
    }
}