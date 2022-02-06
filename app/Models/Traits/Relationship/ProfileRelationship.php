<?php

namespace App\Models\Traits\Relationship;

trait ProfileRelationship
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function userGroup()
    {
        return $this->belongsTo('App\Models\UserGroup');
    }
}
