<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'course']);
        Permission::create(['name' => 'chapter']);
        Permission::create(['name' => 'lesson']);
        Permission::create(['name' => 'quiz']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'author']);
        $role1->givePermissionTo('course');
        $role1->givePermissionTo('lesson');
        $role1->givePermissionTo('quiz');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('course');
        $role2->givePermissionTo('chapter');
        $role2->givePermissionTo('lesson');
        $role2->givePermissionTo('quiz');


        $role3 = Role::create(['name' => 'expectator']);
        $role3->givePermissionTo('course');


        $role4 = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider


        $user = User::create([
            'name' => 'Example User1', 
            'email' => 'test1@gmail.com',
            'password' => Hash::make('password'),
            ]);
        $user->assignRole($role1);

        $user = User::create([
            'name' => 'Example User2', 
            'email' => 'test2@gmail.com',
            'password' => Hash::make('password'),
            ]);
        $user->assignRole($role2);

        $user = User::create(
            ['name' => 'Example User3',
             'email' => 'test3@gmail.com',
             'password' => Hash::make('password'),
             ]);
        $user->assignRole($role3);

        $user = User::create(
            ['name' => 'Example User4',
             'email' => 'mFWtYzXQB4@gmail.com',
             'password' => Hash::make('password'),
             ]);
        $user->assignRole($role4);
    }
}
