<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Relationship\MaintenanceRelationship;
use Spatie\Activitylog\Traits\LogsActivity;

class Maintenance extends Model
{
    use MaintenanceRelationship,
        LogsActivity,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                'ticket_no',
                'schedule_start',
                'schedule_end',
                'message',
                'notification_message',
                'notification_display_datetime',
                'auto_up_on_schedule_end',
                'is_active',
                'added_by',
                'updated_by',
            ];

    // protected $dates = ['schedule_start', 'schedule_end','notification_display_datetime', 'deleted_at'];

    // protected $appends = ['action_id','useraddedby','userupdatedby'];

    public function getActionIdAttribute()
    {
        return $this->id;
    }

    public function useraddedby()
    {
      return $this->hasOne(User::class,'id','added_by');
    }

    public function getUseraddedbyAttribute(){
      return $this->useraddedby()->first();
    }

    public function userupdatedby()
    {
      return $this->hasOne(User::class,'id','updated_by');
    }

    public function getUserupdatedbyAttribute(){
      return $this->userupdatedby()->first();
  }
}
