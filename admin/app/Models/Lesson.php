<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Faq;
use App\Models\Resource;

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
    const TEMP_DIRECTORY = 'public';
    const PERMANENT_DIRECTORY = 'lessons';


    protected $hidden = ['created_by','created_at','updated_at'];
    
    protected $appends = ['resources','faqs','faqs_status','resources_status','attachment_absolute_path'];

    public function getLessonAttachmentAttribute()
    {
        return url(self::PERMANENT_DIRECTORY.'/storage/images/'.$this->image_url);
    }


    public static function boot()
    {
        parent::boot();
        self::created(function($model){
            if (!is_null(@$model->attributes['path']))
            {
                $oldFilePath = 'public/lessons/'.$model->attributes['path'];
                $newFilePath = 'public/lessons/new/'.$model->attributes['path'];
                if (!Storage::exists($newFilePath) && Storage::exists($oldFilePath)){
                    Storage::copy($oldFilePath, $newFilePath);
                    Storage::setVisibility($newFilePath, 'public/lessons/new');
                }
            }
        });

        self::updating(function($model){
            if (!is_null(@$model->attributes['path']))
            {
                $oldFilePath = 'public/lessons/'.$model->attributes['path'];
                $newFilePath = 'public/lessons/new'.$model->attributes['path'];
                if (!Storage::exists($newFilePath) && Storage::exists($oldFilePath)){
                    Storage::copy($oldFilePath, $newFilePath);
                    Storage::setVisibility($newFilePath, 'public/lessons/new');
                }
              
            }
        });
    }
    

    public function getAttachmentAbsolutePathAttribute()
    {
        $image_url = $this->image_url ? 'storage/lessons/' . $this->image_url : '/';
        return url($image_url);
    }

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

    public function resources()
    {
        return $this->hasMany(Resource::class, 'lesson_id', 'id');
    }

    public function getResourcesAttribute(){
        return $this->resources()->get();
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'lesson_id', 'id');
    }

    public function getFaqsAttribute(){
        return $this->faqs()->get();
    }

    public function resources_status()
    {
        $collection = $this->hasMany(Resource::class, 'lesson_id', 'id')->get();
        $status = 0;
        if($collection->count() > 0) {
            
            foreach($collection as $collect) {
                if($collect->status === 0 || $collect->status === null) {
                    $status = 0;
                } else {
                    $status = 1;
                }
            }

            return $status;
        } else {
            return 0;
        }
    }

    public function getResourcesStatusAttribute(){
        return $this->resources_status();
    }

    public function faqs_status()
    {
        $collection = $this->hasMany(Faq::class, 'lesson_id', 'id')->get();
        $status = 0;
        if($collection->count() > 0) {
            
            foreach($collection as $collect) {
                if($collect->status === 0 || $collect->status === null) {
                    $status = 0;
                } else {
                    $status = 1;
                }
            }

            return $status;
        } else {
            return 0;
        }
    }

    public function getFaqsStatusAttribute(){
        return $this->faqs_status();
    }

}
