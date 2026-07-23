<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CocApplication;
use App\Models\AdminNotification;
use App\Models\User;
$admins = User::where('role', 'admin')->where('status', 'active')->get();

foreach ($admins as $admin) {
    AdminNotification::create([
        'user_id'      => $admin->id,
        'type'         => 'new_coc',
        'title'        => 'New COC Application',
        'message'      => "New COC application submitted by {$application->applicant->first_name}.",
        'related_id'   => $application->id,
        'related_type' => 'CocApplication',
        'action_url'   => route('admin.applicants.coc', $application->id),
        'priority'     => 'normal',
        'is_read'      => false,
    ]);
}

class CocController extends Controller
{
    public function viewCoc($id)
    {
        $coc = CocApplication::with('applicant')->findOrFail($id);

        if ($coc->status !== 'Approved') {
            return redirect()
                ->back()
                ->with('error', 'This COC is not yet approved.');
        }

        return view('admin.coc.view', compact('coc'));
    }
}
