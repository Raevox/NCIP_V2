<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CocApplication;
use App\Models\IpAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StaffController extends Controller
{
    // Dashboard
    public function index()
    {
        return view('staff.dashboard');
    }

    // Staff Profile
    public function profile()
    {
        return view('staff.profile');
    }
    
    // public function review()
    // {
    //     $underReview = CocApplication::with('applicant')
    //         ->where('coc_status', 'Under Review')
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(10);
        
    //     $approved = CocApplication::with('applicant')
    //         ->where('coc_status', 'Approved')
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(10);
        
    //     $returned = CocApplication::with('applicant')
    //         ->where('coc_status', 'Returned')
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(10);
        
    //     return view('staff.review', compact('underReview', 'approved', 'returned'));
    // }

    public function review(Request $request)
    {
        // Filters that use REAL database columns - safe to apply at query level
        $applyBaseFilters = function ($query) use ($request) {
            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('applicant', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
                });
            }

            if ($request->filled('date')) {
                $query->whereDate('created_at', $request->date);
            }

            return $query;
        };

        // Filters that live inside the step1 TEXT column - must be done in PHP
        $applyJsonFilters = function ($collection) use ($request) {
            return $collection->filter(function ($app) use ($request) {
                $step1 = json_decode($app->step1, true) ?? [];

                if ($request->filled('municipality')) {
                    if (($step1['municipality_name'] ?? null) !== $request->municipality) {
                        return false;
                    }
                }

                if ($request->filled('place_origin')) {
                    $origin = $step1['place_origin'] ?? '';
                    if (stripos($origin, $request->place_origin) === false) {
                        return false;
                    }
                }

                if ($request->filled('purpose')) {
                    $purposes = $step1['purpose'] ?? [];
                    if (!is_array($purposes) || !in_array($request->purpose, $purposes)) {
                        return false;
                    }
                }

                return true;
            })->values();
        };

        // Manual paginator since filtering happens after fetching
        $paginate = function ($collection, $pageName) use ($request) {
            $page = (int) $request->get($pageName, 1);
            $perPage = 10;
            $items = $collection->values();
            $slice = $items->slice(($page - 1) * $perPage, $perPage)->values();

            return new \Illuminate\Pagination\LengthAwarePaginator(
                $slice,
                $items->count(),
                $perPage,
                $page,
                ['path' => $request->url(), 'pageName' => $pageName, 'query' => $request->query()]
            );
        };

        $underReviewRaw = $applyBaseFilters(
            CocApplication::with('applicant')->where('coc_status', 'Under Review')
        )->orderBy('created_at', 'desc')->get();

        $approvedRaw = $applyBaseFilters(
            CocApplication::with('applicant')->where('coc_status', 'Approved')
        )->orderBy('created_at', 'desc')->get();

        $returnedRaw = $applyBaseFilters(
            CocApplication::with('applicant')->where('coc_status', 'Returned')
        )->orderBy('created_at', 'desc')->get();

        $underReview = $paginate($applyJsonFilters($underReviewRaw), 'underReview_page');
        $approved = $paginate($applyJsonFilters($approvedRaw), 'approved_page');
        $returned = $paginate($applyJsonFilters($returnedRaw), 'returned_page');

        $municipalities = CocApplication::whereNotNull('step1')
            ->pluck('step1')
            ->map(fn($json) => json_decode($json, true)['municipality_name'] ?? null)
            ->filter()
            ->unique()
            ->sort()
            ->values();

        if ($request->ajax() || $request->has('ajax')) {
            return view('staff.partials.review-tabs-content', compact('underReview', 'approved', 'returned'));
        }

        return view('staff.review', compact('underReview', 'approved', 'returned', 'municipalities'));
    }

    public function getApplicationLists(Request $request)
    {
        try {
            $underReview = CocApplication::where('coc_status', 'Under Review')
                ->with('applicant')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($app) {
                    return [
                        'id' => $app->id,
                        'applicant_name' => $app->applicant->full_name ?? 'N/A',
                        'created_at' => $app->created_at->format('M d, Y'),
                        'status' => $app->coc_status,
                        'remarks' => $app->remarks
                    ];
                });

            $approved = CocApplication::where('coc_status', 'Approved')
                ->with('applicant')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($app) {
                    return [
                        'id' => $app->id,
                        'applicant_name' => $app->applicant->full_name ?? 'N/A',
                        'created_at' => $app->created_at->format('M d, Y'),
                        'status' => $app->coc_status,
                        'remarks' => $app->remarks
                    ];
                });

            $returned = CocApplication::where('coc_status', 'Returned')
                ->with('applicant')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($app) {
                    return [
                        'id' => $app->id,
                        'applicant_name' => $app->applicant->full_name ?? 'N/A',
                        'created_at' => $app->created_at->format('M d, Y'),
                        'status' => $app->coc_status,
                        'remarks' => $app->remarks
                    ];
                });

            return response()->json([
                'success' => true,
                'underReview' => $underReview,
                'approved' => $approved,
                'returned' => $returned
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $application = CocApplication::with('applicantRegistration')->findOrFail($id);

        $step1 = json_decode($application->step1, true) ?? [];
        $step2 = json_decode($application->step2, true) ?? [];
        $step3 = json_decode($application->step3, true) ?? [];
        $step4 = json_decode($application->step4, true) ?? [];

        $ipAccount = $application->applicant ?? null;

        $documents = $application->applicantRegistration
            ? $application->applicantRegistration->document_path
            : null;

        return view('staff.show', compact(
            'application',
            'ipAccount',
            'step1',
            'step2',
            'step3',
            'step4',
            'documents'
        ));
    }

    public function approve($id)
    {
        $application = CocApplication::findOrFail($id);
        $application->status = 'Approved';
        $application->save();

        return redirect()->route('staff.review')->with('success', 'Application approved successfully.');
    }

    public function return($id, Request $request)
    {
        $application = CocApplication::findOrFail($id);
        $application->status = 'Returned';
        $application->remarks = $request->input('remarks', 'No remarks provided');
        $application->save();

        return redirect()->route('staff.review')->with('success', 'Application returned successfully.');
    }
    

    public function decision(Request $request, $id)
    {
        try {
            $application = CocApplication::findOrFail($id);

            $application->index_status = $request->input('index_status');
            $application->index_remarks = $request->input('index_remarks');
            $application->genealogy_status = $request->input('genealogy_status');
            $application->genealogy_remarks = $request->input('genealogy_remarks');
            $application->documents_status = $request->input('documents_status');
            $application->documents_remarks = $request->input('documents_remarks');
            $application->classification = $request->input('classification', []);

            $allApproved = $application->index_status === 'approved' &&
                          $application->genealogy_status === 'approved' &&
                          $application->documents_status === 'approved';

            if ($allApproved) {
                $application->status = 'Approved';
                $application->coc_status = 'Admin Approval';
                $application->approved_by = Auth::id();
                $application->approved_at = now();
                $application->save();

                $classifications = $application->classification;
                $message = '';
                
                if (is_array($classifications)) {
                    if (in_array('national', $classifications) && in_array('local', $classifications)) {
                        $message = 'Application has been successfully forwarded to Regional Admin for National and Local Purpose.';
                    } elseif (in_array('national', $classifications)) {
                        $message = 'Application has been successfully forwarded to Regional Admin for National Purpose.';
                    } elseif (in_array('local', $classifications)) {
                        $message = 'Application has been successfully forwarded to Provincial Admin for Local Purpose.';
                    } else {
                        $message = 'Application has been successfully forwarded to Admin.';
                    }
                } else {
                    $message = 'Application has been successfully forwarded to Admin.';
                }

                if ($request->ajax() || $request->has('ajax') || $request->has('json')) {
                    return response()->json([
                        'success' => true,
                        'message' => $message,
                        'type' => 'approved'
                    ]);
                }

                return redirect()->route('staff.review')->with('success', 'Application forwarded successfully.');
            } else {
                $application->status = 'Returned';
                $application->coc_status = 'Returned';
                $application->approved_by = Auth::id(); 
                $application->approved_at = now();
                $application->save();

                // Reuse the model's own returned-section logic instead of duplicating the checks
                $sectionLabels = [
                    'index'      => 'Index Form',
                    'genealogy'  => 'Genealogy Form',
                    'documents'  => 'Documents',
                ];
                $issueList = collect($application->getReturnedSections())
                    ->map(fn($section) => $sectionLabels[$section] ?? $section)
                    ->implode(', ');

                $applicant = $application->applicant;

                if ($applicant && !empty($applicant->contact)) {
                    \App\Jobs\SendSmsNotification::dispatch(
                        $applicant->contact,
                        "Hi {$applicant->first_name}, your NCIP COC application needs correction: {$issueList}. Please log in to your account to review the remarks and resubmit."
                    );
                }

                if ($request->ajax() || $request->has('ajax') || $request->has('json')) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Application has been returned to applicant for corrections.',
                        'type' => 'returned'
                    ]);
                }

                return redirect()->route('staff.review')->with('success', 'Application returned to applicant for correction.');
            }
            
        } catch (\Exception $e) {
            if ($request->ajax() || $request->has('ajax') || $request->has('json')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage(),
                    'type' => 'error'
                ]);
            }

            return redirect()->back()->with('error', 'An error occurred while processing the decision.');
        }
    }

    

    // FIXED SEARCH METHOD
    public function searchApplications(Request $request)
    {
        try {
            $searchTerm = $request->get('search', '');
            
            Log::info('Search request received', ['search_term' => $searchTerm]);
            
            // If empty search, return all applications
            if (empty(trim($searchTerm))) {
                return $this->getApplicationLists($request);
            }

            // Helper function to search applications by status
            $searchByStatus = function($status) use ($searchTerm) {
                return CocApplication::where('status', $status)
                    ->where(function($query) use ($searchTerm) {
                        // Search by applicant name
                        $query->whereHas('applicant', function($q) use ($searchTerm) {
                            $q->where('full_name', 'LIKE', "%{$searchTerm}%")
                              ->orWhere('first_name', 'LIKE', "%{$searchTerm}%")
                              ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
                              ->orWhere('middle_name', 'LIKE', "%{$searchTerm}%");
                        })
                        // Search by remarks
                        ->orWhere('remarks', 'LIKE', "%{$searchTerm}%")
                        // Search by ID
                        ->orWhere('id', 'LIKE', "%{$searchTerm}%");
                    })
                    ->with('applicant')
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(function($app) {
                        return [
                            'id' => $app->id,
                            'applicant_name' => $app->applicant->full_name ?? 'N/A',
                            'created_at' => $app->created_at->format('M d, Y'),
                            'status' => $app->status,
                            'remarks' => $app->remarks ?? ''
                        ];
                    });
            };

            // Search across all statuses
            $underReview = $searchByStatus('Under Review');
            $approved = $searchByStatus('Approved');
            $returned = $searchByStatus('Returned');

            Log::info('Search results', [
                'search_term' => $searchTerm,
                'under_review_count' => $underReview->count(),
                'approved_count' => $approved->count(),
                'returned_count' => $returned->count()
            ]);

            return response()->json([
                'success' => true,
                'underReview' => $underReview,
                'approved' => $approved,
                'returned' => $returned
            ]);
            
        } catch (\Exception $e) {
            Log::error('Search error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
