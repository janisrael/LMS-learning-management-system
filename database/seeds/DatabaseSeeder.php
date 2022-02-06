<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(RolesAndPermissionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);        
        $this->call(MarketingTemplatesSeeder::class);
        $this->call(MarketingEverwebinarsSeeder::class);
        $this->call(MarketingCheckoutTableSeeder::class);
    }
}