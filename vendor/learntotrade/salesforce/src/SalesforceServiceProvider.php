<?php namespace learntotrade\salesforce;

use Illuminate\Support\ServiceProvider;

class SalesforceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/salesforce.php', 'salesforce');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/salesforce.php' => config_path('salesforce.php')
        ]);
    }
}
