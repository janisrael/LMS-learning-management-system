<?php

use Illuminate\Database\Seeder;
use App\Models\MarketingTemplate;
use App\Models\User;

class MarketingTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = MarketingTemplate::create([
            'name' => 'LTT Marketing UK Affiliates',
            'description' => 'Everwebinar Registration Page for UK Affiliates',
            'service_name' => 'everwebinar',
            'folder_name' => '1',
            'created_by' => User::DEFAULT_ADMIN_ID,
        ]);

        $template = MarketingTemplate::create([
            'name' => 'Marketing Journey',
            'description' => 'Checkout for Marketing Journey',
            'service_name' => 'checkout',
            'folder_name' => '1',
            'created_by' => User::DEFAULT_ADMIN_ID,
        ]);
    }
}
