<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\SubscriptionProducts;
use App\Models\CourseDetails;
use Illuminate\Support\Facades\DB;

class SubscriptionProductsRepository extends Repository
{
    protected $model = null;

    public function __construct(SubscriptionProducts $model){
        $this->model = $model;
    }

    public function search($filter)
    {
        $term = $filter['term'];
        $query = SubscriptionProducts::query();
        // $queryd = SubscriptionProducts::query();
        // if($term) {
          // $col = CourseDetails::where('course_id', $term)->get();
          // $new_col = [];
          // $i = 0;
          // foreach($col as $item){
          //   $new_col[$i] = ($item->subscription_id);
          //   $i++;
          // };

          // foreach($query as $item) {
          //   foreach($new_col as $col) {
          //     if($item->id === $col) {
          //       $query['course_id'] = $item->course_id;
          //     }
          //   }
          // }
          // $query = $query->whereIn('id',$new_col);

        //   // dd($query)->toArray();
        // }
    
      return $query;
    }
}
