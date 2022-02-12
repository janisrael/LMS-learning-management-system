<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Chapter;
use App\Models\Course;

class Lesson extends Model
{
    const NAME = "lesson";
    protected $table = 'lessons';
    public $timestamps = true;

    protected $fillable = [
        'course_id',
        'chapter_id',
        'name',
        'description',
        'video_url',
        'sort_order',
        'image_url',
        'is_active',
        'author_id',
        'duration',
        'percentage',
        'craeted_by'
    ];
    protected $appends = ['chapter'];

    public function chapter()
    {
        return $this->hasOne(Chapter::class, 'id', 'chapter_id');
    }

    public function getChapterAttribute(){
        return $this->chapter()->first();
    }
    public function course()
    {
        return $this->hasOne(Course::class, 'id', 'course_id');
    }

    public function getCourseAttribute(){
        return $this->course()->first();
    }
}
