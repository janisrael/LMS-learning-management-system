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
    const TEMP_DIRECTORY = 'public';
    const PERMANENT_DIRECTORY = 'lessons/resources';
    
    protected $appends = ['attachment_absolute_path'];

    public function getResourceAttachmentAttribute()
    {
        return url(self::PERMANENT_DIRECTORY.'/storage/pdf/'.$this->course_image_url);
    }

    public static function boot()
    {
        parent::boot();
        self::created(function($model){
            if (!is_null(@$model->attributes['path']))
            {
                $oldFilePath = 'public/'.$model->attributes['path'];
                $newFilePath = 'lessons/resources/'.$model->attributes['path'];
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
                $newFilePath = 'lessons/resources/'.$model->attributes['path'];
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
        $image_url = $this->image_url ? 'storage/lessons/resources/' . $this->image_url : '/';
        return url($image_url);
    }

}
