<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\SubscriptionProducts;
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
    
      return $query;
    }
}
