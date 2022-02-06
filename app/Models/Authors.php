<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    const NAME = "authors";
    protected $table = 'authors';
    public $timestamps = true;

    protected $fillable = [
        'last_name',
        'first_name',
        'image_url',
        'created_by'
    ];
}
