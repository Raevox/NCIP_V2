<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\IpRecord;
use App\Models\IpApplicant;
use App\Models\CocApplication;
use App\Models\IpAncestor;
use App\Models\IpAccount;
use App\Models\DocumentVersion;
use Illuminate\Http\UploadedFile;
use Spatie\Browsershot\Browsershot;
use Barryvdh\DomPDF\Facade\Pdf;

class ApplicantDashboardController extends Controller
{
    // ===========================
    // Dashboard & Profile Methods
    // ===========================
    public function dashboard()
    {
        $user = Auth::guard('applicant')->user();
        $fullName = trim($user->first_name . ' ' . $user->last_name);

        $record = IpRecord::where('name', $fullName)->first();
        $application = CocApplication::where('user_id', $user->id)->latest()->first();

        return response()
            ->view('applicant.dashboard', compact('user', 'record', 'application'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

  public function profile()
{
    $user = Auth::guard('applicant')->user();
    $application = CocApplication::where('user_id', $user->id)->latest()->first();

    return view('applicant.profile', compact('user', 'application'));
}
public function cocApplication()
{
    $user = Auth::guard('applicant')->user();
    $application = CocApplication::where('user_id', $user->id)->latest()->first();

    return view('applicant.coc_application', compact('user', 'application'));
}

public function coc()
{
    $user = Auth::guard('applicant')->user();
    $application = CocApplication::where('user_id', $user->id)->latest()->first();

    // ✅ 1. Walang kahit isang application → landing page muna
    if (!$application) {
        session()->forget(['coc_step1', 'coc_step2', 'coc_step3', 'coc_step4']);
        return view('applicant.coc_application');
    }

    // ✅ 2. Fully Approved → landing page na may option na mag-reapply gamit old data
    if ($application->status === 'Approved' && $application->coc_status === 'Approved') {
        session()->forget(['coc_step1', 'coc_step2', 'coc_step3', 'coc_step4']);
        
        // I-store ang last approved application data para magamit sa prefilling
        session(['last_approved_application' => $application]);
        
        return view('applicant.coc_application', compact('application'));
    }

    // ✅ 3. Draft → ipakita ang landing page para ma-continue
    if ($application->status === 'Draft') {
        return view('applicant.coc_application', compact('application'));
    }

    // ✅ 4. Returned → diretso sa unang returned step
    if ($application->status === 'Returned') {
        $returnedSteps = $application->getReturnedSteps();
        $firstStep = min($returnedSteps);
        return redirect()->route("applicant.coc.step{$firstStep}", ['id' => $application->id])
                         ->with('info', 'Please complete the returned sections.');
    }

    // ✅ 5. Pending / Under Review / Admin Approval → block at balik sa dashboard
    // if (in_array($application->coc_status, ['Under Review', 'Admin Approval', 'Pending'])) {
    //     return redirect()->route('applicant.dashboard')
    //                      ->with('error', 'You cannot apply for a new COC while your current one is being processed.');
    // }
    if (in_array($application->coc_status, ['Under Review', 'Admin Approval', 'Pending'])) {
    return view('applicant.coc_application', compact('application'));
}

    // 🟩 Default fallback → landing page pa rin
    return view('applicant.coc_application', compact('application'));
}

public function resetDraft(CocApplication $application)
{
    $user = Auth::guard('applicant')->user();

    abort_unless(
        (int) $application->user_id === (int) $user->id && $application->status === 'Draft',
        404
    );

    $documentPaths = $application->documentVersions()->pluck('path')
        ->merge(collect(['applicant_picture', 'tribal_certificate', 'birth_certificate', 'genealogy_form'])
            ->map(fn (string $field) => $application->{$field}))
        ->filter()
        ->unique();

    Storage::disk('public')->delete($documentPaths->all());

    $application->delete();
    session()->forget([
        'coc_step1',
        'coc_step2',
        'coc_step3',
        'coc_step4',
        'last_approved_application',
    ]);

    return redirect()->route('applicant.coc.step1')
        ->with('success', 'Your draft has been cleared. You can now start a fresh application.');
}

private function getBlockedMessage($application)
{
    $statusMap = [
        'Under Review' => 'Your application is currently under review. Please wait for the result before applying again.',
        'Pending' => 'Your application is pending review. Please wait for staff assessment.',
        'Admin Approval' => 'Your application is awaiting final admin approval. Please wait for the decision.',
    ];

    $message = $statusMap[$application->status] ?? 
               'You have an active application that needs to be completed first.';

    // Include coc_status for more specific information
    if ($application->coc_status && $application->coc_status !== $application->status) {
        $currentStage = ucfirst(str_replace('_', ' ', $application->coc_status));
        $message .= " (Current stage: {$currentStage})";
    }

    // Add link for Returned applications (though this case should be handled above)
    if ($application->status === 'Returned') {
        $message .= ' <a href="' . route('applicant.coc') . '" class="alert-link">Click here to make corrections</a>.';
    }

    return $message;
}

    // ----- Step 1 -----
public function showCocFormStep1()
{
    $user = Auth::guard('applicant')->user();

    $application = CocApplication::where('user_id', $user->id)
        ->whereIn('status', ['Draft', 'Returned'])
        ->latest()
        ->first();

    $step1 = session('coc_step1', []);

    // Reload from DB if session is empty OR missing the origin fields specifically
    $missingOriginData = empty($step1['origin_province_name'] ?? null);

    if (($empty = empty($step1)) || $missingOriginData) {
        if ($application && $application->step1) {
            $dbStep1 = $this->decodeArrayValue($application->step1);
            $step1 = $empty ? $dbStep1 : array_merge($dbStep1, $step1);
            session(['coc_step1' => $step1]);
        }
    }

    $remarks = $application ? $this->decodeArrayValue($application->remarks) : [];
    $stepRemarks = $remarks['index_form'] ?? null;

    if (!$this->canAccessForms($application)) {
        return redirect()->route('applicant.dashboard')
            ->with('error', 'You cannot edit this application. Status: ' . ($application->status ?? 'N/A') . ' | Stage: ' . ($application->coc_status ?? 'N/A'));
    }

    if (!$this->canAccessStep($application, 1)) {
        return redirect()->route('applicant.dashboard')
            ->with('error', 'You can only access the returned step(s).');
    }

    return view('applicant.coc.step1', compact('user', 'step1', 'stepRemarks'));
}

public function saveCocStep1(Request $request)
{
    $data = $request->validate([
    'province' => 'required|string',
    'province_name' => 'required|string',
    'municipality' => 'required|string',
    'municipality_name' => 'required|string',
    'barangay' => 'required|string',
    'barangay_name' => 'required|string',
    'purpose' => 'required|array',
    'purpose.*' => 'string',
    'purpose_others' => 'nullable|string',

    'first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'sex' => 'required|string|max:10',
    'civil_status' => 'required|string|max:50',
    'place_origin' => 'required|string|max:255',

    'origin_province' => 'nullable|string',
    'origin_province_name' => 'nullable|string',
    'origin_municipality' => 'nullable|string',
    'origin_municipality_name' => 'nullable|string',
    'origin_barangay' => 'nullable|string',
    'origin_barangay_name' => 'nullable|string',

    'ip_group'     => 'required|string|max:255',
    'date_of_birth' => 'required|date',

    'spouse_first_name' => 'required_if:civil_status,Married|nullable|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'spouse_last_name'  => 'required_if:civil_status,Married|nullable|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
]);
    // Save data in session (optional)
    session(['coc_step1' => $data]);

    $user = Auth::guard('applicant')->user();

    // Hanapin yung latest Draft/Returned application
    $application = CocApplication::where('user_id', $user->id)
        ->whereIn('status', ['Draft', 'Returned'])
        ->orderBy('updated_at', 'desc')
        ->first();

    // Kung wala pa, gumawa ng bago
    if (!$application) {
        $application = new CocApplication();
        $application->user_id = $user->id;
        $application->status  = 'Draft';
    }

    // I-assign yung step1 data
    $application->step1 = json_encode($data);

    // Huwag baguhin ang status kung Returned (resubmission)
    if ($application->status !== 'Returned') {
        $application->status = 'Draft';
        $application->coc_status = 'Draft';
    }

    $application->save();

    return redirect()->route('applicant.coc.step2')
        ->with('success', 'Step 1 saved successfully.');
}

 
    // ----- Step 2 -----
    public function showCocFormStep2()
    {
        $user = Auth::guard('applicant')->user();
        $application = CocApplication::where('user_id', $user->id)
            ->whereIn('status', ['Draft', 'Returned'])
            ->latest()
            ->first();

        $step2 = session('coc_step2', []);

        if (empty($step2) && $application && $application->step2) {
            $step2 = $this->decodeArrayValue($application->step2);
            session(['coc_step2' => $step2]);
        }

        $step1 = session('coc_step1', []);

        if (empty($step1) && $application && $application->step1) {
            $step1 = $this->decodeArrayValue($application->step1);
            session(['coc_step1' => $step1]);
        }

        $remarks = $application ? $this->decodeArrayValue($application->remarks) : [];
        $stepRemarks = $remarks['index_form'] ?? null;

        if (!$this->canAccessStep($application, 2)) {
            return redirect()->route('applicant.dashboard')->with('error', 'You can only access the returned step(s).');
        }

        return view('applicant.coc.step2', compact('user', 'step1', 'step2', 'stepRemarks', 'application'));
    }


public function saveCocStep2(Request $request)
{
   $data = $request->validate([
    'educational_attainment' => 'required|string|max:255',
    'degree_obtained'        => 'nullable|string|max:255',

    // Parents - ✅ Updated
    'father_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'father_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'father_ipgroup'  => 'required|string|max:255',
    'father_origin'   => 'required|string|max:255',
    'mother_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'mother_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'mother_ipgroup'  => 'required|string|max:255',
    'mother_origin'   => 'required|string|max:255',

    // Paternal Grandparents - ✅ Updated
    'paternal_grandfather_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'paternal_grandfather_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'paternal_grandfather_ipgroup'    => 'required|string|max:255',
    'paternal_grandfather_origin'     => 'required|string|max:255',

    'paternal_grandmother_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'paternal_grandmother_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'paternal_grandmother_ipgroup'    => 'required|string|max:255',
    'paternal_grandmother_origin'     => 'required|string|max:255',

    // Maternal Grandparents - ✅ Updated
    'maternal_grandfather_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'maternal_grandfather_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'maternal_grandfather_ipgroup'    => 'required|string|max:255',
    'maternal_grandfather_origin'     => 'required|string|max:255',

    'maternal_grandmother_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'maternal_grandmother_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'maternal_grandmother_ipgroup'    => 'required|string|max:255',
    'maternal_grandmother_origin'     => 'required|string|max:255',

    'homestead_no'   => 'nullable|string|max:255',
    'lot_no'         => 'nullable|string|max:255',
    'issuance_date'  => 'nullable|string|max:255',
    'area'           => 'nullable|string|max:255',
    'location'       => 'nullable|string|max:255',

    'applicant_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'date_accomplishment' => 'required|date',
]);

    // Save to session
    $data['land_matter'] = $request->has('land_matter');
    session(['coc_step2' => $data]);

    $user = Auth::guard('applicant')->user();
    $application = CocApplication::where('user_id', $user->id)
        ->whereIn('status', ['Draft', 'Returned'])
        ->latest()
        ->first();

    if (!$application) {
        $application = new CocApplication();
        $application->user_id = $user->id;
        $application->status  = 'Draft';
    }

    $application->step2 = json_encode($data);
    $application->save();

    // ✅ Check kung index lang ang nireturned
    if ($application->status === 'Returned' && in_array('index', $application->getReturnedSections())) {
        $application->index_status = null; // clear remarks

        $application->save();

        // Alamin next action
        $remaining = $application->getReturnedSteps();

        if (empty($remaining)) {
            // ✅ lahat cleared → finalize
            $application->status = 'Under Review';
            $application->coc_status = 'Under Review';
            $application->submitted_at = now();
            $application->save();

            return redirect()->route('applicant.dashboard')
                ->with('success', 'Your COC application has been resubmitted and is now under staff review.');
        }

        // kung may natira pa → redirect sa susunod na returned step
        $nextStep = min($remaining);
        return redirect()->route("applicant.coc.step{$nextStep}");
    }

    // Normal flow (fresh application, hindi returned)
    return redirect()->route('applicant.coc.step3', ['id' => $application->id]);
}



    public function showCocFormStep3($id = null)
{
    $user  = Auth::guard('applicant')->user();

    $applicationQuery = CocApplication::where('user_id', $user->id)
        ->whereIn('status', ['Draft', 'Returned']);

    $application = $id
        ? $applicationQuery->whereKey($id)->firstOrFail()
        : $applicationQuery->latest('id')->first();

    $step1 = session('coc_step1', []);
    if (empty($step1) && $application && $application->step1) {
        $step1 = $this->decodeArrayValue($application->step1);
        session(['coc_step1' => $step1]);
    }

    $step2 = session('coc_step2', []);
    if (empty($step2) && $application && $application->step2) {
        $step2 = $this->decodeArrayValue($application->step2);
        session(['coc_step2' => $step2]);
    }

    $step3 = session('coc_step3', []);
    $storedStep3 = $application ? $this->decodeArrayValue($application->step3) : [];

    // A returned form must reopen with the exact data that was reviewed.
    // Session data may belong to a different/newer draft, so the DB is authoritative.
    if ($application?->status === 'Returned') {
        $step3 = $storedStep3;
        session(['coc_step3' => $step3]);
    } elseif (empty($step3) && ! empty($storedStep3)) {
        $step3 = $storedStep3;
        session(['coc_step3' => $step3]);
    }

    // Split fallback old values
    $fatherFirst = $step2['father_first_name'] ?? '';
    $fatherLast  = $step2['father_last_name'] ?? '';
    [$gfFirst, $gfLast] = $this->splitName($step2['father_grandfather_name'] ?? '');
    [$gmFirst, $gmLast] = $this->splitName($step2['father_grandmother_name'] ?? '');

    $prefill = [
        // Applicant
        'applicant_first_name' => $step3['applicant_first_name'] ?? ($step1['first_name'] ?? $user->first_name ?? ''),
        'applicant_last_name'  => $step3['applicant_last_name'] ?? ($step1['last_name'] ?? $user->last_name ?? ''),
        'applicant_origin'     => $step3['applicant_origin'] ?? ($step1['place_origin'] ?? ''),
        'applicant_ipgroup'    => $step3['applicant_ipgroup'] ?? ($step1['ip_group'] ?? ''),

        // Address
        'province'     => $step3['province'] ?? ($step1['province_name'] ?? $step1['province'] ?? ''),
        'municipality' => $step3['municipality'] ?? ($step1['municipality_name'] ?? $step1['municipality'] ?? ''),
        'barangay'     => $step3['barangay'] ?? ($step1['barangay_name'] ?? $step1['barangay'] ?? ''),

        // Father
        'father_first_name' => $step3['father_first_name'] ?? ($fatherFirst ?: ''),
        'father_last_name'  => $step3['father_last_name']  ?? ($fatherLast ?: ''),
        'father_origin'     => $step3['father_origin']     ?? ($step2['father_origin'] ?? ''),
        'father_ipgroup'    => $step3['father_ipgroup']    ?? ($step2['father_ipgroup'] ?? ''),

        // Paternal Grandfather
        'paternal_grandfather_first_name' => $step3['paternal_grandfather_first_name'] 
            ?? ($step2['paternal_grandfather_first_name'] ?? $gfFirst),
        'paternal_grandfather_last_name'  => $step3['paternal_grandfather_last_name']  
            ?? ($step2['paternal_grandfather_last_name'] ?? $gfLast),
        'paternal_grandfather_origin'     => $step3['paternal_grandfather_origin']     
            ?? ($step2['paternal_grandfather_origin'] ?? ($step2['father_grandfather_origin'] ?? '')),
        'paternal_grandfather_ipgroup'    => $step3['paternal_grandfather_ipgroup']    
            ?? ($step2['paternal_grandfather_ipgroup'] ?? ($step2['father_grandfather_ipgroup'] ?? '')),

        // Paternal Grandmother
        'paternal_grandmother_first_name' => $step3['paternal_grandmother_first_name'] 
            ?? ($step2['paternal_grandmother_first_name'] ?? $gmFirst),
        'paternal_grandmother_last_name'  => $step3['paternal_grandmother_last_name']  
            ?? ($step2['paternal_grandmother_last_name'] ?? $gmLast),
        'paternal_grandmother_origin'     => $step3['paternal_grandmother_origin']     
            ?? ($step2['paternal_grandmother_origin'] ?? ($step2['father_grandmother_origin'] ?? '')),
        'paternal_grandmother_ipgroup'    => $step3['paternal_grandmother_ipgroup']    
            ?? ($step2['paternal_grandmother_ipgroup'] ?? ($step2['father_grandmother_ipgroup'] ?? '')),
    ];

    $step3 = array_merge($prefill, $step3);

    // $application = CocApplication::where('user_id', $user->id)->latest()->first();
    $remarks = $application ? $this->decodeArrayValue($application->remarks) : [];
    $stepRemarks = $remarks['genealogy_form'] ?? null; // adjust key kung needed
    
    if (!$this->canAccessStep($application, 3)) {
    return redirect()->route('applicant.dashboard')->with('error', 'You can only access the returned step(s).');
    }

    return view('applicant.coc.step3', compact('user', 'step3', 'step1', 'stepRemarks', 'application'));
}

public function saveCocStep3(Request $request, $id = null)
{
    $step2 = session('coc_step2', []);

  $data = $request->validate([
    'applicant_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'applicant_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'applicant_origin'     => 'required|string|max:255',
    'applicant_ipgroup'    => 'required|string|max:255',
    'province'             => 'required|string|max:255',
    'municipality'         => 'required|string|max:255',
    'barangay'             => 'required|string|max:255',

    'father_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'father_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'father_origin'     => 'required|string|max:255',
    'father_ipgroup'    => 'required|string|max:255',

    'paternal_grandfather_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'paternal_grandfather_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'paternal_grandfather_origin'     => 'required|string|max:255',
    'paternal_grandfather_ipgroup'    => 'required|string|max:255',

    'paternal_grandmother_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'paternal_grandmother_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'paternal_grandmother_origin'     => 'required|string|max:255',
    'paternal_grandmother_ipgroup'    => 'required|string|max:255',

    'great_grandfather_grandfather_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'great_grandfather_grandfather_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'great_grandfather_grandfather_origin'     => 'required|string|max:255',
    'great_grandfather_grandfather_ipgroup'    => 'required|string|max:255',

    'great_grandmother_grandfather_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'great_grandmother_grandfather_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'great_grandmother_grandfather_origin'     => 'required|string|max:255',
    'great_grandmother_grandfather_ipgroup'    => 'required|string|max:255',

    'great_grandfather_grandmother_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'great_grandfather_grandmother_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'great_grandfather_grandmother_origin'     => 'required|string|max:255',
    'great_grandfather_grandmother_ipgroup'    => 'required|string|max:255',

    'great_grandmother_grandmother_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'great_grandmother_grandmother_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'great_grandmother_grandmother_origin'     => 'required|string|max:255',
    'great_grandmother_grandmother_ipgroup'    => 'required|string|max:255',
]);
    // Merge prefill from Step 2 (if any)
    $fatherFirst = $step2['father_first_name'] ?? '';
    $fatherLast  = $step2['father_last_name'] ?? '';
    [$gfFirst, $gfLast] = $this->splitName($step2['father_grandfather_name'] ?? '');
    [$gmFirst, $gmLast] = $this->splitName($step2['father_grandmother_name'] ?? '');

    $prefill = [
        'father_first_name' => $fatherFirst,
        'father_last_name' => $fatherLast,
        'paternal_grandfather_first_name' => $gfFirst,
        'paternal_grandfather_last_name' => $gfLast,
        'paternal_grandmother_first_name' => $gmFirst,
        'paternal_grandmother_last_name' => $gmLast,
    ];

    // Merge user input (overwrites prefill)
    $finalStep3 = array_merge($prefill, $data);


    session(['coc_step3' => $finalStep3]);
    $user = Auth::guard('applicant')->user();
        $applicationQuery = CocApplication::where('user_id', $user->id)
            ->whereIn('status', ['Draft', 'Returned']);

        $application = $id
            ? $applicationQuery->whereKey($id)->firstOrFail()
            : $applicationQuery->latest('id')->first();

        if (! $application) {
            return redirect()->route('applicant.coc.step1')
                ->with('error', 'The application being edited could not be found. Please continue from Step 1.');
        }

        $application->step3 = json_encode($finalStep3);
        $application->save();
    return redirect()->route('applicant.coc.step4', ['id' => $application->id])
        ->with('success', 'Step 3 saved successfully.');
}



public function showCocFormStep4($id = null)
{
    $user  = Auth::guard('applicant')->user();

    $applicationQuery = CocApplication::where('user_id', $user->id)
        ->whereIn('status', ['Draft', 'Returned']);

    $application = $id
        ? $applicationQuery->whereKey($id)->firstOrFail()
        : $applicationQuery->latest('id')->first();

    $step2 = session('coc_step2', []);
    if (empty($step2) && $application && $application->step2) {
        $step2 = $this->decodeArrayValue($application->step2);
        session(['coc_step2' => $step2]);
    }

    $step4 = session('coc_step4', []);
    if (empty($step4) && $application && $application->step4) {
        $step4 = $this->decodeArrayValue($application->step4);
        session(['coc_step4' => $step4]);
    }

    // Split mother name
    $motherFirst = $step2['mother_first_name'] ?? '';
    $motherLast  = $step2['mother_last_name'] ?? '';
    [$mgfFirst, $mgfLast] = $this->splitName($step2['mother_grandfather_name'] ?? '');
    [$mgmFirst, $mgmLast] = $this->splitName($step2['mother_grandmother_name'] ?? '');

    $prefill = [
        'mother_first_name' => $step4['mother_first_name'] ?? $motherFirst,
        'mother_last_name'  => $step4['mother_last_name']  ?? $motherLast,
        'mother_origin'     => $step4['mother_origin']     ?? ($step2['mother_origin'] ?? ''),
        'mother_ipgroup'    => $step4['mother_ipgroup']    ?? ($step2['mother_ipgroup'] ?? ''),

        // Maternal Grandfather
        'maternal_grandfather_first_name' => $step4['maternal_grandfather_first_name'] 
            ?? ($step2['maternal_grandfather_first_name'] ?? $mgfFirst),
        'maternal_grandfather_last_name'  => $step4['maternal_grandfather_last_name']  
            ?? ($step2['maternal_grandfather_last_name'] ?? $mgfLast),
        'maternal_grandfather_origin'     => $step4['maternal_grandfather_origin']     
            ?? ($step2['maternal_grandfather_origin'] ?? ($step2['mother_grandfather_origin'] ?? '')),
        'maternal_grandfather_ipgroup'    => $step4['maternal_grandfather_ipgroup']    
            ?? ($step2['maternal_grandfather_ipgroup'] ?? ($step2['mother_grandfather_ipgroup'] ?? '')),

        // Maternal Grandmother
        'maternal_grandmother_first_name' => $step4['maternal_grandmother_first_name'] 
            ?? ($step2['maternal_grandmother_first_name'] ?? $mgmFirst),
        'maternal_grandmother_last_name'  => $step4['maternal_grandmother_last_name']  
            ?? ($step2['maternal_grandmother_last_name'] ?? $mgmLast),
        'maternal_grandmother_origin'     => $step4['maternal_grandmother_origin']     
            ?? ($step2['maternal_grandmother_origin'] ?? ($step2['mother_grandmother_origin'] ?? '')),
        'maternal_grandmother_ipgroup'    => $step4['maternal_grandmother_ipgroup']    
            ?? ($step2['maternal_grandmother_ipgroup'] ?? ($step2['mother_grandmother_ipgroup'] ?? '')),
    ];

    $step4 = array_merge($prefill, $step4);

    
    // $application = CocApplication::where('user_id', $user->id)->latest()->first();
    $remarks = $application ? $this->decodeArrayValue($application->remarks) : [];
    $stepRemarks = $remarks['genealogy_form'] ?? null; // adjust key kung needed

        if (!$this->canAccessStep($application, 4)) {
        return redirect()->route('applicant.dashboard')->with('error', 'You can only access the returned step(s).');
    }

    return view('applicant.coc.step4', compact('user', 'step4', 'stepRemarks', 'application'));


}

public function saveCocStep4(Request $request, $id = null)
{
    $step2 = session('coc_step2', []);

    $data = $request->validate([
    'mother_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'mother_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'mother_origin'     => 'required|string|max:255',
    'mother_ipgroup'    => 'required|string|max:255',

    'maternal_grandfather_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'maternal_grandfather_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'maternal_grandfather_origin'     => 'required|string|max:255',
    'maternal_grandfather_ipgroup'    => 'required|string|max:255',
    
    'maternal_grandmother_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'maternal_grandmother_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'maternal_grandmother_origin'     => 'required|string|max:255',
    'maternal_grandmother_ipgroup'    => 'required|string|max:255',

    'great_grandfather_grandfather_mother_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'great_grandfather_grandfather_mother_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'great_grandfather_grandfather_mother_origin'     => 'required|string|max:255',
    'great_grandfather_grandfather_mother_ipgroup'    => 'required|string|max:255',

    'great_grandmother_grandfather_mother_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'great_grandmother_grandfather_mother_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'great_grandmother_grandfather_mother_origin'     => 'required|string|max:255',
    'great_grandmother_grandfather_mother_ipgroup'    => 'required|string|max:255',

    'great_grandfather_grandmother_mother_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'great_grandfather_grandmother_mother_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'great_grandfather_grandmother_mother_origin'     => 'required|string|max:255',
    'great_grandfather_grandmother_mother_ipgroup'    => 'required|string|max:255',

    'great_grandmother_grandmother_mother_first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'great_grandmother_grandmother_mother_last_name'  => 'required|string|max:255|regex:/^[a-zA-Z\s\-\.]+$/',
    'great_grandmother_grandmother_mother_origin'     => 'required|string|max:255',
    'great_grandmother_grandmother_mother_ipgroup'    => 'required|string|max:255',
]);
    $motherFirst = $step2['mother_first_name'] ?? '';
    $motherLast  = $step2['mother_last_name'] ?? '';
    $mgfFirst = $step2['maternal_grandfather_first_name'] ?? '';
    $mgfLast  = $step2['maternal_grandfather_last_name'] ?? '';
    $mgmFirst = $step2['maternal_grandmother_first_name'] ?? '';
    $mgmLast  = $step2['maternal_grandmother_last_name'] ?? '';

    $prefill = [
        'mother_first_name' => $motherFirst,
        'mother_last_name' => $motherLast,
        'maternal_grandfather_first_name' => $mgfFirst,
        'maternal_grandfather_last_name'  => $mgfLast,
        'maternal_grandmother_first_name' => $mgmFirst,
        'maternal_grandmother_last_name'  => $mgmLast,
    ];

    $finalStep4 = array_merge($prefill, $data);
    session(['coc_step4' => $finalStep4]);

    $user = Auth::guard('applicant')->user();
    $applicationQuery = CocApplication::where('user_id', $user->id)
        ->whereIn('status', ['Draft', 'Returned']);

    $application = $id
        ? $applicationQuery->whereKey($id)->firstOrFail()
        : $applicationQuery->latest('id')->first();

    if (! $application) {
        return redirect()->route('applicant.coc.step1')
            ->with('error', 'The application being edited could not be found. Please continue from Step 1.');
    }

    $application->step4 = json_encode($finalStep4);
    $application->save();
// ✅ Check kung genealogy lang ang nireturned
if ($application->status === 'Returned' && in_array('genealogy', $application->getReturnedSections())) {
    $application->genealogy_status = null; // clear remarks
    $application->save();

    // ✅ Kung lahat ng Returned sections ay naayos na
    if ($application->countReturnedSections() === 0) {
        $application->status = 'Under Review';
        $application->coc_status = 'Under Review';
        $application->submitted_at = now();
        $application->save();

        return redirect()->route('applicant.dashboard')
            ->with('success', 'Your COC application has been resubmitted and is now under staff review.');
    }

    // 👉 Kung may natira pang sections, diretso sa susunod na step
    $nextStep = min($application->getReturnedSteps());
    return redirect()->route("applicant.coc.step{$nextStep}")
        ->with('success', 'Step 4 saved successfully.');
}

    return redirect()->route('applicant.coc.step5')
        ->with('success', 'Step 4 saved successfully.');
}


    // ----- Step 5 -----
    public function showCocFormStep5()
    {
        $user = Auth::guard('applicant')->user();

        $step1 = session('coc_step1', []);
        $step2 = session('coc_step2', []);
        $step3 = session('coc_step3', []);
        $step4 = session('coc_step4', []);

        $allData = array_merge($step1, $step2, $step3, $step4);
        
        $application = CocApplication::where('user_id', $user->id)->latest()->first();
        $remarks = $application ? $this->decodeArrayValue($application->remarks) : [];
        $stepRemarks = $remarks['documents'] ?? null;
        $stepRemarks = $remarks['genealogy_form'] ?? null; // adjust key kung needed
        if (!$this->canAccessStep($application, 5)) {
        return redirect()->route('applicant.dashboard')->with('error', 'You can only access the returned step(s).');
        }

        return view('applicant.coc.step5', compact('user', 'allData', 'stepRemarks', 'application'));

    }
public function saveCocStep5(Request $request)
{
    $user = Auth::guard('applicant')->user();

    // Validate required files
    $request->validate([
        'applicant_picture'  => 'required|file|mimes:jpg,png,jpeg|max:5120', // 5MB
        'tribal_certificate' => 'required|file|mimes:jpg,png,jpeg,pdf|max:10240', // 10MB
        'genealogy_form'     => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
    ]);

    // Find the application
    $application = CocApplication::where('user_id', $user->id)
        ->whereIn('status', ['Draft', 'Returned'])
        ->latest()
        ->first();

    if (!$application) {
        return redirect()->route('applicant.coc.step1')
            ->with('error', 'Please start your application from Step 1.');
    }

    try {
        // Handle file uploads
        if ($request->hasFile('applicant_picture')) {
            $application->applicant_picture = $this->storeDocumentVersion(
                $application, 'applicant_picture', $request->file('applicant_picture'), 'applications/pictures', $user->id
            );
        }

        // signature field removed from step 5 — no longer stored here

        if ($request->hasFile('tribal_certificate')) {
            $application->tribal_certificate = $this->storeDocumentVersion(
                $application, 'tribal_certificate', $request->file('tribal_certificate'), 'applications/certificates', $user->id
            );
        }

        if ($request->hasFile('genealogy_form')) {
            $application->genealogy_form = $this->storeDocumentVersion(
                $application, 'genealogy_form', $request->file('genealogy_form'), 'applications/genealogy', $user->id
            );
        }

        // Handle Returned application logic
        if ($application->status === 'Returned') {
            if (in_array('documents', $application->getReturnedSections())) {
                $application->documents_status = null;
                $application->save();

                // Check if all returned sections are fixed
                if ($application->countReturnedSections() === 0) {
                    $application->status = 'Under Review';
                    $application->coc_status = 'Under Review';
                    $application->submitted_at = now();
                    $application->save();

                    return redirect()->route('applicant.dashboard')
                        ->with('success', 'Application resubmitted successfully!');
                }

                // Redirect to next returned step
                $nextStep = min($application->getReturnedSteps());
                return redirect()->route("applicant.coc.step{$nextStep}")
                    ->with('success', 'Documents uploaded successfully. Please complete other sections.');
            }
        }

        // For normal flow, go to preview
        $application->user_id = $user->id; // Ensure user_id is set
        $application->save();

        return redirect()->route('applicant.coc.preview', $application->id)
            ->with('success', 'Documents uploaded successfully! Proceed to preview.');

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error uploading files: ' . $e->getMessage())
            ->withInput();
    }
}

// ----- Preview (Step 6) -----
public function previewCoc($id)
{
    $user = Auth::guard('applicant')->user();
    
    // Debug output to help diagnose permission issues
    \Log::info('Preview access attempt', [
        'user_id' => $user->id,
        'application_id' => $id
    ]);
    
    $application = CocApplication::where('id', $id)
        ->where('user_id', $user->id)
        ->firstOrFail();

    // ✅ Only allow preview for Draft or Returned
    if (!in_array($application->status, ['Draft', 'Returned'])) {
        return redirect()->route('applicant.dashboard')
            ->with('error', 'You cannot preview this application.');
    }

    $step1 = $this->decodeArrayValue($application->step1);
    $step2 = $this->decodeArrayValue($application->step2);
    $step3 = $this->decodeArrayValue($application->step3);
    $step4 = $this->decodeArrayValue($application->step4);

    $ipAccount = IpAccount::find($application->user_id);

    return view('applicant.coc.preview', compact(
        'application',
        'step1',
        'step2',
        'step3',
        'step4',
        'ipAccount'
    ));
}
    // ----- Final Submission -----
public function submitCoc(Request $request, $id)
{
    $user = Auth::guard('applicant')->user();
    $application = CocApplication::where('id', $id)
                                 ->where('user_id', $user->id)
                                 ->firstOrFail();

    // ✅ Only allow submission for Draft or Returned
    if (!in_array($application->status, ['Draft', 'Returned'])) {
        return redirect()->route('applicant.dashboard')
            ->with('error', 'This application cannot be submitted.');
    }

    // Submit the application
    $application->status = 'Under Review';
    $application->coc_status = 'Under Review';
    $application->submitted_at = now();
    
    // Clear returned flags if resubmitting
    $application->index_status = null;
    $application->genealogy_status = null;
    $application->documents_status = null;
    
    $application->save();

    \App\Services\NotificationService::notifyApplicantSubmitted($application);

    return redirect()->route('applicant.dashboard')
        ->with('success', 'Your COC application has been submitted and is now under staff review.');
}

    // ===========================
    // Helper
    // ===========================
    private function storeDocumentVersion(
        CocApplication $application,
        string $documentType,
        UploadedFile $file,
        string $directory,
        int $applicantId
    ): string {
        $currentPath = $application->{$documentType};
        $lastRevision = (int) $application->documentVersions()
            ->where('document_type', $documentType)
            ->max('revision');

        // Register an existing pre-versioning upload before replacing it.
        if ($currentPath && ! $application->documentVersions()->where('path', $currentPath)->exists()) {
            $disk = Storage::disk('public');
            $exists = $disk->exists($currentPath);

            DocumentVersion::create([
                'coc_application_id' => $application->id,
                'document_type' => $documentType,
                'revision' => ++$lastRevision,
                'path' => $currentPath,
                'original_name' => basename($currentPath),
                'mime_type' => $exists ? $disk->mimeType($currentPath) : null,
                'file_size' => $exists ? $disk->size($currentPath) : null,
                'uploaded_by_id' => $applicantId,
                'uploaded_by_type' => 'applicant',
            ]);
        }

        $path = $file->store($directory, 'public');

        DocumentVersion::create([
            'coc_application_id' => $application->id,
            'document_type' => $documentType,
            'revision' => $lastRevision + 1,
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'uploaded_by_id' => $applicantId,
            'uploaded_by_type' => 'applicant',
        ]);

        return $path;
    }

    private function splitName($fullName)
    {
        $parts = preg_split('/\s+/', trim($fullName));
        $first = $parts[0] ?? '';
        $last = isset($parts[1]) ? implode(' ', array_slice($parts, 1)) : '';
        return [$first, $last];
    }

public function trackStatus()
{
    $user = Auth::guard('applicant')->user();

    $application = CocApplication::where('user_id', $user->id)
        ->latest()
        ->first();

    return view('applicant.track_status', compact('user', 'application'));
}

public function resubmit($step)
{
    $user = Auth::guard('applicant')->user();
    $application = $user->applications()->latest()->first();

    return view('applicant.application.resubmit', compact('application', 'step'));
}

// App/Http/Controllers/ApplicantDashboardController.php

public function resubmitToStep($step, $application)
{
    if (!in_array($step, [1, 2, 3, 4, 5])) {
        abort(404, 'Invalid step.');
    }

    $app = CocApplication::where('id', $application)
        ->where('user_id', Auth::guard('applicant')->id())
        ->where('status', 'Returned')
        ->firstOrFail();

    $returnedSteps = $app->getReturnedSteps();
    if (! in_array((int) $step, $returnedSteps, true)) {
        $step = $app->getNextReturnedStep();
    }

    if (! $step) {
        return redirect()->route('applicant.track-status')
            ->with('error', 'No section is currently marked for correction.');
    }

    return redirect()->route("applicant.coc.step{$step}", ['id' => $app->id]);
}
public function showResubmit(CocApplication $application, $step = null)
{
    $user = Auth::guard('applicant')->user();

    if ($application->user_id !== $user->id) {
        abort(403);
    }

    // Determine which step to show first (default)
    if ($application->index_status === 'returned') {
        $returnedStep = 1;
    } elseif ($application->genealogy_status === 'returned') {
        $returnedStep = 3;
    } elseif ($application->documents_status === 'returned') {
        $returnedStep = 5;
    } else {
        $returnedStep = 1;
    }

    // Kung may step param, override
    if ($step !== null) {
        $returnedStep = $step;
    }

    return redirect()->route("applicant.coc.step{$returnedStep}", [
        'id' => $application->id,
    ]);
}
 // I-DELETE ang isang duplicate - panatilihin ito:
private function canAccessStep($application, $step)
{
    // 👉 Walang record → new application
    if (!$application) return true;

    // 👉 Fully approved last application → treat as new (pwede ulit magsimula)
    if ($application->status === 'Approved' && $application->coc_status === 'Approved') {
        return true;
    }

    // ❌ Block kung nasa review/approval
    if (in_array($application->status, ['Under Review', 'Admin Approval']) ||
        in_array($application->coc_status, ['Under Review', 'Admin Approval'])) {
        return false;
    }

    // ✅ Allow kung draft o pending
    if (in_array($application->status, ['Draft', 'Pending'])) {
        return true;
    }

    // ✅ Allow specific returned steps
    if ($application->status === 'Returned') {
        if ($application->index_status === 'returned' && in_array($step, [1,2])) {
            return true;
        }
        if ($application->genealogy_status === 'returned' && in_array($step, [3,4])) {
            return true;
        }
        if ($application->documents_status === 'returned' && $step === 5) {
            return true;
        }

        return false;
    }

    // ❌ Default: block
    return false;
}
    private function canAccessForms($application)
{
    // 👉 Kapag wala pang application → allow
    if (!$application) return true;

    // 👉 Kung FULLY approved na ang last (parehong approved)
    //     ibig sabihin, tapos na at pwede gumawa ng panibago
    if ($application->status === 'Approved' && $application->coc_status === 'Approved') {
        return true;
    }

    // ❌ Block kung nasa review/approval
    if (in_array($application->status, ['Under Review', 'Admin Approval']) ||
        in_array($application->coc_status, ['Under Review', 'Admin Approval'])) {
        return false;
    }

    // ✅ Allow kung draft, returned, o pending
    if (in_array($application->status, ['Draft', 'Returned', 'Pending'])) {
        return true;
    }

    // ❌ Block kung rejected (hindi pa pinapayagang gumawa ng bago)
    if ($application->status === 'Rejected') {
        return false;
    }

    // fallback
    return false;
}
public function resubmitFinal(Request $request, $id)
{
    $user = Auth::guard('applicant')->user();

    $application = CocApplication::where('id', $id)
        ->where('user_id', $user->id)
        ->where('status', 'Returned')
        ->firstOrFail();

    // kapag naayos na lahat ng steps → iset to Under Review
    $application->status = 'Under Review';
    $application->coc_status = 'Under Review';
    $application->submitted_at = now();

    // clear per-section flags
    $application->index_status = null;
    $application->genealogy_status = null;
    $application->documents_status = null;

    $application->save();

    return redirect()->route('applicant.dashboard')
        ->with('success', 'Your COC application has been resubmitted and is now under staff review.');
}

public function history(Request $request)
{
    $query = CocApplication::where('user_id', Auth::guard('applicant')->id())
        ->orderBy('updated_at', 'desc');

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('search')) {
        $query->where('id', 'like', '%' . $request->search . '%');
    }

    $cocHistory = $query->paginate(10);

    return view('applicant.history', compact('cocHistory'));
}

public function viewDocuments(CocApplication $application)
{
    $this->ensureApplicantOwnsApplication($application);

    $documents = $this->applicationDocuments($application);

    return view('applicant.documents', compact('application', 'documents'));
}

public function viewDocument(CocApplication $application, string $document)
{
    $this->ensureApplicantOwnsApplication($application);

    $documents = $this->applicationDocuments($application);
    abort_unless(isset($documents[$document]), 404, 'Document not found.');

    $path = $documents[$document]['path'];
    abort_unless(Storage::disk('public')->exists($path), 404, 'Document not found.');

    return Storage::disk('public')->response($path, basename($path), [
        'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        'X-Content-Type-Options' => 'nosniff',
    ]);
}

private function ensureApplicantOwnsApplication(CocApplication $application): void
{
    abort_unless(
        (int) $application->user_id === (int) Auth::guard('applicant')->id(),
        404
    );
}

private function applicationDocuments(CocApplication $application): array
{
    $documentFields = [
        'applicant_picture' => ['label' => 'Applicant Photo', 'icon' => 'fa-user'],
        'tribal_certificate' => ['label' => 'Tribal Certificate', 'icon' => 'fa-file-contract'],
        'genealogy_form' => ['label' => 'Genealogy Form', 'icon' => 'fa-sitemap'],
    ];

    return collect($documentFields)
        ->filter(fn (array $details, string $field) => filled($application->{$field}))
        ->map(function (array $details, string $field) use ($application) {
            $path = $application->{$field};

            return $details + [
                'path' => $path,
                'filename' => basename($path),
                'type' => Str::upper(pathinfo($path, PATHINFO_EXTENSION)),
            ];
        })
        ->all();
}
    
// ----- Start New Application with Prefilled Data -----
public function showPurposeSelection($id)
{
    $user = Auth::guard('applicant')->user();
    $application = CocApplication::where('id', $id)
        ->where('user_id', $user->id)
        ->where('status', 'Draft')
        ->firstOrFail();

    return view('applicant.coc.purpose-selection', compact('application'));
}

public function savePurpose(Request $request)
{
    $user = Auth::guard('applicant')->user();
    $application = CocApplication::where('id', $request->application_id)
        ->where('user_id', $user->id)
        ->where('status', 'Draft')
        ->firstOrFail();

    $request->validate([
        'purpose' => 'required|array|min:1',
        'purpose.*' => 'string',
        'purpose_others' => 'required_if:purpose.*,Others'
    ]);

    // Get existing step1 data
    $step1Data = $this->decodeArrayValue($application->step1);
    
    // Ensure we have valid step1 data
    if (!is_array($step1Data)) {
        $step1Data = [];
    }

    // Update only the purpose fields and ensure it's stored as an array
    $step1Data['purpose'] = array_values($request->purpose); // Convert to array and reindex
    $step1Data['purpose_others'] = $request->purpose_others;

    // For debugging
    \Log::info('Saving purpose data:', [
        'received_purpose' => $request->purpose,
        'stored_purpose' => $step1Data['purpose'],
        'purpose_others' => $step1Data['purpose_others']
    ]);
    
    // Save back to application
    $application->step1 = json_encode($step1Data);
    $application->save();

    // Update session data
    session(['coc_step1' => $step1Data]);

    // Redirect directly to step 5 (documents)
    return redirect()->route('applicant.coc.step5')
        ->with('success', 'Purpose updated. Please upload your documents to complete your application.');
}

public function startNewApplicationWithOldData()
{
    $user = Auth::guard('applicant')->user();
    
    // Kunin ang last approved application mula sa session O direct from database
    $lastApplication = session('last_approved_application');
    
    if (!$lastApplication) {
        // Fallback: kunin directly from database
        $lastApplication = CocApplication::where('user_id', $user->id)
            ->where('status', 'Approved')
            ->where('coc_status', 'Approved')
            ->latest()
            ->first();
            
        if (!$lastApplication) {
            return redirect()->route('applicant.coc')
                             ->with('error', 'No previous approved application found. Please start a new application.');
        }
    }

    // Gumawa ng bagong application record
    $newApplication = new CocApplication();
    $newApplication->user_id = $user->id;
    $newApplication->status = 'Draft';
    $newApplication->coc_status = 'Draft';
    
    // Kopyahin ang data mula sa last application (maliban sa purpose)
    $step1Data = $this->decodeArrayValue($lastApplication->step1);
    
    // I-reset ang purpose field para palitan ng user
    $step1Data['purpose'] = [];
    $step1Data['purpose_others'] = '';
    
    $newApplication->step1 = json_encode($step1Data);
    $newApplication->step2 = $lastApplication->step2;
    $newApplication->step3 = $lastApplication->step3;
    $newApplication->step4 = $lastApplication->step4;
    
    $newApplication->save();

    // I-set ang session data para sa steps
    session([
        'coc_step1' => $step1Data,
        'coc_step2' => $this->decodeArrayValue($lastApplication->step2),
        'coc_step3' => $this->decodeArrayValue($lastApplication->step3),
        'coc_step4' => $this->decodeArrayValue($lastApplication->step4)
    ]);

    // Clear the session data
    session()->forget('last_approved_application');

    return redirect()->route('applicant.coc.purpose-selection', ['id' => $newApplication->id])
                     ->with('success', 'Previous application data loaded. Please select your purpose for this application.');
}

public function startFreshApplication()
{
    $user = Auth::guard('applicant')->user();

    $latestApplication = CocApplication::where('user_id', $user->id)
        ->latest('id')
        ->first();

    if ($latestApplication && ! (
        $latestApplication->status === 'Approved' &&
        $latestApplication->coc_status === 'Approved'
    )) {
        return redirect()->route('applicant.coc.index')
            ->with('error', 'Please complete your current application before starting a fresh one.');
    }

    session()->forget([
        'coc_step1',
        'coc_step2',
        'coc_step3',
        'coc_step4',
        'last_approved_application',
        'returned_step',
    ]);

    $application = CocApplication::create([
        'user_id' => $user->id,
        'status' => 'Draft',
        'coc_status' => 'Draft',
    ]);

    return redirect()->route('applicant.coc.step1', ['id' => $application->id])
        ->with('success', 'Fresh application started. Please complete Step 1.');
}

public function showGenealogyPrint($id = null)
{
    $user = Auth::guard('applicant')->user();

    if ($id) {
        $application = CocApplication::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();
    } else {
        $application = CocApplication::where('user_id', $user->id)
            ->whereIn('status', ['Draft', 'Returned'])
            ->latest()
            ->firstOrFail();
    }

    $step3 = $this->decodeArrayValue($application->step3);
    $step4 = $this->decodeArrayValue($application->step4);

    return view('applicant.coc.genealogy-print', compact('step3', 'step4'));
}



public function downloadGenealogyPdf($id = null)
{
    $user = Auth::guard('applicant')->user();

    if ($id) {
        $application = CocApplication::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();
    } else {
        $application = CocApplication::where('user_id', $user->id)
            ->whereIn('status', ['Draft', 'Returned'])
            ->latest()
            ->firstOrFail();
    }

    $step3 = $this->decodeArrayValue($application->step3);
    $step4 = $this->decodeArrayValue($application->step4);

    $pdf = Pdf::loadView('applicant.coc.genealogy-pdf', compact('step3', 'step4'))
        ->setPaper('legal', 'landscape');

    return $pdf->download('genealogy-form-' . $application->id . '.pdf');
}

public function autosaveStep4(Request $request)
{
    $user = Auth::guard('applicant')->user();

    $request->validate([
        'application_id' => ['required', 'integer'],
    ]);

    // Save only to the application whose Step 4 form is open. Never create a
    // replacement Draft when a returned application has already been resubmitted.
    $application = CocApplication::whereKey($request->integer('application_id'))
        ->where('user_id', $user->id)
        ->whereIn('status', ['Draft', 'Returned'])
        ->first();

    if (! $application) {
        return response()->json([
            'success' => false,
            'message' => 'This application is no longer editable.',
        ], 409);
    }

    // Lenient save - no strict validation, just capture whatever is currently filled.
    $data = $request->except(['_token', 'application_id']);

    session(['coc_step4' => $data]);

    $application->step4 = json_encode($data);
    $application->save();

    return response()->json(['success' => true]);
}

/**
 * Normalize application JSON fields that Eloquent may already have cast to arrays.
 */
private function decodeArrayValue(mixed $value): array
{
    if (is_array($value)) {
        return $value;
    }

    if (! is_string($value) || $value === '') {
        return [];
    }

    $decoded = json_decode($value, true);

    // Tolerate legacy values that were accidentally encoded twice.
    if (is_string($decoded)) {
        $decoded = json_decode($decoded, true);
    }

    return is_array($decoded) ? $decoded : [];
}

}
