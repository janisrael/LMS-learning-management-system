<?php

use Illuminate\Database\Seeder;
use App\Models\SubscriptionProducts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class SubscriptionProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubscriptionProducts::create([
            'product_id' => Str::random(7),
            'name' => 'LFX (LTT Legacy)',
            'description' => '',
            'created_by' => User::DEFAULT_ADMIN_ID
        ]);

        SubscriptionProducts::create([
            'product_id' => Str::random(7),
            'name' => 'LFX (LFX (LTT New))',
            'description' => '',
            'created_by' => User::DEFAULT_ADMIN_ID
        ]);

        SubscriptionProducts::create([
            'product_id' => Str::random(7),
            'name' => 'LFX (SC2)',
            'description' => '',
            'created_by' => User::DEFAULT_ADMIN_ID
        ]);

        SubscriptionProducts::create([
            'product_id' => Str::random(7),
            'name' => 'SIC (SC2)',
            'description' => '',
            'created_by' => User::DEFAULT_ADMIN_ID
        ]);

        SubscriptionProducts::create([
            'product_id' => Str::random(7),
            'name' => 'MTFX (SC2)',
            'description' => '',
            'created_by' => User::DEFAULT_ADMIN_ID
        ]);

        SubscriptionProducts::create([
            'product_id' => Str::random(7),
            'name' => 'LFX, SIC & MTFX (LTT Legacy)',
            'description' => '',
            'created_by' => User::DEFAULT_ADMIN_ID
        ]);

        SubscriptionProducts::create([
            'product_id' => Str::random(7),
            'name' => 'LFX & MTFX (LTT Legacy)',
            'description' => '',
            'created_by' => User::DEFAULT_ADMIN_ID
        ]);

        SubscriptionProducts::create([
            'product_id' => Str::random(7),
            'name' => 'LFX & SIC (LTT New)',
            'description' => '',
            'created_by' => User::DEFAULT_ADMIN_ID
        ]);

        SubscriptionProducts::create([
            'product_id' => Str::random(7),
            'name' => 'LFX & MTFX (LTT Legacy)',
            'description' => '',
            'created_by' => User::DEFAULT_ADMIN_ID
        ]);

        SubscriptionProducts::create([
            'product_id' => Str::random(7),
            'name' => 'Pip River',
            'description' => '',
            'created_by' => User::DEFAULT_ADMIN_ID
        ]);

        SubscriptionProducts::create([
            'product_id' => Str::random(7),
            'name' => 'LFX Elements',
            'description' => '',
            'created_by' => User::DEFAULT_ADMIN_ID
        ]);

    }
}
