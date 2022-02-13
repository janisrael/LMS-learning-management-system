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

    // protected $appends= array('lessons');

    // public function lessons()
    // {
    //     return $this->hasMany(Lesson::class);
    // }

    // public function getLessonsAttribute(){
    //     return $this->lessons()->get();
    // }
}
