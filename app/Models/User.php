<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Traits\Relationship\UserRelationship;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Models\Permission;
use App\Models\Traits\EnforceACL;
use App\Util\ACLUtil as ACL;

class User extends Authenticatable implements MustVerifyEmail
{
    use LogsActivity,
        HasRoles,
        UserRelationship,
        Notifiable,
        SoftDeletes,
        HasApiTokens,
        EnforceACL;

    const DEFAULT_ADMIN_ID = 1;

    const SUPER_ADMIN_ROLE = 'SuperAdmin';

    const ADMIN_ROLE = 'Admin';

    protected $with = [
        'profile'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'created_by',
            'email',
            'email_verified_at',
            'username',
            'password',
            'remember_token',
            'is_active',
            'last_login_at',
            'last_login_ip'
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            'password', 'remember_token',
        ];

    protected $dates = ['last_login_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['action_id'];

    public function getActionIdAttribute()
    {
        return $this->id;
    }

    /**
     *  @Set password bcrypt value
     *
     *  @void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function scopeAdmin($query)
    {
        return $query;
    }

    public function allowUpdateProfile(bool $flag = true)
    {
        $permission_name = ACL::getPermissionNameByKey('profile_update');

        if (!$flag) {

            if ($this->hasDirectPermission( $permission_name . '.' . $this->id)) {

                return $this->revokePermissionTo($permission_name . '.' . $this->id);
            }
            return $this;

        } else {

            $wildcard_permission = ACL::toWildcard($permission_name, [$this->id]);
            
            return $this->givePermissionTo(\Spatie\Permission\Models\Permission::findOrCreate($wildcard_permission)->name);
        }

    }

    public function setPermissions($permissions)
    {
        if(!empty($permissions)){
            foreach($permissions as $key => $is_allowed){
                
                $permission_name = ACL::getPermissionNameByKey($key);

                if($this->hasPermissionTo($permission_name)){    // if permission already exists
                    if(!$is_allowed){
                        $this->revokePermissionTo($permission_name);
                    }
                }else{
                    if($is_allowed){
                        $this->givePermissionTo($permission_name);
                    }
                }

            }
        }
    }
}
