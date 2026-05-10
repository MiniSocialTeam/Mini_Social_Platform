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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // UNIQUEMENT POUR LE TEST 
        if (config('app.env') === 'local') {
            try {
                $user = \App\Models\User::first();
                if ($user) {
                    auth()->login($user);
                }
            } catch (\Exception $e) {
                // Tables don't exist yet, likely during migrations
            }
        }
    }
}
