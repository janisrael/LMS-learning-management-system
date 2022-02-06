<?php

namespace App\Models\Traits\Relationship;

trait MaintenanceLogRelationship
{
    public function maintenance()
    {
        return $this->belongsTo('App\Models\Maintenance');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
