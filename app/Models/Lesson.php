<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    const NAME = "lesson";
    protected $table = 'lessons';
    public $timestamps = true;

    protected $fillable = [
        'chapter_id',
        'name',
        'video_url',
        'description',
        'sort_order',
        'preview_image_url',
        'is_active',
        'author_id',
        'duration',
        'percentage'
    ];

  
}
