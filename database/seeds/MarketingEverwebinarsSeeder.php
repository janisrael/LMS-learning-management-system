<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\MarketingEverwebinar;
use App\Models\User;

class MarketingEverwebinarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $webinar = MarketingEverwebinar::create([
            'hash' => Str::random(7),
            'gid_code' => 'SAMPLE_GID',
            'fp_promoter' => 'neil53',
            'template_id' => 1,
            'webinar_id' => 52,
            'created_by' => User::DEFAULT_ADMIN_ID,
        ]);
    }
}
