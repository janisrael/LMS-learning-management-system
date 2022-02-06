<?php

namespace App\Models\Traits\Relationship;

trait UserGroupRelationship
{
    public function profile()
    {
        return $this->hasMany('App\Models\Profile');
    }
}
