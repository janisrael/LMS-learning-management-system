<?php

namespace App\Models\Traits\Relationship;

trait UserRelationship
{
    public function maintenanceAdded()
    {
        return $this->hasMany('App\Models\Maintenance', 'added_by');
    }

    public function maintenanceUpdated()
    {
        return $this->hasMany('App\Models\Maintenance', 'updated_by');
    }

    public function maintenanceLog()
    {
        return $this->hasMany('App\Models\MaintenanceLog');
    }

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }
}
