<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\IpAccount;
use App\Models\CocApplication;
use App\Observers\IpAccountObserver;
use App\Observers\CocApplicationObserver;

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
        \Log::info('🔧 AppServiceProvider.boot() - Registering observers');
        
        // Register model observers for notifications
        IpAccount::observe(IpAccountObserver::class);
        \Log::info('✅ IpAccountObserver registered');
        
        CocApplication::observe(CocApplicationObserver::class);
        \Log::info('✅ CocApplicationObserver registered');
        
        \Log::info('🔧 AppServiceProvider.boot() complete');
    }
}
