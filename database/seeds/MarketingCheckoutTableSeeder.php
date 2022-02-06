<?php

use App\Models\MarketingCheckout;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class MarketingCheckoutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $webinar = MarketingCheckout::create([
            'hash' => Str::random(7),
            'plan_id' => 'SAMPLE PLAN ID',
            'override_price' => 0.00,
            'fp_promoter' => 'neil53',
            'name' => 'test',
            'description' => 'test',
            'template_id' => 2,
            'created_by' => User::DEFAULT_ADMIN_ID
//            'customer_group' => ''
        ]);
    }
}
