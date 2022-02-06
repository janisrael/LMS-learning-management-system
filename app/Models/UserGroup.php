<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Relationship\UserGroupRelationship;
use App\Models\User;

class UserGroup extends Model
{
    use UserGroupRelationship, SoftDeletes;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $dates = ['created_at','updated_at','deleted_at'];

    /**
     * Scope a query to include only the active user groups
     *
     */
    public function scopeActive()
    {
        return $this->where('is_active', 1);
    }

}
