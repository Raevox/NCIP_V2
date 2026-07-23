<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\Api\StaffApplicationController;
use App\Http\Controllers\Api\NotificationController;

// Test route
Route::get('/ping', function () {
    return response()->json(['message' => 'API is working']);
});

// Signature
Route::post('/process-signature', [SignatureController::class, 'processSignature'])
    ->name('api.process-signature');

// Staff applications
Route::prefix('staff')->group(function () {
    Route::get('/applications', [StaffApplicationController::class, 'index']);
    Route::get('/application-counts', [StaffApplicationController::class, 'getCounts']);
});

/*
|--------------------------------------------------------------------------
| ADMIN NOTIFICATIONS API
|--------------------------------------------------------------------------
| IMPORTANT:
| Use auth:sanctum para gumana sa fetch + session
*/
Route::prefix('admin')->middleware('auth:sanctum')->group(function () {

    Route::get('/notifications', [NotificationController::class, 'getNotifications']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount']);

    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);

    Route::post('/notifications/{id}/approve', [NotificationController::class, 'approveAccount']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);

});