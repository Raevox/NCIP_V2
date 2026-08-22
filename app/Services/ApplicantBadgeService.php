<?php

namespace App\Services;

use App\Models\User;
use App\Models\CocApplication;
use App\Models\IpAccount;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ApplicantBadgeService
{
    /**
     * Get badge status array for a given user (or currently authenticated user)
     */
    public static function getBadgeStatus(?User $user = null): array
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return [
                'main_dot'            => false,
                'under_review_count'  => 0,
                'has_under_review'    => false,
                'has_unread_returned' => false,
                'has_unread_approved' => false,
                'has_new_applicants'  => false,
                'returned_count'      => 0,
                'approved_count'      => 0,
            ];
        }

        try {
            $isStaff = $user->role === 'staff';

            // 1. Under Review / Admin Approval counts
            if ($isStaff) {
                $underReviewCount = CocApplication::where('coc_status', 'Under Review')->count();
            } else {
                // For Admin: "Admin Approval" tab represents applications awaiting admin review/action
                $underReviewCount = CocApplication::where('coc_status', 'Admin Approval')->count();
            }
            $hasUnderReview = $underReviewCount > 0;

            // 2. Returned items (for Admin only, as staff reviews and returns applications directly)
            $totalReturned = CocApplication::where('coc_status', 'Returned')->count();
            $hasUnreadReturned = false;

            if (!$isStaff && $totalReturned > 0) {
                // Check if user has unread coc_returned notifications
                $hasUnreadNotif = AdminNotification::where('user_id', $user->id)
                    ->where('type', 'coc_returned')
                    ->where('is_read', false)
                    ->exists();

                // Check timestamp comparison
                $cacheKey = "user_{$user->id}_last_viewed_returned";
                $lastViewed = Cache::get($cacheKey, session("last_viewed_returned_at_{$user->id}"));

                if ($lastViewed) {
                    $hasNewReturnedSinceView = CocApplication::where('coc_status', 'Returned')
                        ->where('updated_at', '>', $lastViewed)
                        ->exists();
                    $hasUnreadReturned = $hasUnreadNotif || $hasNewReturnedSinceView;
                } else {
                    // Never visited Returned tab yet but returned items exist
                    $hasUnreadReturned = true;
                }
            }

            // 3. Approved items (for Staff: show dot when admin approves forwarded applications)
            $totalApproved = CocApplication::where('coc_status', 'Approved')->count();
            $hasUnreadApproved = false;

            if ($isStaff && $totalApproved > 0) {
                // Check if user has unread approved notifications
                $hasUnreadApprovedNotif = AdminNotification::where('user_id', $user->id)
                    ->whereIn('type', ['account_approved', 'coc_approved'])
                    ->where('is_read', false)
                    ->exists();

                $cacheKey = "user_{$user->id}_last_viewed_approved";
                $lastViewedApproved = Cache::get($cacheKey, session("last_viewed_approved_at_{$user->id}"));

                if ($lastViewedApproved) {
                    $hasNewApprovedSinceView = CocApplication::where('coc_status', 'Approved')
                        ->where('updated_at', '>', $lastViewedApproved)
                        ->exists();
                    $hasUnreadApproved = $hasUnreadApprovedNotif || $hasNewApprovedSinceView;
                } else {
                    $hasUnreadApproved = $hasUnreadApprovedNotif;
                }
            }

            // 4. New Applicants (Account Registrations) - mainly for Admin
            $hasNewApplicants = false;
            if (!$isStaff) {
                $hasNewApplicants = AdminNotification::where('user_id', $user->id)
                    ->where('type', 'pending_account')
                    ->where('is_read', false)
                    ->exists();
            }

            // 5. Main Applicants Menu dot
            // Visible if ANY active 'Under Review' items, new applications, unviewed 'Returned' items (admin), or unviewed 'Approved' items (staff) exist
            $mainDot = $hasUnderReview || $hasUnreadReturned || $hasNewApplicants || $hasUnreadApproved;

            return [
                'main_dot'            => $mainDot,
                'under_review_count'  => $underReviewCount,
                'has_under_review'    => $hasUnderReview,
                'has_unread_returned' => $hasUnreadReturned,
                'has_unread_approved' => $hasUnreadApproved,
                'has_new_applicants'  => $hasNewApplicants,
                'returned_count'      => $totalReturned,
                'approved_count'      => $totalApproved,
            ];
        } catch (\Exception $e) {
            Log::error('ApplicantBadgeService::getBadgeStatus error: ' . $e->getMessage());
            return [
                'main_dot'            => false,
                'under_review_count'  => 0,
                'has_under_review'    => false,
                'has_unread_returned' => false,
                'has_unread_approved' => false,
                'has_new_applicants'  => false,
                'returned_count'      => 0,
                'approved_count'      => 0,
            ];
        }
    }

    /**
     * Mark all notifications and applicant views as read for the user
     */
    public static function markAllNotificationsAsRead(?User $user = null): array
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return self::getBadgeStatus(null);
        }

        try {
            $now = now();

            // Mark all unread AdminNotification records as read for this user
            AdminNotification::where('user_id', $user->id)
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => $now,
                ]);

            // Save last viewed timestamps in both cache and session
            $cacheKeyReturned = "user_{$user->id}_last_viewed_returned";
            Cache::forever($cacheKeyReturned, $now->toDateTimeString());
            session(["last_viewed_returned_at_{$user->id}" => $now->toDateTimeString()]);

            $cacheKeyApproved = "user_{$user->id}_last_viewed_approved";
            Cache::forever($cacheKeyApproved, $now->toDateTimeString());
            session(["last_viewed_approved_at_{$user->id}" => $now->toDateTimeString()]);

            return self::getBadgeStatus($user);
        } catch (\Exception $e) {
            Log::error('ApplicantBadgeService::markAllNotificationsAsRead error: ' . $e->getMessage());
            return self::getBadgeStatus($user);
        }
    }

    /**
     * Mark all returned applications/notifications as viewed for the user
     */
    public static function markReturnedAsViewed(?User $user = null): array
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return self::getBadgeStatus(null);
        }

        try {
            $now = now();

            // Mark coc_returned notifications as read
            AdminNotification::where('user_id', $user->id)
                ->where('type', 'coc_returned')
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => $now,
                ]);

            // Save last viewed timestamp in both cache and session
            $cacheKey = "user_{$user->id}_last_viewed_returned";
            Cache::forever($cacheKey, $now->toDateTimeString());
            session(["last_viewed_returned_at_{$user->id}" => $now->toDateTimeString()]);

            return self::getBadgeStatus($user);
        } catch (\Exception $e) {
            Log::error('ApplicantBadgeService::markReturnedAsViewed error: ' . $e->getMessage());
            return self::getBadgeStatus($user);
        }
    }

    /**
     * Mark all approved applications/notifications as viewed for the user
     */
    public static function markApprovedAsViewed(?User $user = null): array
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return self::getBadgeStatus(null);
        }

        try {
            $now = now();

            // Mark account_approved / coc_approved notifications as read
            AdminNotification::where('user_id', $user->id)
                ->whereIn('type', ['account_approved', 'coc_approved'])
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => $now,
                ]);

            // Save last viewed timestamp in both cache and session
            $cacheKey = "user_{$user->id}_last_viewed_approved";
            Cache::forever($cacheKey, $now->toDateTimeString());
            session(["last_viewed_approved_at_{$user->id}" => $now->toDateTimeString()]);

            return self::getBadgeStatus($user);
        } catch (\Exception $e) {
            Log::error('ApplicantBadgeService::markApprovedAsViewed error: ' . $e->getMessage());
            return self::getBadgeStatus($user);
        }
    }
}
