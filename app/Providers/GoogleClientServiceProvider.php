<?php

namespace App\Providers;

use Google\Client;
use Google\Service\Drive;
use Illuminate\Support\ServiceProvider;

class GoogleClientServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     * 
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function ($app) {
            $client = new Client();
            $credentialsPath = config('services.google.credentials_path') ?: base_path(env('GOOGLE_CREDENTIALS_PATH'));

            if (!file_exists($credentialsPath)) {
                throw new \Exception("Google credentials file not found at path: " . $credentialsPath);
            }

            $client->setAuthConfig($credentialsPath);
            $client->setApplicationName(config('app.name'));
            $client->setScopes([Drive::DRIVE]);
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');
            return $client;
        });

        $this->app->singleton(Drive::class, function ($app) {
            return new Drive($app->make(Client::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
