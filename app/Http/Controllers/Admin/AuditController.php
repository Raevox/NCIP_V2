<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CocApplication;

class AuditController extends Controller
{
    public function index()
    {
        $applications = CocApplication::with(['applicant', 'approvedBy'])
            ->where('status', 'Approved')
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Changed from get() to paginate(10)
        
        return view('admin.audit.index', compact('applications'));
    }

    public function search(Request $request)
    {
        $query = $request->query('query');
        $page = $request->query('page', 1);
        
        $applications = CocApplication::with(['applicant', 'approvedBy'])
            ->where('status', 'Approved')
            ->when($query, function ($q) use ($query) {
                $q->whereHas('applicant', function ($sub) use ($query) {
                    $sub->where('first_name', 'like', "%$query%")
                        ->orWhere('last_name', 'like', "%$query%");
                })
                ->orWhere('step1', 'like', "%$query%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Changed from get() to paginate(10)

        // Format response (to JSON)
        $data = $applications->items(); // Get current page items
        
        $formattedData = collect($data)->map(function ($app, $index) use ($applications) {
            $step1 = is_array($app->step1) ? $app->step1 : json_decode($app->step1, true);
            
            return [
                'id' => $app->id,
                'index' => $index + 1,
                'applicant' => $app->applicant->name ?? 'N/A',
                'ip_group' => ucfirst($step1['ip_group'] ?? 'N/A'),
                'purpose' => !empty($step1['purpose_others'])
                    ? $step1['purpose_others']
                    : (isset($step1['purpose']) ? implode(', ', (array)$step1['purpose']) : 'N/A'),
                'approved_by' => $app->approvedBy->name ?? 'N/A',
                'approved_at' => $app->approved_at
                    ? date('M d, Y', strtotime($app->approved_at))
                    : 'N/A',
            ];
        })->toArray();

        return response()->json([
            'data' => $formattedData,
            'current_page' => $applications->currentPage(),
            'per_page' => $applications->perPage(),
            'last_page' => $applications->lastPage(),
            'total' => $applications->total(),
        ]);
    }
}
