<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\CocApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function getNotifications(Request $request)
    {
        try {
            $type    = $request->query('type', 'all');
            $page    = max(1, (int) $request->query('page', 1));
            $perPage = min(50, max(1, (int) $request->query('per_page', 15)));

            $query = AdminNotification::where('user_id', Auth::id())
                ->where('type', '!=', 'pending_account')
                ->where(function ($q) {
                    $q->where('related_type', '!=', 'IpAccount')
                      ->orWhereExists(function ($sub) {
                          $sub->select(DB::raw(1))
                              ->from('ip_accounts')
                              ->whereColumn('ip_accounts.id', 'admin_notifications.related_id');
                      });
                });

            // Staff handles initial COC review. Admin only enters the flow after forwarding.
            if (Auth::user()?->role === 'admin') {
                $query->where('type', '!=', 'coc_approval');
            }

            if ($type !== 'all') {
                $query->where('type', $type);
            }

            $pager = $query->orderBy('created_at', 'desc')
                           ->paginate($perPage, ['*'], 'page', $page);

            // Rebuild internal links using the current request host and workflow state.
            $applicationIds = collect($pager->items())
                ->where('related_type', 'CocApplication')
                ->pluck('related_id')
                ->filter()
                ->unique();
            $applications = CocApplication::whereIn('id', $applicationIds)->get()->keyBy('id');

            foreach ($pager->items() as $notification) {
                if ($notification->related_type === 'CocApplication' && $notification->related_id) {
                    $application = $applications->get($notification->related_id);
                    $notification->action_url = match ($notification->type) {
                        'coc_approval' => route('staff.review.show', $notification->related_id),
                        'application_forwarded' => route('admin.applicants.index', ['status' => 'Admin Approval']),
                        'coc_approved' => route('admin.applicants.coc.view', $notification->related_id),
                        'coc_returned' => $application
                            ? route('admin.applicants.transaction', $application->user_id)
                            : null,
                        default => $notification->action_url,
                    };
                }
            }

            return response()->json([
                'success'        => true,
                'data'           => $pager->items(),
                'from'           => $pager->firstItem() ?? 0,
                'to'             => $pager->lastItem()  ?? 0,
                'total'          => $pager->total(),
                'per_page'       => $pager->perPage(),
                'current_page'   => $pager->currentPage(),
                'last_page'      => $pager->lastPage(),
                'has_more_pages' => $pager->hasMorePages(),
            ]);

        } catch (\Exception $e) {
            Log::error('getNotifications: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
                'total' => 0,
                'current_page' => 1,
                'last_page' => 1,
                'has_more_pages' => false,
            ], 500);
        }
    }

    public function getUnreadCount()
    {
        try {
            $countQuery = AdminNotification::where('user_id', Auth::id())
                ->where('type', '!=', 'pending_account')
                ->where('is_read', false);

            if (Auth::user()?->role === 'admin') {
                $countQuery->where('type', '!=', 'coc_approval');
            }

            $count = $countQuery->count();

            $badgeStatus = \App\Services\ApplicantBadgeService::getBadgeStatus();

            return response()->json([
                'success'        => true,
                'unreadCount'    => $count,
                'applicantBadge' => $badgeStatus,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success'        => false,
                'unreadCount'    => 0,
                'applicantBadge' => [
                    'main_dot'            => false,
                    'under_review_count'  => 0,
                    'has_under_review'    => false,
                    'has_unread_returned' => false,
                    'has_unread_approved' => false,
                    'has_new_applicants'  => false,
                    'returned_count'      => 0,
                    'approved_count'      => 0,
                ],
            ]);
        }
    }

    public function getApplicantBadgeStatus()
    {
        return response()->json([
            'success'     => true,
            'badgeStatus' => \App\Services\ApplicantBadgeService::getBadgeStatus()
        ]);
    }

    public function markReturnedAsViewed()
    {
        $status = \App\Services\ApplicantBadgeService::markReturnedAsViewed();
        return response()->json([
            'success'     => true,
            'badgeStatus' => $status
        ]);
    }

    public function markApprovedAsViewed()
    {
        $status = \App\Services\ApplicantBadgeService::markApprovedAsViewed();
        return response()->json([
            'success'     => true,
            'badgeStatus' => $status
        ]);
    }

    public function markAsRead($id)
    {
        try {
            $n = AdminNotification::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $n->is_read = true;
            $n->read_at = now();
            $n->save();

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function markAllAsRead()
    {
        try {
            $status = \App\Services\ApplicantBadgeService::markAllNotificationsAsRead(Auth::user());

            return response()->json([
                'success'     => true,
                'badgeStatus' => $status
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /* DELETE (optional - pwede mo na hindi gamitin sa UI) */
    public function destroy($id)
    {
        try {
            $notification = AdminNotification::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $notification->delete();

            return response()->json([
                'success' => true,
                'message' => 'Notification deleted'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /* ✅ UPDATED APPROVE (WITH AUTO NOTIFICATION) */
public function approveAccount($id)
{
    try {
        $notification = AdminNotification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $user = User::findOrFail($notification->related_id);

        // ✅ Approve user
        $user->status = 'approved';
        $user->save();

        // ❗ DELETE old pending notification
        $notification->delete();

        // ✅ CREATE NEW APPROVED NOTIFICATION
        AdminNotification::create([
            'user_id'    => Auth::id(),
            'type'       => 'account_approved',
            'title'      => 'Account Successfully Approved',
            'message'    => $user->name . ' account has been successfully approved.',
            'is_read'    => false,
            'related_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Account approved successfully'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    private function safeRoute(string $name, mixed ...$params): ?string
    {
        try {
            return route($name, ...$params);
        } catch (\Exception $e) {
            Log::warning("safeRoute failed: " . $e->getMessage());
            return null;
        }
    }
}
