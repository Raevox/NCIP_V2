<?php

namespace App\Http\Controllers;

use App\Models\ApplicantRegistration;
use Illuminate\Http\Request;

class ApplicantRegistrationController extends Controller
{
    /**
     * Show registration form
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle registration with document upload
     */
    public function store(Request $request)
{
    // Validate input
    $data = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|email|unique:applicant_registrations,email|unique:ip_accounts,email',
        'contact'    => 'nullable|string|max:20',
        'address'    => 'nullable|string|max:255',
        'password'   => 'required|string|min:6|confirmed',
        'document'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    // Hash password
    $hashedPassword = bcrypt($data['password']);
    $data['password'] = $hashedPassword;

    // Upload file
    if ($request->hasFile('document')) {
        $file = $request->file('document');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents', $filename, 'public');
        $data['document_path'] = $path;
    }

    // 1️⃣ Create IP Account
    \Log::info('═══════════════════════════════════════════');
    \Log::info('📝 Creating IpAccount from registration');
    \Log::info('   First Name: ' . $data['first_name']);
    \Log::info('   Last Name: ' . $data['last_name']);
    \Log::info('   Email: ' . $data['email']);
    \Log::info('═══════════════════════════════════════════');
    
    $ipAccount = \App\Models\IpAccount::create([
        'first_name' => $data['first_name'],
        'last_name'  => $data['last_name'],
        'name'       => $data['first_name'].' '.$data['last_name'],
        'email'      => $data['email'],
        'contact'    => $data['contact'] ?? null,
        'address'    => $data['address'] ?? null,
        'password'   => $hashedPassword,
        'status'     => 'pending',
        'document_path' => $data['document_path'] ?? null,
    ]);
    
    \Log::info('✅ IpAccount created with ID: ' . $ipAccount->id);

    // 2️⃣ Create Applicant Registration linked to ip_account
    $data['ip_account_id'] = $ipAccount->id;
    $registration = ApplicantRegistration::create($data);
    
    \Log::info('✅ ApplicantRegistration created with ID: ' . $registration->id);
    \Log::info('═══════════════════════════════════════════');

    return redirect()->route('login')
        ->with('success', 'Registration submitted. Please wait for approval.');
}

    public function decline($id)
{
    $application = ApplicantRegistration::find($id);

    if (!$application) {
        return redirect()->back()->with('error', 'Application not found.');
    }

    $application->status = 'Declined';
    $application->save();

    return redirect()->back()->with('success', 'Application declined successfully.');
}
    public function ipAccount()
    {
        return $this->belongsTo(IpAccount::class, 'ip_account_id', 'id');
    }
}

