<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

  
}
