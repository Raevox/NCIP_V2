<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicantRegistration;
use App\Models\IpAccount;
use App\Models\User;
use App\Models\IpRecord;
use App\Models\CocApplication;
use App\Models\AdminNotification; // ← ADD THIS
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountApprovedMail;
use App\Services\NotificationService;

class AccountApprovalController extends Controller
{
    /**
     * List applicants with approved coc applications
     */
    public function index(Request $request)
    {
        // When admin visits the Applicants page, automatically mark all notifications as read
        if (\Illuminate\Support\Facades\Auth::check()) {
            \App\Services\ApplicantBadgeService::markAllNotificationsAsRead(\Illuminate\Support\Facades\Auth::user());
        }

        $status = $request->get('status', 'all');

        $query = CocApplication::with('applicant')
            ->whereNotIn('coc_status', ['Draft','Under Review'])
            ->whereHas('applicant');

        if ($status !== 'all') {
            $query->where('coc_status', $status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('applicant', function ($q) use ($search) {
                $q->where('first_name','like',"%{$search}%")
                  ->orWhere('last_name','like',"%{$search}%")
                  ->orWhereRaw("CONCAT(first_name,' ',last_name) LIKE ?", ["%{$search}%"])
                  ->orWhere('email','like',"%{$search}%");
            });
        }

        $applications = $query
            ->orderByRaw("CASE 
                WHEN coc_status = 'Admin Approval' THEN 1
                WHEN coc_status = 'Returned' THEN 2
                ELSE 3 END")
            ->orderBy('created_at','desc')
            ->paginate(10);

        if ($request->ajax()) {
            return view('admin.applicants.partials.applicant-table',
                compact('applications'))->render();
        }

        return view('admin.applicants.index', compact('applications','status'));
    }

    /**
     * Approve pending applicant -> move to IpAccounts
     */
    // public function approve(Request $request, $id)
    // {
    //     try {
    //         $applicant = ApplicantRegistration::findOrFail($id);

    //         $ipAccount = IpAccount::updateOrCreate(
    //             ['email' => $applicant->email],
    //             [
    //                 'first_name'        => $applicant->first_name,
    //                 'last_name'         => $applicant->last_name,
    //                 'name'              => $applicant->first_name . ' ' . $applicant->last_name,
    //                 'contact'           => $applicant->contact,
    //                 'address'           => $applicant->address,
    //                 'province_code'     => $applicant->province_code,
    //                 'province_name'     => $applicant->province_name,
    //                 'municipality_code' => $applicant->municipality_code,
    //                 'municipality_name' => $applicant->municipality_name,
    //                 'barangay_code'     => $applicant->barangay_code,
    //                 'barangay_name'     => $applicant->barangay_name,
    //                 'tribe'             => $applicant->tribe,
    //                 'leader'            => $applicant->leader,
    //                 'password'          => $applicant->password,
    //                 'status'            => 'active',
    //                 'document_path'     => $applicant->document_path ?? null,
    //                 'document_text'     => $applicant->document_text ?? null,
    //             ]
    //         );

    //         $applicant->status = 'approved';
    //         $applicant->save();

    //         // ─── NOTIFICATION FIX ─────────────────────────────────────────────
    //         // Step 1: Delete all pending_account notifications for this applicant.
    //         //         This removes it from "Pending Account" tab for ALL admins.
    //         AdminNotification::where('related_type', 'ApplicantRegistration')
    //             ->where('related_id', $applicant->id)
    //             ->where('type', 'pending_account')
    //             ->delete();

    //         // Step 2: Create ONE account_approved notification per admin.
    //         //         Guard with exists() check to prevent duplicates if approve
    //         //         is somehow called twice.
    //         $admins = User::where('role', 'admin')->where('status', 'active')->get();

    //         foreach ($admins as $admin) {
    //             $alreadyExists = AdminNotification::where('user_id', $admin->id)
    //                 ->where('type', 'account_approved')
    //                 ->where('related_type', 'IpAccount')
    //                 ->where('related_id', $ipAccount->id)
    //                 ->exists();

    //             if (!$alreadyExists) {
    //                 AdminNotification::create([
    //                     'user_id'      => $admin->id,
    //                     'type'         => 'account_approved',
    //                     'title'        => 'Account Approved',
    //                     'message'      => $applicant->first_name . ' ' . $applicant->last_name . ' has been approved and is now active.',
    //                     'related_id'   => $ipAccount->id,
    //                     'related_type' => 'IpAccount',
    //                     'action_url'   => route('admin.applicants.transaction', $ipAccount->id),
    //                     'priority'     => 'normal',
    //                     'is_read'      => false,
    //                 ]);
    //             }
    //         }
    //         // ──────────────────────────────────────────────────────────────────

    //         if (!empty($ipAccount->email)) {
    //             try {
    //                 Mail::to($ipAccount->email)->send(new AccountApprovedMail($applicant));
    //             } catch (\Exception $e) {
    //                 \Log::error('Email sending failed: ' . $e->getMessage());
    //             }
    //         }

    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'Account has been approved successfully! Welcome email sent to the applicant.'
    //             ]);
    //         }

    //         return redirect()->route('admin.applicants.pending')
    //                        ->with('success', 'Account approved, moved to IP Accounts, and email sent to applicant.');

    //     } catch (\Exception $e) {
    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Error approving account: ' . $e->getMessage()
    //             ]);
    //         }

    //         return redirect()->back()->with('error', 'An error occurred while approving the account.');
    //     }
    // }

    /**
     * Decline applicant with email notification and database removal
     */
    // public function decline(Request $request, $id)
    // {
    //     try {
    //         $applicant = ApplicantRegistration::findOrFail($id);
    //         $reason = $request->input('reason', 'No reason provided');

    //         if (!empty($applicant->email)) {
    //             try {
    //                 $emailMessage = "Hi {$applicant->first_name},\n\n" .
    //                               "Thank you for your interest in registering with NCIP Nueva Ecija.\n\n" .
    //                               "Unfortunately, your account registration has been declined for the following reason:\n\n" .
    //                               "REASON: {$reason}\n\n" .
    //                               "What to do next:\n" .
    //                               "• Please review and correct the issues mentioned above\n" .
    //                               "• You may register again once the requirements are met\n" .
    //                               "• For questions, contact our office during business hours\n\n" .
    //                               "Office Contact Information:\n" .
    //                               "Address: Burgos Avenue at Old Capitol, Cabanatuan City, Nueva Ecija\n" .
    //                               "Phone: [Your phone number]\n" .
    //                               "Email: [Your email address]\n\n" .
    //                               "Thank you for your understanding.\n\n" .
    //                               "NCIP Nueva Ecija Office";

    //                 Mail::raw($emailMessage, function ($message) use ($applicant) {
    //                     $message->to($applicant->email)
    //                             ->subject('Account Registration Declined - NCIP Nueva Ecija');
    //                 });
    //             } catch (\Exception $e) {
    //                 \Log::error('Decline email sending failed: ' . $e->getMessage());
    //             }
    //         }

    //         // ─── CLEAN UP NOTIFICATIONS ON DECLINE ────────────────────────────
    //         // Remove pending_account notifications so it also disappears
    //         // from "Pending Account" tab when declined, not just when approved.
    //         AdminNotification::where('related_type', 'ApplicantRegistration')
    //             ->where('related_id', $applicant->id)
    //             ->where('type', 'pending_account')
    //             ->delete();
    //         // ──────────────────────────────────────────────────────────────────

    //         $applicantName = $applicant->first_name . ' ' . $applicant->last_name;
    //         $applicant->delete();

    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => "Account for {$applicantName} has been declined and removed. Decline reason sent via email."
    //             ]);
    //         }

    //         return redirect()->route('admin.applicants.pending')
    //                        ->with('success', 'Account declined, removed from database, and notification email sent.');

    //     } catch (\Exception $e) {
    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Error declining account: ' . $e->getMessage()
    //             ]);
    //         }

    //         return redirect()->back()->with('error', 'An error occurred while declining the account.');
    //     }
    // }

    /**
     * List approved IpAccounts
     */
    public function approvedAccounts(Request $request)
    {
        $query = IpAccount::where('status', 'active');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('contact', 'LIKE', "%{$search}%");
            });
        }

        $approvedUsers = $query->paginate(10);

        return view('admin.applicants.accounts', compact('approvedUsers'));
    }

    /**
     * View COC application details
     */
    public function viewCoc($id)
    {
        $coc = \App\Models\CocApplication::with('applicant')->findOrFail($id);
        return view('admin.applicants.coc', compact('coc'));
    }

    /**
     * View applicant details
     */
    public function view($id)
    {
        $applicant = ApplicantRegistration::findOrFail($id);
        return view('admin.applicants.view', compact('applicant'));
    }

    /**
     * View applicant document
     */
    public function viewDocument($id)
    {
        $applicant = ApplicantRegistration::findOrFail($id);

        if (!$applicant->document_path || !file_exists(storage_path('app/public/' . $applicant->document_path))) {
            abort(404, 'Document not found.');
        }

        $extension = strtolower(pathinfo($applicant->document_path, PATHINFO_EXTENSION));

        return view('admin.applicants.view-document', compact('applicant', 'extension'));
    }

    /**
     * Archive an IpAccount
     */
    public function archive($id)
    {
        $account = IpAccount::findOrFail($id);

        CocApplication::where('user_id', $account->id)->delete();
        IpRecord::where('first_name', $account->first_name)
                ->where('last_name', $account->last_name)
                ->delete();

        $account->delete();

        return redirect()->route('admin.applicants.accounts')
                         ->with('success', 'Account and related records archived successfully.');
    }

    /**
     * Restore an archived IpAccount
     */
    public function restore($id)
    {
        $account = IpAccount::onlyTrashed()->findOrFail($id);
        $account->restore();

        CocApplication::onlyTrashed()->where('user_id', $account->id)->restore();
        IpRecord::onlyTrashed()
            ->where('first_name', $account->first_name)
            ->where('last_name', $account->last_name)
            ->restore();

        return redirect()->route('admin.archive.accounts')
                         ->with('success', 'Account and related records restored successfully.');
    }

    /**
     * Show archived accounts
     */
    public function archivedAccounts()
    {
        $staffAdminAccounts = User::onlyTrashed()
            ->whereIn('role', ['admin', 'staff'])
            ->paginate(10, ['*'], 'staffAdminPage');

        $ipAccounts = IpAccount::onlyTrashed()
            ->paginate(10, ['*'], 'ipPage');

        $records = IpRecord::onlyTrashed()->paginate(10, ['*'], 'recordsPage');

        return view('admin.archive.index', compact('staffAdminAccounts', 'ipAccounts', 'records'));
    }

    /**
     * List pending applicants
     */
    // public function pending(Request $request)
    // {
    //     $query = ApplicantRegistration::where('status', 'pending');

    //     if ($request->filled('search')) {
    //         $search = $request->search;
    //         $query->where(function ($q) use ($search) {
    //             $q->where('first_name', 'LIKE', "%{$search}%")
    //               ->orWhere('last_name', 'LIKE', "%{$search}%")
    //               ->orWhere('email', 'LIKE', "%{$search}%")
    //               ->orWhere('contact', 'LIKE', "%{$search}%");
    //         });
    //     }

    //     $pendingAccounts = $query->get();

    //     $pendingAccounts->transform(function ($account) {
    //         $expectedName  = strtolower($account->first_name . ' ' . $account->last_name);
    //         $extractedName = strtolower($account->name ?? '');
    //         $account->ocr_match = stripos($extractedName, $expectedName) !== false ? 'Match' : 'Mismatch';
    //         return $account;
    //     });

    //     return view('admin.applicants.pending_accounts', compact('pendingAccounts'));
    // }

    /**
     * Admin approval of CocApplication
     */
    public function adminApprove($id)
    {
        $application = CocApplication::findOrFail($id);

        if ($application->coc_status === 'Approved') {
            return redirect()->back()
                             ->with('info', 'This application is already approved. No action taken.');
        }

        $application->status     = 'Approved';
        $application->coc_status = 'Approved';
        $application->save();

        NotificationService::notifyCocApproved($application);

        return redirect()->back()
                         ->with('success', 'Application status updated to Approved.');
    }

    /**
     * Restore IP Record
     */
    public function restoreIpRecord($id)
    {
        $record = IpRecord::onlyTrashed()->findOrFail($id);
        $record->restore();

        return redirect()->route('admin.archive.ip_records')
                         ->with('success', 'IP Record restored successfully.');
    }

    /**
     * Restore Staff/Admin Account
     */
    public function restoreStaffAdmin($id)
    {
        $account = User::onlyTrashed()->findOrFail($id);
        $account->restore();

        return redirect()->route('admin.archive.accounts')
                         ->with('success', 'Staff/Admin account restored successfully.');
    }

    /**
     * Restore IpAccount
     */
    public function restoreIpAccount($id)
    {
        $account = IpAccount::onlyTrashed()->findOrFail($id);
        $account->restore();

        return redirect()->route('admin.archive.accounts')
                         ->with('success', 'Applicant account restored successfully.');
    }

    /**
     * View transaction history of an IpAccount
     */
    public function transaction($id)
    {
        $applicant = IpAccount::find($id);

        if (!$applicant) {
            abort(404);
        }

        $applications = CocApplication::where(function($query) use ($id, $applicant) {
            $query->where('user_id', $id)
                  ->orWhereHas('applicant', function($q) use ($applicant) {
                      $q->where('email', $applicant->email);
                  });
        })
        ->orderBy('submitted_at', 'desc')
        ->get();

        return view('admin.applicants.transaction', compact('applicant', 'applications'));
    }

    /**
     * Search COC applications (AJAX)
     */
    public function search(Request $request)
    {
        $status = $request->input('status', 'all');
        $search = $request->input('search', '');

        $query = \App\Models\CocApplication::with(['applicant' => function($q) {
            $q->select('id', 'first_name', 'last_name', 'email', 'tribe', 'contact', 'leader', 'address');
        }]);

        if ($status !== 'all') {
            $query->where('coc_status', $status);
        }

        if (!empty($search)) {
            $searchTerm = strtolower($search);

            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('applicant', function ($query) use ($searchTerm) {
                    $query->where(function($q2) use ($searchTerm) {
                        $q2->whereRaw("LOWER(CONCAT(first_name, ' ', last_name)) LIKE ?", ["%{$searchTerm}%"])
                            ->orWhereRaw('LOWER(first_name) LIKE ?', ["%{$searchTerm}%"])
                            ->orWhereRaw('LOWER(last_name) LIKE ?', ["%{$searchTerm}%"])
                            ->orWhereRaw('LOWER(email) LIKE ?', ["%{$searchTerm}%"]);
                    });
                })
                ->orWhere(function($q) use ($searchTerm) {
                    $q->whereRaw('LOWER(step1) LIKE ?', ["%{$searchTerm}%"])
                      ->orWhereRaw('LOWER(step1) LIKE ?', ["%\"province_name\":\"%{$searchTerm}%\"%"])
                      ->orWhereRaw('LOWER(step1) LIKE ?', ["%\"municipality_name\":\"%{$searchTerm}%\"%"])
                      ->orWhereRaw('LOWER(step1) LIKE ?', ["%\"barangay_name\":\"%{$searchTerm}%\"%"])
                      ->orWhereRaw('LOWER(step1) LIKE ?', ["%\"purpose\":%\"%{$searchTerm}%\"%"])
                      ->orWhereRaw('LOWER(step1) LIKE ?', ["%\"purpose_others\":\"%{$searchTerm}%\"%"]);
                });
            });
        }

        $applications = $query
            ->orderByRaw("CASE WHEN coc_status = 'Admin Approval' THEN 1
                               WHEN coc_status = 'Returned' THEN 2 ELSE 3 END")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $formatted = $applications->map(function ($app) {
            $step1 = $app->step1 ? json_decode($app->step1, true) : [];

            $address = '';
            if (!empty($step1)) {
                $addressParts = [
                    $step1['barangay_name'] ?? '',
                    $step1['municipality_name'] ?? '',
                    $step1['province_name'] ?? ''
                ];
                $address = implode(', ', array_filter($addressParts));
            }

            $purpose = '';
            if (!empty($step1['purpose'])) {
                if (is_array($step1['purpose'])) {
                    $purpose = implode(', ', array_filter($step1['purpose']));
                } else {
                    $purpose = $step1['purpose'];
                }
            }
            if (!empty($step1['purpose_others'])) {
                $purpose .= ($purpose ? ', ' : '') . $step1['purpose_others'];
            }

            // Documents list
            $documents = [];
            if (!empty($app->applicant_picture)) {
                $documents[] = [
                    'name' => 'Applicant Picture',
                    'url'  => asset('storage/' . $app->applicant_picture),
                    'icon' => 'fas fa-image'
                ];
            }
            if (!empty($app->tribal_certificate)) {
                $documents[] = [
                    'name' => 'Tribal Certificate',
                    'url'  => asset('storage/' . $app->tribal_certificate),
                    'icon' => 'fas fa-certificate'
                ];
            }
            if (!empty($app->birth_certificate)) {
                $documents[] = [
                    'name' => 'Birth Certificate',
                    'url'  => asset('storage/' . $app->birth_certificate),
                    'icon' => 'fas fa-file-medical'
                ];
            }
            if (!empty($app->genealogy_form)) {
                $documents[] = [
                    'name' => 'Genealogy Form',
                    'url'  => asset('storage/' . $app->genealogy_form),
                    'icon' => 'fas fa-sitemap'
                ];
            }
            if (!empty($app->applicant?->document_path)) {
                $documents[] = [
                    'name' => 'Registration Document',
                    'url'  => asset('storage/' . $app->applicant->document_path),
                    'icon' => 'fas fa-file-alt'
                ];
            }

            return [
                'id'           => $app->id,
                'applicant_id' => $app->applicant->id ?? null,
                'first_name'   => $app->applicant->first_name ?? '',
                'last_name'    => $app->applicant->last_name ?? '',
                'full_name'    => ($app->applicant->first_name ?? '') . ' ' . ($app->applicant->last_name ?? ''),
                'email'        => $app->applicant->email ?? '',
                'contact'      => $app->applicant->contact ?? 'N/A',
                'tribe'        => $app->applicant->tribe ?? '-',
                'leader'       => $app->applicant->leader ?? '-',
                'coc_status'   => $app->coc_status,
                'classification' => $app->classification ?? [],
                'created_at'   => $app->created_at->format('Y-m-d H:i:s'),
                'address'      => $address ?: ($app->applicant->address ?? '-'),
                'purpose'      => $purpose ?: '-',
                'documents'    => $documents,
                'coc_view_url' => $app->coc_status === 'Approved' ? route('admin.applicants.coc.view', $app->id) : null,
                'step1'        => $step1
            ];
        });

        return response()->json([
            'success'    => true,
            'applicants' => $formatted,
            'pagination' => [
                'current_page' => $applications->currentPage(),
                'last_page'    => $applications->lastPage(),
                'total'        => $applications->total(),
                'from'         => $applications->firstItem(),
                'to'           => $applications->lastItem(),
            ],
            'total' => $applications->total()
        ]);
    }
}