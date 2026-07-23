<?php

namespace App\Http\Controllers;

use App\Models\IpApplicant;
use App\Models\IpRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicantController extends Controller
{
    // ===========================
    // Admin Side
    // ===========================
    public function index(Request $request)
    {
        $query = IpApplicant::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('ip_group', 'like', "%{$search}%")
                  ->orWhere('municipality', 'like', "%{$search}%");
            });
        }

        $applicants = $query->latest()->paginate(10);

        return view('admin.applicants.index', compact('applicants'));
    }

    public function show($id)
    {
        $applicant = IpApplicant::findOrFail($id);
        return view('admin.applicants.show', compact('applicant'));
    }

    public function approve($id)
    {
        $applicant = IpApplicant::findOrFail($id);

        $recordData = $applicant->only([
            'first_name','last_name','sex','ip_group','birth_date',
            'origin_province','origin_municipality','origin_barangay',
            'province','municipality','barangay','census_date',
            'civil_status','religion','ncip_number','occupation',
            'income','pwd','educational_level','degree',
            'image','contact'
        ]);

        $recordData['is_archived'] = false;

        IpRecord::create($recordData);

        $applicant->delete(); // soft-delete after approval

        return redirect()->route('admin.applicants.index')
            ->with('success', 'Applicant approved and moved to IP Records.');
    }

    // ===========================
    // Applicant Side / COC Forms
    // ===========================

    public function dashboard()
    {
        $user = Auth::user();
        $application = IpApplicant::where('first_name', $user->first_name)
            ->where('last_name', $user->last_name)
            ->latest()
            ->first();

        return view('applicant.dashboard', compact('user', 'application'));
    }

    // ---------------------------
    // Step 1
    // ---------------------------
    public function saveStep1(Request $request)
    {
        $data = $request->validate([
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'sex' => 'required|string|max:50',
            'civil_status' => 'required|string|max:50',
            'origin_province' => 'required|string|max:255',
            'origin_municipality' => 'required|string|max:255',
            'origin_barangay' => 'required|string|max:255',
            'spouse_first_name' => 'nullable|string|max:255',
            'spouse_last_name' => 'nullable|string|max:255',
            'purpose' => 'nullable|string|max:255',
            'purpose_others' => 'nullable|string|max:255',
            'height_waiver' => 'nullable|array',
            'contact' => 'nullable|string|max:50',
        ]);

        if (isset($data['height_waiver'])) {
            $data['height_waiver'] = json_encode($data['height_waiver']);
        }

        $applicant = IpApplicant::create($data);

        return redirect()->route('applicant.coc.step2.show', ['id' => $applicant->id])
            ->with('success', 'Step 1 saved successfully.');
    }

    // ---------------------------
    // Step 2
    // ---------------------------
    public function saveStep2(Request $request, $id)
    {
        $application = IpApplicant::findOrFail($id);

        $data = $request->validate([
            'educational_attainment' => 'nullable|string|max:255',
            'degree_obtained' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'father_ipgroup' => 'nullable|string|max:255',
            'father_origin' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'mother_ipgroup' => 'nullable|string|max:255',
            'mother_origin' => 'nullable|string|max:255',
            'land_matter' => 'nullable|boolean',
            'homestead_no' => 'nullable|string|max:255',
            'lot_no' => 'nullable|string|max:255',
            'issuance_date' => 'nullable|date',
            'area' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $data['land_matter'] = $request->has('land_matter');

        $application->update($data);

        return redirect()->route('applicant.coc.step3.show', ['id' => $application->id])
            ->with('success', 'Step 2 saved successfully.');
    }

    // ---------------------------
    // Step 3
    // ---------------------------
    public function saveStep3(Request $request, $id)
    {
        $application = IpApplicant::findOrFail($id);

        $data = $request->validate([
            'father_grandfather_name' => 'nullable|string|max:255',
            'father_grandfather_ipgroup' => 'nullable|string|max:255',
            'father_grandfather_origin' => 'nullable|string|max:255',
            'father_grandmother_name' => 'nullable|string|max:255',
            'father_grandmother_ipgroup' => 'nullable|string|max:255',
            'father_grandmother_origin' => 'nullable|string|max:255',
            'mother_grandfather_name' => 'nullable|string|max:255',
            'mother_grandfather_ipgroup' => 'nullable|string|max:255',
            'mother_grandfather_origin' => 'nullable|string|max:255',
            'mother_grandmother_name' => 'nullable|string|max:255',
            'mother_grandmother_ipgroup' => 'nullable|string|max:255',
            'mother_grandmother_origin' => 'nullable|string|max:255',
        ]);

        $application->update($data);

        return redirect()->route('applicant.coc.step4.show', ['id' => $application->id])
            ->with('success', 'Step 3 saved successfully.');
    }

    // ---------------------------
    // Step 4
    // ---------------------------
    public function saveStep4(Request $request, $id)
    {
        $application = IpApplicant::findOrFail($id);

        $data = $request->validate([
            'applicant_name' => 'nullable|string|max:255',
            'date_accomplishment' => 'nullable|date',
        ]);

        $application->update($data);

        return redirect()->route('applicant.coc.step5.show', ['id' => $application->id])
            ->with('success', 'Step 4 saved successfully.');
    }

    // ---------------------------
    // Step 5
    // ---------------------------
    public function saveStep5(Request $request, $id)
    {
        $application = IpApplicant::findOrFail($id);

        $data = $request->validate([
            'applicant_picture' => 'required|image|max:2048',
            'tribal_certificate' => 'required|image|max:2048',
        ]);

        foreach (['applicant_picture','tribal_certificate'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $data[$fileField] = $request->file($fileField)->store('coc_documents', 'public');
            }
        }

        $application->update($data);

        return redirect()->route('applicant.coc.completed', ['id' => $application->id])
            ->with('success', 'Step 5 saved successfully.');
    }
}
