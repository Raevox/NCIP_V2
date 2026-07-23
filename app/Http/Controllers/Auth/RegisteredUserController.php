<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ApplicantRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\AdminNotification;
use App\Models\User;
use App\Services\NotificationService;
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
                'regex:/^09[0-9]{9}$/' // Must start with 09 followed by 9 digits
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
        
            // Save file to storage
            $documentPath = $file->storeAs('documents', time() . '.' . $extension, 'public');
        
            // OCR only for images
            if (in_array($extension, ['jpg','jpeg','png','gif','bmp','tiff'])) {
                try {
                    $documentText = (new TesseractOCR(storage_path('app/public/' . $documentPath)))->run();
                
                    // Extract Name
                    if (preg_match('/Name:\s*(.+)/i', $documentText, $matches)) {
                        $ocrName = trim($matches[1]);
                    }
                
                    // Extract Birth Date (MM/DD/YYYY)
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
    
        ApplicantRegistration::create([
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
            'status'            => 'pending',
            'document_path'     => $documentPath,
            'document_text'     => $documentText,
            'birth_date'        => $ocrBirthDate, // extracted birth date
        ]);
    $applicant = ApplicantRegistration::latest()->first();

// Kunin lahat ng admin
$admins = User::where('role', 'admin')->where('status', 'active')->get();

foreach ($admins as $admin) {
    AdminNotification::create([
        'user_id'      => $admin->id,
        'type'         => 'pending_account',
        'title'        => 'New Registration',
        'message'      => "{$applicant->first_name} {$applicant->last_name} has registered.",
        'related_id'   => $applicant->id,
        'related_type' => 'ApplicantRegistration',
        'action_url'   => route('admin.applicants.view', $applicant->id),
        'priority'     => 'high',
        'is_read'      => false,
    ]);
}
        return redirect()->route('login')
                         ->with('success', 'Your registration has been submitted and is pending admin approval.');
    }
    
}
