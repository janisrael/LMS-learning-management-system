<?php

use Illuminate\Database\Seeder;
// use Illuminate\Database\seeds\SubscriptionProductSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            SubscriptionProductSeeder:: class,
            PermissionSeeder:: class
            // PostSeeder::class,
            // CommentSeeder::class,
        ]);
    }
}
