<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IpRecord;
use App\Models\CocApplication;
use App\Models\IpAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Services\NotificationService;
use App\Jobs\SendSmsNotification;

class AdminController extends Controller
{
  public function index()
{
    $totalUsers = IpAccount::count();
    $totalIpRecords = IpRecord::count();
    $totalCOC = CocApplication::where('coc_status', 'Approved')->count();
    
    // ✅ CHANGED: Count "Admin Approval" instead of "Pending"
    $totalPending = CocApplication::where('coc_status', 'Admin Approval')->count();

    // ✅ FIXED: Group applications by tribe (case-insensitive) from ip_accounts
    $monthlyApplications = CocApplication::with('applicant')
        ->whereHas('applicant')
        ->get()
        ->groupBy(function($app) {
            // Gamitin ang tribe mula sa applicant (ip_accounts) at gawing case-insensitive
            return strtolower(trim($app->applicant->tribe ?? 'Unknown'));
        })
        ->map(function($group, $tribe) {
            return [
                'tribe' => $tribe,
                'count' => $group->count()
            ];
        })
        ->sortByDesc('count'); // I-sort by count descending

    // Convert into labels + data para sa chart
    $chartLabels = $monthlyApplications->pluck('tribe')->map(function($tribe) {
        // Capitalize first letter of each word for display
        return ucwords($tribe);
    });
    $chartData = $monthlyApplications->pluck('count');

    // Get monthly application data for the past 12 months
    $monthlyData = $this->getMonthlyApplicationData();

    // Get recent applications (last 10)
    $recentApplications = CocApplication::with('applicant')
        ->whereHas('applicant')
        ->latest('created_at')
        ->limit(5)
        ->get();

    return view('dashboard', compact(
        'totalUsers',
        'totalIpRecords',
        'totalCOC',
        'totalPending',
        'chartLabels',
        'chartData',
        'monthlyData',
        'recentApplications'
    ));
}

/**
 * Get monthly application data for the past 12 months
 */
private function getMonthlyApplicationData()
{
    $labels = [];
    $data = [];

    // Get data for the past 12 months
    for ($i = 11; $i >= 0; $i--) {
        $date = Carbon::now()->subMonths($i);
        $month = $date->format('M Y'); // Example: "Jan 2025"
        $labels[] = $month;

        // Count applications created in this month
        $count = CocApplication::whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->count();

        $data[] = $count;
    }

    return [
        'labels' => $labels,
        'data' => $data,
    ];
}



   // ✅ AJAX Search Method with Month and Year Filter
public function search(Request $request)
{
    try {
        $status = $request->input('status', 'all');
        $search = $request->input('search', '');
        $month = $request->input('month', '');
        $year = $request->input('year', '');
        
        $query = CocApplication::with(['applicant' => function($q) {
            $q->select('id', 'first_name', 'last_name', 'email', 'tribe', 'contact', 'address');
        }]);

        // Status filter
        if ($status !== 'all') {
            $query->where('coc_status', $status);
        }

        // Search filter
        if (!empty($search)) {
            $query->whereHas('applicant', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Month filter
        if (!empty($month)) {
            $query->whereMonth('created_at', $month);
        }

        // Year filter  
        if (!empty($year)) {
            $query->whereYear('created_at', $year);
        }

        $applications = $query->orderByRaw("CASE 
                WHEN coc_status = 'Admin Approval' THEN 1 
                WHEN coc_status = 'Returned' THEN 2
                ELSE 3 END ASC")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Format data for AJAX response
        $formattedApplications = [];
        foreach ($applications as $coc) {
            $formattedApplications[] = [
                'id' => $coc->id,
                'purpose' => $coc->purpose,
                'coc_status' => $coc->coc_status,
                'created_at' => $coc->created_at,
                'classification' => $coc->classification,
                'applicant' => [
                    'id' => $coc->applicant->id,
                    'first_name' => $coc->applicant->first_name,
                    'last_name' => $coc->applicant->last_name,
                    'email' => $coc->applicant->email,
                    'tribe' => $coc->applicant->tribe,
                    'contact' => $coc->applicant->contact,
                    'address' => $coc->applicant->address,
                ]
            ];
        }

        return response()->json([
            'success' => true,
            'applicants' => $formattedApplications,
            'pagination' => [
                'current_page' => $applications->currentPage(),
                'last_page' => $applications->lastPage(),
                'per_page' => $applications->perPage(),
                'total' => $applications->total(),
                'from' => $applications->firstItem(),
                'to' => $applications->lastItem(),
            ],
            'total' => $applications->total()
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error performing search: ' . $e->getMessage()
        ]);
    }
}
    // ✅ View Applicant Document
    public function viewDocument($id)
    {
        $applicant = IpRecord::findOrFail($id);

        if (!$applicant->document || !Storage::disk('public')->exists($applicant->document)) {
            abort(404, 'Document not found.');
        }

        return view('admin.applicants.document', compact('applicant'));
    }

    // ✅ Approve Application (Final Issuance of COC)
    public function approveApplication(Request $request, $id)
    {
        try {
            DB::transaction(function () use ($id) {
                // 1. Hanapin ang application at account
                $application = CocApplication::findOrFail($id);
                $account = IpAccount::findOrFail($application->user_id);

                // 2. Update status ng application
                $application->status = 'Approved';
                $application->coc_status = 'Approved';
                $application->save();

                \App\Services\NotificationService::notifyApplicantApproved($application);

                // 3. Kunin ang step1 data (JSON decode)
                $step1 = $application->step1 ? json_decode($application->step1, true) : [];

                // 4. Insert or Update sa ip_records
                

                // 5. Send Email Notification
                if (!empty($account->email)) {
                    $emailMessage = "Hi {$account->first_name},\n\n" .
                                    "Your COC application has been approved.\n\n" .
                                    "Pickup Location\n" .
                                    "Burgos Avenue at Old Capitol, Cabanatuan City, Nueva Ecija\n\n" .
                                    "Instructions\n" .
                                    "Please bring the hard copy of the following:\n" .
                                    "• Certificate of IP Membership\n" .
                                    "• Two (2) identical 2x2 ID photos\n" .
                                    "• Photocopy of Birth Certificate\n" .
                                    "• Certification from the Office of the Tribal Chieftain";

                    Mail::raw($emailMessage, function ($message) use ($account) {
                        $message->to($account->email)
                                ->subject('COC Application Approved');
                    });
                }

                // 6. Send SMS Notification
                if (!empty($account->contact)) {
                    \App\Jobs\SendSmsNotification::dispatch(
                        $account->contact,
                        "Hi {$account->first_name}, your COC application has been approved by the Admin. Your Certificate of Confirmation has been issued."
                    );
                }
            });

            // Return JSON response for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Application has been approved successfully! COC issued and notifications sent to the applicant.'
                ]);
            }

            return redirect()->back()->with('success', 'Application approved, IP record created, and notifications sent.');

        } catch (\Exception $e) {
            // Handle errors for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error approving application: ' . $e->getMessage()
                ]);
            }

            return redirect()->back()->with('error', 'An error occurred while approving the application.');
        }
    }

    // ✅ Decline Application Method
    public function decline(Request $request, $id)
    {
        try {
            $applicant = IpAccount::findOrFail($id);
            $reason = $request->input('reason', 'No reason provided');

            // Decline the COC application
            if ($applicant->latestCocApplication) {
                $application = $applicant->latestCocApplication;
                $application->status = 'Declined';
                $application->coc_status = 'Declined';
                $application->remarks = $reason;
                $application->save();

                \App\Services\NotificationService::notifyApplicantDeclined($application, $reason);
            }

            // Send notification email if needed
            if (!empty($applicant->email)) {
                $emailMessage = "Hi {$applicant->first_name},\n\n" .
                               "Unfortunately, your COC application has been declined.\n\n" .
                               "Reason: {$reason}\n\n" .
                               "You may contact our office for more information.";

                Mail::raw($emailMessage, function ($message) use ($applicant) {
                    $message->to($applicant->email)
                            ->subject('COC Application Declined');
                });
            }

            // Send SMS notification
            if (!empty($applicant->contact)) {
                \App\Jobs\SendSmsNotification::dispatch(
                    $applicant->contact,
                    "Hi {$applicant->first_name}, your COC application was declined. Reason: {$reason}. You may contact our office for more information."
                );
            }

            // Return JSON response for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Application has been declined successfully. Notification sent to the applicant.'
                ]);
            }

            return redirect()->back()->with('success', 'Application declined successfully.');

        } catch (\Exception $e) {
            // Handle errors for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error declining application: ' . $e->getMessage()
                ]);
            }

            return redirect()->back()->with('error', 'An error occurred while declining the application.');
        }
    }
    // ✅ Archive Applicant (soft delete account + related applications)
public function archive($id)
{
    $account = IpAccount::findOrFail($id);

    // Soft delete related applications
    $account->applications()->delete();

    // Soft delete the account itself
    $account->delete();

    return redirect()->back()->with('success', 'Applicant archived successfully.');
}

// ✅ Restore Applicant (restore account + related applications)
public function restore($id)
{
    $account = IpAccount::withTrashed()->findOrFail($id);

    // Restore account
    $account->restore();

    // Restore related applications
    $account->applications()->withTrashed()->restore();

    return redirect()->back()->with('success', 'Applicant restored successfully.');
}
public function auditLog()
{
    $applications = \App\Models\CocApplication::with([
        'applicant', // relation to IpApplicant or User (kung saan nakalink)
        'ipRecord',
        'approvedBy'
    ])
    ->whereNotNull('approved_by') // only approved applications
    ->orderBy('updated_at', 'desc')
    ->get();

    return view('admin.audit.index', compact('applications'));
}

}
