<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicantNotificationController extends Controller
{
    public function index(Request $request): View
    {
        $applicant = $request->user('applicant');
        $filter = $request->string('filter')->toString();
        $query = $applicant->notifications();

        if ($filter === 'unread') {
            $query->whereNull('read_at');
        } elseif ($filter !== '' && $filter !== 'all') {
            $query->where('data->type', $filter);
        }

        return view('applicant.notifications.index', [
            'notifications' => $query->latest()->paginate(12)->withQueryString(),
            'filter' => $filter ?: 'all',
            'unreadCount' => $applicant->unreadNotifications()->count(),
        ]);
    }

    public function read(Request $request, string $notification): RedirectResponse
    {
        $item = $request->user('applicant')->notifications()->findOrFail($notification);
        $item->markAsRead();

        $url = $item->data['action_url'] ?? null;
        return $url ? redirect()->to($url) : back();
    }

    public function readAll(Request $request): RedirectResponse
    {
        $request->user('applicant')->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications have been marked as read.');
    }

    public function destroy(Request $request, string $notification): RedirectResponse
    {
        $request->user('applicant')->notifications()->findOrFail($notification)->delete();
        return back()->with('success', 'Notification deleted.');
    }
}
