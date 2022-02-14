<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    const NAME = "resource";
    protected $table = 'lesson_resources';
    public $timestamps = true;

    protected $fillable = [
        'lesson_id',
        'name',
        'file',
        'created_by',
        'status'
    ];
    protected $hidden = ['created_by','created_at','updated_at'];
}
