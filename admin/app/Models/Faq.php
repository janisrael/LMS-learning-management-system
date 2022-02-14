<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    const NAME = "faq";
    protected $table = 'lesson_faq';
    public $timestamps = true;

    protected $fillable = [
        'lesson_id',
        'question',
        'answer',
        'created_by',
        'status'
    ];
    protected $hidden = ['created_by','created_at','updated_at'];
}
