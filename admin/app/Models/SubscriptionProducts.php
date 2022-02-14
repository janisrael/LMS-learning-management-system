<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionProducts extends Model
{
    const NAME = "subscription_product";
    protected $table = 'subscription_product';
    public $timestamps = true;

    protected $fillable = [
        'product_id',
        'name',
        'description',
        'created_by'
    ];
    protected $hidden = ['created_by','created_at','updated_at'];
}
