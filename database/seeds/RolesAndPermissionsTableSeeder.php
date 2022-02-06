<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Artisan;
use App\Util\ACLUtil as ACL;

class RolesAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('cache:forget', ['key' => 'spatie.permission.cache']);

        $customPermissions = config('acl.permissions.custom_permissions');

        foreach($customPermissions as $cp){
            Permission::firstOrCreate(
                [
                    'name'          => $cp['name']
                ],
                [
                    'guard_name'    => $cp['guard_name'],
                    'key'           => $cp['key' ],
                    'module'        => $cp['module'],
                    'label'         => $cp['label'],
                    'description'   => $cp['description'],
                    'group'         => null
                ]);
             
        }

        $modules = config('acl.permissions.modules');

        foreach($modules as $m){
            Permission::firstOrCreate(
                [
                    'name'          => $m['name']
                ],
                [
                    'guard_name'    => $m['guard_name'],
                    'key'           => $m['key' ],
                    'module'        => $m['module'],
                    'label'         => $m['label'],
                    'description'   => $m['description'],
                    'group'         => $m['group']
                ]);
             
        }

        // create roles and assign created permissions
        Role::firstOrCreate(['name' => 'Super Admin'])
            ->givePermissionTo(Permission::firstOrCreate(['name' => '*.*,create,view,update,delete,restore,force_delete']));

        // create roles and assign created permissions
        Role::firstOrCreate(['name' => 'Admin'])
            ->givePermissionTo(['user_account.create', 'user_account.update', 'user_account.view']);


    }

}
