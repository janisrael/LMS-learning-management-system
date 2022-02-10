<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    const NAME = "category";
    protected $table = 'categories';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'created_by'
    ];

    protected $hidden= array('created_by', 'updated_at', 'created_at');

    // public function lessons()
    // {
    //     return $this->hasMany(Lesson::class);
    // }

    // public function getLessonsAttribute(){
    //     return $this->lessons()->get();
    // }
}
