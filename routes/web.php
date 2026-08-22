<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\IPController;
use App\Http\Controllers\IpRecordController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AccountApprovalController;
use App\Http\Controllers\StaffAccountController;
use App\Http\Controllers\ApplicantDashboardController;
use App\Http\Controllers\OCRController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\TribeController;
use App\Http\Controllers\Admin\AccomplishmentController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\ContactController;
use App\Http\Middleware\AdminOrStaffOnly;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Api\NotificationController   as ApiNotificationController;
use App\Http\Controllers\WebsiteChatbotController;


// ═══════════════════════════════════════════════════════════
//  PUBLIC ROUTES (No Authentication Required)
// ═══════════════════════════════════════════════════════════

// Landing Page
Route::get('/', [NewsController::class, 'latestNewsPreview'])->name('landingpage');

// language switcher
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'tl'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

// Public Pages
Route::get('/about-us', function () {
    $tribes = \App\Models\Tribe::where('is_active', true)->orderBy('name')->get();
    return view('admin.content.website.aboutUsMain', compact('tribes'));
})->name('about-us');

Route::get('/iccs-ips-rights', function () {
    return view('admin.content.website.ICCs_IP-Rights');
})->name('iccs-ips-rights');

Route::get('/programs-pps', function () {
    return view('admin.content.website.Program_pps');
})->name('programs.pps');

Route::get('/accomplishments', function () {
    $accomplishments = \App\Models\Accomplishment::active()
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get();
    return view('admin.content.website.accomplishments', compact('accomplishments'));
})->name('accomplishments');

Route::get('/partnership', function () {
    $governmentPartners = \App\Models\Partner::active()->government()->orderBy('sort_order')->orderBy('name')->get();
    $privatePartners    = \App\Models\Partner::active()->private()->orderBy('sort_order')->orderBy('name')->get();
    return view('admin.content.website.partnership', compact('governmentPartners', 'privatePartners'));
})->name('partnership');

Route::get('/contacts', function () {
    return view('admin.content.website.contacts');
})->name('contacts');

// Contact Form
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::post('/api/website-chat', [WebsiteChatbotController::class, 'respond'])
    ->middleware('throttle:10,1')
    ->name('website.chat');
Route::get('/contact/success', function () {
    return view('admin.content.website.contact-success');
})->name('contact.success');

// Public News Routes
Route::get('/news', [NewsController::class, 'publicIndex'])->name('news.public');
Route::get('/news/{id}', [NewsController::class, 'publicShow'])->name('news.show');


// ═══════════════════════════════════════════════════════════
//  AUTHENTICATION ROUTES
// ═══════════════════════════════════════════════════════════

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

require __DIR__.'/auth.php';

// Password Reset
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');


// ═══════════════════════════════════════════════════════════
//  UTILITY ROUTES
// ═══════════════════════════════════════════════════════════

// Route::post('/ocr/scan', [OCRController::class, 'scan'])->name('ocr.scan');
Route::post('/api/process-signature', [SignatureController::class, 'processSignature'])->name('api.process-signature');
Route::get('/api/signature-preview/{path}', [SignatureController::class, 'getPreview'])->name('api.signature-preview');
Route::post('/api/compare-signatures', [SignatureController::class, 'compareSignatures'])->name('api.compare-signatures');

// Test Email (Remove in production)
Route::get('/test-mail', function () {
    Mail::raw('This is a test email from NCIP system.', function ($message) {
        $message->to('ninoemmanueltadeo@gmail.com')->subject('Test Mail');
    });
    return 'Test email sent!';
});


// ═══════════════════════════════════════════════════════════
//  IP RECORDS ROUTES (Keep original naming: ip_records.*)
// ═══════════════════════════════════════════════════════════

Route::middleware(['auth:web', 'verified'])->prefix('admin/ip-records')->name('ip_records.')->group(function () {
    Route::get('/', [IpRecordController::class, 'index'])->name('index');
    Route::get('/create', [IpRecordController::class, 'create'])->name('create');
    Route::post('/', [IpRecordController::class, 'store'])->name('store');
    Route::get('/{id}', [IpRecordController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [IpRecordController::class, 'edit'])->name('edit');
    Route::put('/{id}', [IpRecordController::class, 'update'])->name('update');
    Route::delete('/{id}', [IpRecordController::class, 'destroy'])->name('destroy');
    Route::get('/{id}/transaction', [IpRecordController::class, 'transaction'])->name('transaction');
    Route::get('/download/export', [IpRecordController::class, 'download'])->name('download');
    Route::get('/{id}/certificate', [IpRecordController::class, 'showCertificate'])->name('certificate');
    Route::get('/{id}/certificate/pdf', [IpRecordController::class, 'printCertificate'])->name('printCertificate');
    Route::get('/{id}/form-certificate', [IpRecordController::class, 'formCertificate'])->name('formCertificate');
});


// ═══════════════════════════════════════════════════════════
//  ADMIN ROUTES (Authenticated + Admin Role)
// ═══════════════════════════════════════════════════════════

Route::middleware(['auth:web', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Audit Trail
    Route::get('/audit-trail', [AuditController::class, 'index'])->name('audit.trail');
    Route::get('/audit-trail/search', [AuditController::class, 'search'])->name('audit.trail.search');
    Route::get('/audit', [AdminController::class, 'auditLog'])->name('audit');

    // News Management
    Route::get('news', [NewsController::class, 'index'])->name('news.index');
    Route::get('news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('news', [NewsController::class, 'store'])->name('news.store');
    Route::get('news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('news/{id}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');

    // Applicants Management
    Route::prefix('applicants')->name('applicants.')->group(function () {
        Route::get('/', [AccountApprovalController::class, 'index'])->name('index');
        // Route::get('/pending', [AccountApprovalController::class, 'pending'])->name('pending');
        Route::get('/accounts', [AccountApprovalController::class, 'approvedAccounts'])->name('accounts');
        Route::post('/accounts/{id}/archive', [AccountApprovalController::class, 'archive'])->name('accounts.archive');
        Route::get('/coc/{id}/view', [AccountApprovalController::class, 'viewCoc'])->whereNumber('id')->name('coc.view');
        Route::post('/search', [AccountApprovalController::class, 'search'])->name('search');
        Route::post('/{application}/coc-approve', [AdminController::class, 'approveApplication'])->name('coc-approve');
        Route::get('/{id}/transaction', [AccountApprovalController::class, 'transaction'])->whereNumber('id')->name('transaction');
        // Route::post('/{id}/approve', [AccountApprovalController::class, 'approve'])->whereNumber('id')->name('approve');
        // Route::post('/{id}/decline', [AccountApprovalController::class, 'decline'])->whereNumber('id')->name('decline');
        Route::get('/{id}/view', [AccountApprovalController::class, 'view'])->whereNumber('id')->name('view');
        Route::get('/{id}/document', [AccountApprovalController::class, 'viewDocument'])->whereNumber('id')->name('document');
    });

    // COC Application Approval
    Route::put('/applications/{id}/approve', [AdminController::class, 'approveApplication'])->name('applications.approve');

    // Accounts Management
    Route::prefix('accounts')->name('accounts.')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::get('/create', [AccountController::class, 'create'])->name('create');
        Route::post('/', [AccountController::class, 'store'])->name('store');
        Route::get('/{account}', [AccountController::class, 'show'])->name('show');
        Route::get('/{account}/edit', [AccountController::class, 'edit'])->name('edit');
        Route::put('/{account}', [AccountController::class, 'update'])->name('update');
        Route::delete('/{account}', [AccountController::class, 'destroy'])->name('destroy');
    });

    // Archive Management
    Route::prefix('archive')->name('archive.')->group(function () {
        Route::get('/accounts', [AccountController::class, 'archive'])->name('accounts');
        Route::post('/accounts/{type}/{id}/restore', [AccountController::class, 'restore'])->name('accounts.restore');
        Route::get('/ip-records', [IpRecordController::class, 'archivedRecords'])->name('ip_records');
        Route::post('/ip-records/{id}/restore', [IpRecordController::class, 'restore'])->name('ip_records.restore');
        Route::get('/ip-records/{id}/archive', [IpRecordController::class, 'archive'])->name('ip_records.archive');
    });

    // Tribe Management
    Route::resource('tribes', TribeController::class);

    // Accomplishment Management
    Route::resource('accomplishments', AccomplishmentController::class);

    // Partner Management
    Route::resource('partners', PartnerController::class);

    // ── Notifications page (Livewire shell) ─────────────────────────────────
    Route::get('/notifications', [AdminNotificationController::class, 'index'])
        ->middleware(AdminOrStaffOnly::class)
        ->name('notifications.index');

});


// ═══════════════════════════════════════════════════════════
//  API ROUTES FOR NOTIFICATIONS (AJAX / Livewire actions)
//  Uses Api\NotificationController — single source of truth.
//  Placed on the `web` middleware stack so session auth + CSRF work.
// ═══════════════════════════════════════════════════════════

Route::middleware(['auth:web', 'verified'])
    ->prefix('api/admin/notifications')
    ->name('api.admin.notifications.')
    ->group(function () {

        Route::get('/',                      [ApiNotificationController::class, 'getNotifications'])->name('index');
        Route::get('/unread-count',          [ApiNotificationController::class, 'getUnreadCount'])->name('unread-count');
        Route::get('/badge-status',          [ApiNotificationController::class, 'getApplicantBadgeStatus'])->name('badge-status');
        Route::post('/mark-returned-viewed', [ApiNotificationController::class, 'markReturnedAsViewed'])->name('mark-returned-viewed');
        Route::post('/mark-approved-viewed', [ApiNotificationController::class, 'markApprovedAsViewed'])->name('mark-approved-viewed');
        Route::post('/mark-all-read',        [ApiNotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::post('/{id}/read',            [ApiNotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/{id}/approve',         [ApiNotificationController::class, 'approveAccount'])->name('approve');
        Route::delete('/{id}',               [ApiNotificationController::class, 'destroy'])->name('destroy');
        Route::get('/admin/notifications',   [AdminNotificationController::class, 'index'])
            ->middleware(AdminOrStaffOnly::class)
            ->name('admin.notifications.index');
    });


// ═══════════════════════════════════════════════════════════
//  STAFF ROUTES (Authenticated + Staff Role)
// ═══════════════════════════════════════════════════════════

Route::middleware(['auth:web', 'verified'])->prefix('staff')->name('staff.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [StaffController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [StaffController::class, 'profile'])->name('profile');

    // Review Applications
    Route::get('/review', [StaffController::class, 'review'])->name('review');
    Route::get('/review/{id}', [StaffController::class, 'show'])->name('review.show');
    Route::post('/review/{id}/approve', [StaffController::class, 'approve'])->name('review.approve');
    Route::post('/review/{id}/return', [StaffController::class, 'return'])->name('review.return');
    Route::put('/review/{id}/decision', [StaffController::class, 'decision'])->name('review.decision');

    // Application Lists & Search
    Route::get('/applications/lists', [StaffController::class, 'getApplicationLists'])->name('applications.get-lists');
    Route::get('/applications/search', [StaffController::class, 'searchApplications'])->name('applications.search');

    // Staff Accounts Management
    Route::prefix('accounts')->name('accounts.')->group(function () {
        Route::get('/', [StaffAccountController::class, 'index'])->name('index');
        Route::get('/create', [StaffAccountController::class, 'create'])->name('create');
        Route::post('/', [StaffAccountController::class, 'store'])->name('store');
        Route::get('/{account}', [StaffAccountController::class, 'show'])->name('show');
    });
});


// ═══════════════════════════════════════════════════════════
//  APPLICANT ROUTES (Authenticated + Applicant Guard)
// ═══════════════════════════════════════════════════════════

Route::middleware(['auth:applicant'])->prefix('applicant')->name('applicant.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [ApplicantDashboardController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [ApplicantDashboardController::class, 'profile'])->name('profile');

    // History
    Route::get('/history', [ApplicantDashboardController::class, 'history'])->name('history');
    Route::get('/history/{application}/documents', [ApplicantDashboardController::class, 'viewDocuments'])
        ->whereNumber('application')
        ->name('history.documents');
    Route::get('/history/{application}/documents/{document}', [ApplicantDashboardController::class, 'viewDocument'])
        ->whereNumber('application')
        ->whereIn('document', ['applicant_picture', 'tribal_certificate', 'genealogy_form'])
        ->name('history.documents.view');

    // Track Status
    Route::get('/track-status', [ApplicantDashboardController::class, 'trackStatus'])->name('track-status');

    // COC Purpose Selection
    Route::get('/purpose-selection/{id}', [ApplicantDashboardController::class, 'showPurposeSelection'])->name('coc.purpose-selection');
    Route::post('/save-purpose', [ApplicantDashboardController::class, 'savePurpose'])->name('coc.save-purpose');

    // COC Application Multi-step Form
    Route::prefix('coc')->name('coc.')->group(function () {
        Route::get('/', [ApplicantDashboardController::class, 'coc'])->name('index');
        Route::get('/application', [ApplicantDashboardController::class, 'coc'])->name('application');
        Route::delete('/draft/{application}', [ApplicantDashboardController::class, 'resetDraft'])
            ->whereNumber('application')
            ->name('draft.reset');
        Route::get('/start-with-old-data', [ApplicantDashboardController::class, 'startNewApplicationWithOldData'])->name('start-new-with-old-data');

        // Step 1
        Route::get('/form/step1', [ApplicantDashboardController::class, 'showCocFormStep1'])->name('step1');
        Route::post('/form/step1', [ApplicantDashboardController::class, 'saveCocStep1'])->name('step1.store');

        // Step 2
        Route::get('/form/step2', [ApplicantDashboardController::class, 'showCocFormStep2'])->name('step2');
        Route::post('/form/step2', [ApplicantDashboardController::class, 'saveCocStep2'])->name('step2.store');

        // Step 3
        Route::get('/form/step3/{id?}', [ApplicantDashboardController::class, 'showCocFormStep3'])->name('step3');
        Route::post('/form/step3/{id?}', [ApplicantDashboardController::class, 'saveCocStep3'])->name('step3.store');

        // Step 4
        Route::get('/form/step4/{id?}', [ApplicantDashboardController::class, 'showCocFormStep4'])->name('step4');
        Route::post('/form/step4/{id?}', [ApplicantDashboardController::class, 'saveCocStep4'])->name('step4.store');

        Route::post('/form/step4/autosave', [ApplicantDashboardController::class, 'autosaveStep4'])->name('step4.autosave');


        // Genealogy Download Form
        Route::get('/genealogy/download/{id?}', [ApplicantDashboardController::class, 'downloadGenealogyPdf'])->name('genealogy-download');
        
        // Preview Genealogy Form
        Route::get('/genealogy/{id?}', [ApplicantDashboardController::class, 'showGenealogyPrint'])->name('genealogy-print');

        // Step 5
        Route::get('/form/step5/{id?}', [ApplicantDashboardController::class, 'showCocFormStep5'])->name('step5');
        Route::post('/form/step5/{id?}', [ApplicantDashboardController::class, 'saveCocStep5'])->name('step5.store');

        // Preview & Submit
        Route::get('/preview/{id}', [ApplicantDashboardController::class, 'previewCoc'])->name('preview');
        Route::post('/submit/{id}', [ApplicantDashboardController::class, 'submitCoc'])->name('submit');

        // Resubmit
        Route::prefix('resubmit')->name('resubmit.')->group(function () {
            Route::get('/{application}', [ApplicantDashboardController::class, 'showResubmit'])->name('show');
            Route::post('/{application}', [ApplicantDashboardController::class, 'submitResubmit'])->name('post');
            Route::get('/step/{step}/{application}', [ApplicantDashboardController::class, 'resubmitToStep'])->name('step');
        });
    });
});


// ═══════════════════════════════════════════════════════════
//  SHARED AUTHENTICATED ROUTES
// ═══════════════════════════════════════════════════════════

Route::middleware(['auth:web', 'verified'])->group(function () {

    // Profile Management (for admin/staff)
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // IP Dashboard (if needed)
    Route::get('/ip/dashboard', [IPController::class, 'index'])->name('ip.dashboard');
});


// ═══════════════════════════════════════════════════════════
//  LOGOUT & ROLE REDIRECT
// ═══════════════════════════════════════════════════════════

// Logout (handles both web and applicant guards)
Route::post('/logout', function () {
    if (Auth::guard('applicant')->check()) {
        Auth::guard('applicant')->logout();
    } else {
        Auth::guard('web')->logout();
    }
    return redirect('/login');
})->name('logout');

// Role-based redirect
Route::get('/redirect-based-on-role', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'staff') {
            return redirect()->route('staff.dashboard');
        }
    } elseif (Auth::guard('applicant')->check()) {
        return redirect()->route('applicant.dashboard');
    }
    return redirect('/login');
});
