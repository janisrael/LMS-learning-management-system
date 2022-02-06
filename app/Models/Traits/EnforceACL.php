<?php

namespace App\Models\Traits;

use App\Util\ACLUtil;

trait EnforceACL
{
    public function isAuthorized(string $permission) : bool
    {
        return $this->can($permission);
    }
    
    public function hasAuthorityTo(string $permission) : bool
    {
        return $this->hasPermissionTo($permission);
    }

    public function giveAuthorityTo(string $permission) : Object
    {
        return $this->givePermissionTo($permission); 
    }

    public function revokeAuthorityTo(string $permission) : Object
    {
        return $this->revokePermissionTo($permission);
    }

}
