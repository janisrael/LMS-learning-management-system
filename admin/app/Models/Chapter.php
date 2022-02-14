<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson;

class Chapter extends Model
{
    const NAME = "chapter";
    protected $table = 'chapters';
    public $timestamps = true;

    protected $fillable = [
        'course_id',
        'chapter_num',
        'name',
        'description',
        'sort_order',
        'is_active',
        'course_percentage',
        'created_by'
    ];
    protected $hidden = ['created_by','created_at','updated_at'];
    // protected $hidden = array('lessons');
    // protected $appends = array('course');

    // public function course()
    // {
    //     return $this->hasOne(Course::class, 'id', 'course_id');
    // }

    // public function getCourseAttribute(){
    //     return $this->course()->first();
    // }
}
