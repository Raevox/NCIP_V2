<?php

namespace App\Services;

use App\Models\AdminNotification;
use App\Models\User;
use App\Models\CocApplication;
use App\Models\IpAccount;
use Illuminate\Support\Facades\Log;
use App\Notifications\ApplicantStatusNotification;

class NotificationService
{
    public static function notifyApplicantSubmitted(CocApplication $application): void
    {
        self::notifyApplicant(
            $application,
            'application_submitted',
            'Application Submitted',
            'Your COC application has been submitted and is now under staff review.',
            'normal'
        );
    }

    public static function notifyApplicantForwarded(CocApplication $application): void
    {
        self::notifyApplicant(
            $application,
            'application_forwarded',
            'Application Forwarded',
            'Your COC application passed staff review and was forwarded to the administrator for final approval.',
            'normal'
        );
    }

    public static function notifyApplicantReturned(CocApplication $application, string $issues = ''): void
    {
        $message = 'Your COC application needs corrections. Please review the staff remarks and resubmit it.';
        if ($issues !== '') {
            $message .= " Sections requiring attention: {$issues}.";
        }

        self::notifyApplicant($application, 'application_returned', 'Corrections Required', $message, 'high');
    }

    public static function notifyApplicantApproved(CocApplication $application): void
    {
        self::notifyApplicant(
            $application,
            'application_approved',
            'COC Application Approved',
            'Your COC application has been approved and your Certificate of Confirmation has been issued.',
            'high'
        );
    }

    public static function notifyApplicantDeclined(CocApplication $application, string $reason): void
    {
        self::notifyApplicant(
            $application,
            'application_declined',
            'COC Application Declined',
            "Your COC application was declined. Reason: {$reason}",
            'high'
        );
    }

    private static function notifyApplicant(
        CocApplication $application,
        string $type,
        string $title,
        string $message,
        string $priority
    ): void {
        try {
            $applicant = $application->applicant ?: IpAccount::find($application->user_id);
            $applicant?->notify(new ApplicantStatusNotification(
                $type,
                $title,
                $message,
                route('applicant.track-status', [], false),
                $application->id,
                $priority
            ));
        } catch (\Throwable $e) {
            Log::error('Applicant notification error: ' . $e->getMessage());
        }
    }

    public static function notifyNewAccount(IpAccount $account): void
{
    try {
        $name = trim(($account->first_name ?? '') . ' ' . ($account->last_name ?? ''))
            ?: ($account->name ?? "Account #{$account->id}");

        $admins = User::where('role', 'admin')->where('status', 'active')->get();

        foreach ($admins as $admin) {
            AdminNotification::updateOrCreate(
                [
                    'user_id'      => $admin->id,
                    'related_id'   => $account->id,
                    'related_type' => 'IpAccount',
                    'type' => 'new_account',
                ],
                [
                   'title'   => 'New Registration',
                    'message' => "{$name} has registered.",
                    'action_url' => null,
                    'priority'   => 'normal',
                    'is_read'    => false,
                ]
            );
        }
    } catch (\Exception $e) {
        Log::error('notifyNewAccount error: ' . $e->getMessage());
    }
}

    public static function notifyCocNeedsApproval(CocApplication $application, bool $isResubmission = false): void
    {
        try {
            $name = self::getApplicantName($application);
            $url = self::safeRoute('staff.review.show', $application->id)
                ?? '/staff/review/' . $application->id;

            $reviewers = User::where('status', 'active')
                ->where('role', 'staff')
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
                        'title'      => $isResubmission ? 'COC Application Resubmitted' : 'COC Application Pending Review',
                        'message'    => $isResubmission
                            ? "COC application from {$name} was corrected and resubmitted for review."
                            : "COC application from {$name} is submitted and waiting for approval.",
                        'action_url' => $url,
                        'priority'   => 'high',
                        'is_read'    => false,
                        'read_at'    => null,
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
                        'type'       => 'coc_approved',
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
            $url = self::safeRoute('admin.applicants.transaction', $application->user_id)
                ?? '/admin/applicants/' . $application->user_id . '/transaction';

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

            $staffUrl = self::safeRoute('staff.review.show', $application->id)
                ?? '/staff/review/' . $application->id;
            $staffMembers = User::where('role', 'staff')->where('status', 'active')->get();

            foreach ($staffMembers as $staff) {
                AdminNotification::updateOrCreate(
                    [
                        'user_id' => $staff->id,
                        'related_id' => $application->id,
                        'related_type' => 'CocApplication',
                    ],
                    [
                        'type' => 'coc_returned',
                        'title' => 'COC Application Returned',
                        'message' => $msg,
                        'action_url' => $staffUrl,
                        'priority' => 'high',
                        'is_read' => false,
                        'read_at' => null,
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
            $url = self::safeRoute('admin.applicants.index', ['status' => 'Admin Approval'])
                ?? '/admin/applicants?status=Admin%20Approval';

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

            // Replace the staff review notification with a forwarding activity,
            // keeping one lifecycle entry per application in the staff feed.
            $staffMembers = User::where('role', 'staff')->where('status', 'active')->get();

            foreach ($staffMembers as $staff) {
                AdminNotification::updateOrCreate(
                    [
                        'user_id' => $staff->id,
                        'related_id' => $application->id,
                        'related_type' => 'CocApplication',
                    ],
                    [
                        'type' => 'application_forwarded',
                        'title' => 'Application Forwarded to Admin',
                        'message' => "COC application from {$name} was forwarded to the administrator for final approval.",
                        'action_url' => null,
                        'priority' => 'normal',
                        'is_read' => false,
                        'read_at' => null,
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
            $parameters = count($params) === 1 && is_array($params[0]) ? $params[0] : $params;
            return route($name, $parameters, false);
        } catch (\Exception $e) {
            Log::warning("safeRoute '{$name}' not found: " . $e->getMessage());
            return null;
        }
    }
}
