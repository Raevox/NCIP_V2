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

        // Share applicantBadge status with Admin and Staff layouts and views
        \Illuminate\Support\Facades\View::composer([
            'layouts.admin',
            'layouts.staff',
            'admin.applicants.*',
            'staff.*',
            'dashboard'
        ], function ($view) {
            if (\Illuminate\Support\Facades\Auth::check()) {
                $view->with('applicantBadge', \App\Services\ApplicantBadgeService::getBadgeStatus());
            } else {
                $view->with('applicantBadge', [
                    'main_dot'            => false,
                    'under_review_count'  => 0,
                    'has_under_review'    => false,
                    'has_unread_returned' => false,
                    'has_unread_approved' => false,
                    'has_new_applicants'  => false,
                    'returned_count'      => 0,
                    'approved_count'      => 0,
                ]);
            }
        });
    }
}
