<?php

namespace App\Models;
use App\Models\SubscriptionProducts;
use Illuminate\Database\Eloquent\Model;

class CourseDetail extends Model
{
    const NAME = "course_details";
    protected $table = 'course_details';
    public $timestamps = true;

    protected $fillable = [
        'course_id',
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
