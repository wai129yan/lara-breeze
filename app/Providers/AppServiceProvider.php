<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->loadHelpers();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}

    private function loadHelpers(): void
    {
        $helperFiles = [
            app_path('Helpers/BlogHelper.php'),
        ];

        foreach ($helperFiles as $file) {
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }
}