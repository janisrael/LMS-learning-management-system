<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Chapter;
use App\Models\Author;
use App\Models\CourseDetail;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    const NAME = "course";
    protected $table = 'courses';
    public $timestamps = true;

    protected $fillable = [
        'course_id',
        'name',
        'description',
        'sort_order',
        'is_global',
        'is_featured',
        'course_image_url',
        'is_active',
        'course_percentage',
        'created_by',
        'author_id'
    ];
    // public function condition($request)
    // {
    //     if($request == 'yes') {
            
    //     } else {

    //     }
    // }
    // protected $hidden = ['chapters'];
    const TEMP_DIRECTORY = 'public';
    const PERMANENT_DIRECTORY = 'courses';
    
    protected $appends = ['authors','chapters','attachment_absolute_path','subscriptions'];

    public function getCourseAttachmentAttribute()
    {
        return url(self::PERMANENT_DIRECTORY.'/storage/'.$this->course_image_url);
    }

    public static function boot()
    {
        parent::boot();
        self::created(function($model){
            if (!is_null(@$model->attributes['path']))
            {
                $oldFilePath = 'public/'.$model->attributes['path'];
                $newFilePath = 'courses/'.$model->attributes['path'];
                if (!Storage::exists($newFilePath) && Storage::exists($oldFilePath)){
                    Storage::copy($oldFilePath, $newFilePath);
                    Storage::setVisibility($newFilePath, 'public');
                }
                // $model->attributes["path"] = 'AnnualReport_' . $model->attributes["path"];
            }
        });

        self::updating(function($model){
            if (!is_null(@$model->attributes['path']))
            {
                $oldFilePath = 'public/'.$model->attributes['path'];
                $newFilePath = 'courses/'.$model->attributes['path'];
                if (!Storage::exists($newFilePath) && Storage::exists($oldFilePath)){
                    Storage::copy($oldFilePath, $newFilePath);
                    Storage::setVisibility($newFilePath, 'public');
                }
                // $model->attributes["path"] = 'AnnualReport_' . $model->attributes["path"];
            }
        });
    }
    

    public function getAttachmentAbsolutePathAttribute()
    {
        return url('storage/'.$this->course_image_url);
    }


    public function authors()
    {
        return $this->hasOne(Author::class, 'id','author_id');
    }

    public function getAuthorsAttribute(){
        return $this->authors()->first();
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'course_id', 'id');
    }

    public function getChaptersAttribute(){
        return $this->chapters()->get();
    }

    public function subscriptions()
    {
        return $this->hasMany(CourseDetail::class);
    }

    public function getSubscriptionsAttribute(){
        return $this->subscriptions()->get();
    }


}
