<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Chapter;

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
  
}
