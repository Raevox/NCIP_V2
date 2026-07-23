<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CocApplication;
use Illuminate\Http\Request;

class StaffApplicationController extends Controller
{
    /**
     * Get paginated applications with optional filtering and search
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'Under Review');
        $search = $request->query('search', '');
        $page = $request->query('page', 1);
        $perPage = 10;

        $query = CocApplication::with('applicant')
            ->where('coc_status', $status);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('applicant', function ($subq) use ($search) {
                    $subq->where('email', 'like', '%' . $search . '%')
                         ->orWhere('first_name', 'like', '%' . $search . '%')
                         ->orWhere('last_name', 'like', '%' . $search . '%');
                })->orWhere('id', 'like', '%' . $search . '%');
            });
        }

        $applications = $query->orderBy('created_at', 'desc')
                              ->paginate($perPage, ['*'], 'page', $page);

        return response()->json($applications);
    }

    /**
     * Get counts for each application status
     */
    public function getCounts()
    {
        return response()->json([
            'under_review' => CocApplication::where('coc_status', 'Under Review')->count(),
            'approved' => CocApplication::where('coc_status', 'Approved')->count(),
            'returned' => CocApplication::where('coc_status', 'Returned')->count(),
        ]);
    }
}
