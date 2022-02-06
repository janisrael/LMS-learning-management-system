<?php

namespace App\Models\Traits\Relationship;

trait MaintenanceRelationship
{
    public function addedBy()
    {
        return $this->belongsTo('App\Models\User', 'added_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\Models\User', 'updated_by');
    }
}
