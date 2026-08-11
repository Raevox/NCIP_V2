<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ApplicantRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
// use App\Models\AdminNotification;
// use App\Models\User;
// use App\Services\NotificationService;
// OCR
use thiagoalessio\TesseractOCR\TesseractOCR;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

        /**
         * Handle an incoming registration request.
         */
    public function store(Request $request): RedirectResponse
    {
        $messages = [
            'email.regex' => 'Please use Gmail address only (@gmail.com)',
            'contact.size' => 'Phone number must be 11 digits, your input is ' . strlen($request->contact) . ' digits',
            'contact.regex' => 'Phone number must contain only numbers',
        ];

        $request->validate([
            'first_name'       => ['required', 'string', 'max:255'],
            'last_name'        => ['required', 'string', 'max:255'],
            'email'            => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                'unique:applicant_registrations,email',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'
            ],
            'contact'          => [
                'required', 
                'string', 
                'size:11',
                'regex:/^09[0-9]{9}$/'
            ],
            'province_code'    => ['required', 'string'],
            'municipality_code'=> ['required', 'string'],
            'barangay_code'    => ['required', 'string'],
            'province_name'    => ['required', 'string'],
            'municipality_name'=> ['required', 'string'],
            'barangay_name'    => ['required', 'string'],
            'tribe'            => ['nullable', 'string', 'max:255'],
            'leader'           => ['nullable', 'string', 'max:255'],
            'password'         => ['required', 'confirmed', Rules\Password::defaults()],
            'birth_certificate'=> ['required', 'file', 'mimes:jpg,jpeg,png,gif,bmp,tiff,pdf', 'max:10240'],
        ]);

        $address = $request->province_name . ', ' . $request->municipality_name . ', ' . $request->barangay_name;

        $documentPath = null;
        $documentText = null;
        $ocrName = null;
        $ocrBirthDate = null;

        if ($request->hasFile('birth_certificate')) {
            $file = $request->file('birth_certificate');
            $extension = strtolower($file->getClientOriginalExtension());

            $documentPath = $file->storeAs('documents', time() . '.' . $extension, 'public');

            if (in_array($extension, ['jpg','jpeg','png','gif','bmp','tiff'])) {
                try {
                    $documentText = (new TesseractOCR(storage_path('app/public/' . $documentPath)))->run();

                    if (preg_match('/Name:\s*(.+)/i', $documentText, $matches)) {
                        $ocrName = trim($matches[1]);
                    }

                    if (preg_match('/Birth\s*Date:\s*([0-9]{2}\/[0-9]{2}\/[0-9]{4})/i', $documentText, $matches)) {
                        $ocrBirthDate = trim($matches[1]);
                    }
                } catch (\Exception $e) {
                    $documentText = null;
                    $ocrName = null;
                    $ocrBirthDate = null;
                }
            }
        }

        $registration = ApplicantRegistration::create([
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'name'              => $ocrName ?? $request->first_name . ' ' . $request->last_name,
            'email'             => $request->email,
            'contact'           => $request->contact,
            'province_code'     => $request->province_code,
            'province_name'     => $request->province_name,
            'municipality_code' => $request->municipality_code,
            'municipality_name' => $request->municipality_name,
            'barangay_code'     => $request->barangay_code,
            'barangay_name'     => $request->barangay_name,
            'address'           => $address,
            'tribe'             => $request->tribe,
            'leader'            => $request->leader,
            'password'          => Hash::make($request->password),
            'status'            => 'approved',
            'document_path'     => $documentPath,
            'document_text'     => $documentText,
            'birth_date'        => $ocrBirthDate,
        ]);

        // Immediately create the IpAccount too, so the applicant can log in right away
        // (this used to only happen when an admin approved via AccountApprovalController::approve())
        \App\Models\IpAccount::create([
            'first_name'        => $registration->first_name,
            'last_name'         => $registration->last_name,
            'name'              => $registration->first_name . ' ' . $registration->last_name,
            'email'             => $registration->email,
            'contact'           => $registration->contact,
            'address'           => $registration->address,
            'province_code'     => $registration->province_code,
            'province_name'     => $registration->province_name,
            'municipality_code' => $registration->municipality_code,
            'municipality_name' => $registration->municipality_name,
            'barangay_code'     => $registration->barangay_code,
            'barangay_name'     => $registration->barangay_name,
            'tribe'             => $registration->tribe,
            'leader'            => $registration->leader,
            'password'          => $registration->password,
            'status'            => 'active',
            'document_path'     => $registration->document_path,
            'document_text'     => $registration->document_text,
        ]);

        // Send welcome email
        if (!empty($registration->email)) {
            try {
                \Illuminate\Support\Facades\Mail::to($registration->email)
                    ->send(new \App\Mail\AccountApprovedMail($registration));
            } catch (\Exception $e) {
                \Log::error('Welcome email sending failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('login')
                        ->with('success', 'Registration successful! You can now log in.');
    }
        
}
