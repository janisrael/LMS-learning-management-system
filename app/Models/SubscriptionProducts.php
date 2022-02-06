<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CourseDetails;

class SubscriptionProducts extends Model
{
    const NAME = "subscription_products";
    protected $table = 'subscription_products';
    public $timestamps = true;

    protected $fillable = [
        'product_id',
        'name',
        'description',
        'created_by'
    ];

    
}
