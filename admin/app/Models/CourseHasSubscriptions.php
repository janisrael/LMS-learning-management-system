<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SubscriptionProducts;
class CourseHasSubscriptions extends Model
{
    const NAME = "course_has_subscriptions";
    protected $table = 'course_has_subscriptions';
    public $timestamps = true;

    protected $fillable = [
        'course_number',
        'subscription_id',
        'created_by'
    ];

    protected $appends = ['details'];

    public function details()
    {
        return $this->hasOne(SubscriptionProducts::class, 'id', 'subscription_id');
    }

    public function getDetailsAttribute(){
        return $this->details()->first();
    }
}
