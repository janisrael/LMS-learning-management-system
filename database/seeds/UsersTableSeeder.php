<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use \Illuminate\Support\Facades\DB;
use App\Models\Profile;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Artisan::call('cache:forget', ['key' => 'spatie.permission.cache']);

        $supAdmin = User::firstOrCreate(
            [
                'email' => 'sc_superadmin@smartchartsfx.com',
                'username' => 'superadmin'
            ],
            [
                'created_by' => User::DEFAULT_ADMIN_ID,
                'email_verified_at' => now(),
                'password' => 'SC!2020SuperAdmin'
            ]
        );

        if ($supAdmin->wasRecentlyCreated === true) {

            Profile::create([
                'name' => 'Jack Daniel',
                'user_id' => $supAdmin->id
            ]);
    
            $supAdmin->assignRole('Super Admin');
        } 

        $user = User::firstOrCreate(
            [
                'email' => 'admin@smartchartsfx.com',
                'username' => 'admin',
            ],
            [
                'created_by' => User::DEFAULT_ADMIN_ID,
                'email_verified_at' => now(),
                'password' => 'SmartCharts!2020'
            ]);

        if ($user->wasRecentlyCreated === true) {

            Profile::create([
                'name' => 'Johny Walker',
                'user_id' => $user->id,
            ]);
    
            $user->assignRole('Admin');
        } 
    }
}
