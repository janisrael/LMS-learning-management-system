<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Relationship\ProfileRelationship;

class Profile extends Model
{
    use ProfileRelationship, SoftDeletes;

    public $timestamps = false;

    /**
     * Table used by the model
     *
     * @var string
     */
    protected $table = 'profile';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'sf_id',
        'region',
        'mobile_number',
        'employee_id',
        'immediate_head',
        'job_title',
        'organization',
        'avatar',
        'user_id',
        'user_group_id',
        'address',
        'branch'
    ];

    protected $dates = ['deleted_at'];

    public function setAvatar($value){
        if(!empty($value)){
            $hash_id = hash('ripemd160', $this->id);
            $ext = explode('/', mime_content_type($value))[1];
            $path = 'public/avatar/'.$hash_id.'.'.$ext;
            $filename = 'storage/avatar/'.$hash_id.'.'.$ext;
            if (preg_match('/^data:image\/(\w+);base64,/', $value)) {
                $image = substr($value, strpos($value, ',') + 1);
                $image = base64_decode($image);
                \Storage::disk('local')->put($path, $image);
            }
            $this->avatar = $filename;
            $this->save();
        }
    }

}
