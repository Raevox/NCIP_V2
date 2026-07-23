<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Admin Notification page controller.
 *
 * All data-fetching and mutations are handled by the Livewire
 * NotificationCenter component (for the notifications page) and by
 * Api\NotificationController (for legacy AJAX callers).
 *
 * This controller only serves the page shell view.
 */
class NotificationController extends Controller
{
    /**
     * Display the notifications page.
     *
     * The view embeds the <livewire:notification-center /> component,
     * which handles all data fetching reactively.
     */
    public function index()
    {
        return view('admin.notifications.index');
    }
}
