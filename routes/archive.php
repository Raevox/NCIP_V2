<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IPRecordController;
use App\Http\Controllers\Admin\AccountApprovalController;

// Middleware para sa authentication at role verification
Route::middleware(['auth', 'verified'])->group(function () {

    Route::prefix('archive')->name('archive.')->group(function () {

        // IP Records Archive
        Route::get('/ip-records', [IPRecordController::class, 'archive'])->name('ip_records');
        Route::post('/ip-records/{id}/restore', [IPRecordController::class, 'restore'])->name('ip_records.restore');

        // Admin Accounts Archive
        Route::get('/accounts', [AccountApprovalController::class, 'archivedAccounts'])->name('accounts');
        Route::post('/accounts/{id}/restore', [AccountApprovalController::class, 'restore'])->name('accounts.restore');

        // Pwede ka magdagdag ng iba pang archived resources dito kung kailangan
    });

});
