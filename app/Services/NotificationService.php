<?php

namespace App\Services;

use App\Models\AdminNotification;
use App\Models\User;
use App\Models\CocApplication;
use App\Models\IpAccount;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public static function notifyPendingAccount(IpAccount $account): void
{
    try {
        $name = trim(($account->first_name ?? '') . ' ' . ($account->last_name ?? ''))
            ?: ($account->name ?? "Account #{$account->id}");

        $url = self::safeRoute('admin.applicants.view', $account->id)
            ?? url('/admin/applicants/' . $account->id . '/view');

        $admins = User::where('role', 'admin')->where('status', 'active')->get();

        foreach ($admins as $admin) {
            AdminNotification::updateOrCreate(
                [
                    'user_id'      => $admin->id,
                    'related_id'   => $account->id,
                    'related_type' => 'IpAccount',
                    'type' => 'pending_account',
                ],
                [
                   'title'   => 'New Registration',
                    'message' => "{$name} has registered.",
                    'action_url' => $url,
                    'priority'   => 'high',
                    'is_read'    => false,
                ]
            );
        }
    } catch (\Exception $e) {
        Log::error('notifyPendingAccount error: ' . $e->getMessage());
    }
}

    public static function notifyCocNeedsApproval(CocApplication $application): void
    {
        try {
            $name = self::getApplicantName($application);
            $url = self::safeRoute('admin.applicants.coc.view', $application->id)
                ?? url('/admin/applicants/coc/' . $application->id . '/view');

            $reviewers = User::where('status', 'active')
                ->whereIn('role', ['admin', 'staff'])
                ->get();

            foreach ($reviewers as $user) {
                AdminNotification::updateOrCreate(
                    [
                        'user_id'      => $user->id,
                        'related_id'   => $application->id,
                        'related_type' => 'CocApplication',
                    ],
                    [
                        'type'       => 'coc_approval',
                        'title'      => 'COC Application Pending Review',
                        'message'    => "COC application from {$name} is submitted and waiting for approval.",
                        'action_url' => $url,
                        'priority'   => 'high',
                        'is_read'    => false,
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error('notifyCocNeedsApproval error: ' . $e->getMessage());
        }
    }

    public static function notifyCocApproved(CocApplication $application): void
    {
        try {
            $name = self::getApplicantName($application);
            $url = self::safeRoute('admin.applicants.coc.view', $application->id)
                ?? url('/admin/applicants/coc/' . $application->id . '/view');

            $admins = User::where('role', 'admin')->where('status', 'active')->get();

            foreach ($admins as $admin) {
                AdminNotification::updateOrCreate(
                    [
                        'user_id'      => $admin->id,
                        'related_id'   => $application->id,
                        'related_type' => 'CocApplication',
                    ],
                    [
                        'type'       => 'account_approved',
                        'title'      => 'COC Application Approved',
                        'message'    => "COC application from {$name} has been approved.",
                        'action_url' => $url,
                        'priority'   => 'normal',
                        'is_read'    => false,
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error('notifyCocApproved error: ' . $e->getMessage());
        }
    }

    public static function notifyCocReturned(CocApplication $application, ?string $reason = null): void
    {
        try {
            $name = self::getApplicantName($application);
            $url = self::safeRoute('admin.applicants.coc.view', $application->id)
                ?? url('/admin/applicants/coc/' . $application->id . '/view');

            $msg = "COC application from {$name} has been returned for revision.";
            if ($reason) $msg .= " Reason: {$reason}";

            $admins = User::where('role', 'admin')->where('status', 'active')->get();

            foreach ($admins as $admin) {
                AdminNotification::updateOrCreate(
                    [
                        'user_id'      => $admin->id,
                        'related_id'   => $application->id,
                        'related_type' => 'CocApplication',
                    ],
                    [
                        'type'       => 'coc_returned',
                        'title'      => 'COC Application Returned',
                        'message'    => $msg,
                        'action_url' => $url,
                        'priority'   => 'high',
                        'is_read'    => false,
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error('notifyCocReturned error: ' . $e->getMessage());
        }
    }

    public static function notifyApplicationForwarded(CocApplication $application): void
    {
        try {
            $name = self::getApplicantName($application);
            $url = self::safeRoute('admin.applicants.coc.view', $application->id)
                ?? url('/admin/applicants/coc/' . $application->id . '/view');

            $admins = User::where('role', 'admin')->where('status', 'active')->get();

            foreach ($admins as $admin) {
                AdminNotification::updateOrCreate(
                    [
                        'user_id'      => $admin->id,
                        'related_id'   => $application->id,
                        'related_type' => 'CocApplication',
                    ],
                    [
                        'type'       => 'application_forwarded',
                        'title'      => 'Application Forwarded',
                        'message'    => "Staff has forwarded COC application from {$name} for your approval.",
                        'action_url' => $url,
                        'priority'   => 'high',
                        'is_read'    => false,
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error('notifyApplicationForwarded error: ' . $e->getMessage());
        }
    }

    private static function getApplicantName(CocApplication $application): string
    {
        try {
            $applicant = $application->applicant;
            if ($applicant) {
                $n = trim(($applicant->first_name ?? '') . ' ' . ($applicant->last_name ?? ''));
                return $n ?: ($applicant->name ?? 'Unknown');
            }
        } catch (\Exception $e) {
            Log::warning('getApplicantName relationship failed: ' . $e->getMessage());
        }

        $step1 = $application->step1 ?? [];
        $n = trim(($step1['first_name'] ?? '') . ' ' . ($step1['last_name'] ?? ''));
        return $n ?: 'Unknown';
    }

    private static function safeRoute(string $name, mixed ...$params): ?string
    {
        try {
            return route($name, ...$params);
        } catch (\Exception $e) {
            Log::warning("safeRoute '{$name}' not found: " . $e->getMessage());
            return null;
        }
    }
}