<?php

namespace App\Util;

use App\Models\User;
use Illuminate\Support\Collection;

class ACLUtil
{
    protected $acl;

    public function __construct()
    {
        $this->acl = collect(config('acl.permissions'));
    }

    public static function acl(): Collection
    {
        return (new self)->acl;
    }

    public static function getAllAsCollection(): Collection
    {
        return collect(self::acl())->collapse();
    }

    public static function modules(): Collection
    {
        return collect(self::acl()['modules']);
    }

    public static function customPermissions(): Collection
    {
        return collect(self::acl()['custom_permissions']);
    }

    public static function getAllAsObject(): Object
    {
        return json_decode(json_encode(self::acl(), true));
    }

    public static function getByKey(string $key): ? Collection
    {
        $data = self::getAllAsCollection()->where('key', $key)->first();

        return collect($data);
    }

    public static function getAttributeByKey(string $key, string $attribute): ? String
    {
        return self::getByKey($key)[$attribute];
    }

    public static function getPermissionNameByKey(string $key): ? String
    {
        return self::getByKey($key)['name'];
    }

    public static function getBaseNameByKey(string $key): ? String
    {
        $data = self::customPermissions()->where('key', $key)->first()->name;

        return collect($data);
    }

    public static function toWildcard(string $permissions_name, $id): String
    {
        $accessible_ids = '';

        if (!empty($id)) {

            if (is_array($id)) {

                $accessible_ids = '.' . self::__formatResourceIds($id);
            } else {

                $accessible_ids = '.' . $id;
            }
        }

        return  $permissions_name . $accessible_ids;
    }

    private static function __formatResourceIds(array $array): String
    {
        return collect($array)->unique()->sort()->implode(',');
    }

    public static function groupByModule(): Object
    {
        foreach (self::acl() as $permission) {
            $all = $permission;
        }

        return $all;
    }

    public static function aclGiveRolePermissionTo()
    {
        //
    }

    public static function aclGiveUserPermissionTo()
    {
        //
    }

    public static function aclGivePermissionTo()
    {
        //
    }
}