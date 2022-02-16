<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;
use App\Models\Author;
use App\Models\Lesson;
use App\Models\CourseHasSubscriptions;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    const NAME = "course";
    protected $table = 'courses';
    public $timestamps = true;

    protected $fillable = [
        'course_number',
        'name',
        'description',
        'sort_order',
        'is_global',
        'category_id',
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
    protected $hidden = ['created_by','created_at','updated_at'];
    const TEMP_DIRECTORY = 'public';
    const PERMANENT_DIRECTORY = 'courses';
    
    protected $appends = ['authors','attachment_absolute_path','subscriptions','category','lessons'];

    public function getCourseAttachmentAttribute()
    {
        return url(self::PERMANENT_DIRECTORY.'/storage/images/'.$this->course_image_url);
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
        $image_url = $this->course_image_url ? 'storage/courses/' . $this->course_image_url : '/';
        return url($image_url);
    }


    public function authors()
    {
        return $this->hasOne(Author::class, 'id','author_id');
    }

    public function getAuthorsAttribute(){
        return $this->authors()->first();
    }

    public function category()
    {
        return $this->hasOne(Categories::class, 'id', 'category_id');
    }

    public function getCategoryAttribute(){
        return $this->category()->first();
    }

    public function subscriptions()
    {
        return $this->hasMany(CourseHasSubscriptions::class);
    }

    public function getSubscriptionsAttribute(){
        return $this->subscriptions()->get();
    }


    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function getLessonsAttribute(){
        return $this->lessons()->count();
    }


}
