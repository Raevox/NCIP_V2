<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AdminNotification;
use App\Models\IpAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationCenter extends Component
{
    use WithPagination;

    public int    $perPage       = 15;
    public string $filterType    = 'all';
    public string $sortBy        = 'created_at';
    public string $sortDirection = 'desc';

    protected string $paginationTheme = 'tailwind';

    // ── Lifecycle ───────────────────────────────────────

    public function updatingFilterType(): void
    {
        $this->resetPage();
    }

    // ── Actions ─────────────────────────────────────────

    public function markAsRead(int $notificationId): void
    {
        $notification = AdminNotification::where('id', $notificationId)
            ->where('user_id', Auth::id())
            ->first();

        if ($notification) {
            $notification->is_read = true;
            $notification->read_at = now();
            $notification->save();

            $this->dispatch('notification-updated');
        }
    }

    public function deleteNotification(int $notificationId): void
    {
        $deleted = AdminNotification::where('id', $notificationId)
            ->where('user_id', Auth::id())
            ->delete();

        if ($deleted) {
            $this->dispatch('notification-updated');
            session()->flash('success', 'Notification deleted.');
        }
    }

    public function markAllAsRead(): void
    {
        AdminNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        $this->dispatch('notification-updated');
        session()->flash('success', 'All notifications marked as read.');
    }

    public function approveAccount(int $notificationId): void
    {
        try {
            $notification = AdminNotification::where('id', $notificationId)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            if ($notification->type !== 'pending_account') {
                session()->flash('error', 'Only pending account notifications can be approved.');
                return;
            }

            $ipAccount = IpAccount::find($notification->related_id);

            if (! $ipAccount) {
                // auto delete broken notification
                $notification->delete();

                session()->flash('error', 'Account not found. Notification removed.');
                return;
            }

            // ✅ prevent duplicate approve
            if ($ipAccount->status === 'approved') {
                session()->flash('info', 'Account already approved.');
                return;
            }

            // ✅ approve account
            $ipAccount->status = 'approved';
            $ipAccount->save();

            $accountName = trim(($ipAccount->first_name ?? '') . ' ' . ($ipAccount->last_name ?? ''))
                        ?: ($ipAccount->name ?? 'Unknown');

            // ✅ DELETE old pending notification (IMPORTANT FIX)
            $notification->delete();

            // ✅ notify admins (NO DUPLICATES)
            $admins = User::where('role', 'admin')
                ->where('status', 'active')
                ->get();

            foreach ($admins as $admin) {

                AdminNotification::firstOrCreate(
                    [
                        'user_id'    => $admin->id,
                        'type'       => 'account_approved',
                        'related_id' => $ipAccount->id,
                    ],
                    [
                        'title'        => 'Account Approved',
                        'message'      => "{$accountName}'s account has been approved and is now active.",
                        'related_type' => 'IpAccount',
                        'action_url'   => route('admin.applicants.view', $ipAccount->id),
                        'priority'     => 'normal',
                        'is_read'      => false,
                    ]
                );
            }

            $this->dispatch('notification-updated');
            session()->flash('success', "{$accountName}'s account has been approved.");

        } catch (\Exception $e) {
            Log::error('NotificationCenter::approveAccount — ' . $e->getMessage());
            session()->flash('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function viewAndRedirect(int $notificationId, ?string $actionUrl): void
    {
        $notification = AdminNotification::where('id', $notificationId)
            ->where('user_id', Auth::id())
            ->first();

        if ($notification) {
            $notification->is_read = true;
            $notification->read_at = now();
            $notification->save();
        }

        if ($actionUrl && filter_var($actionUrl, FILTER_VALIDATE_URL)) {
            $this->redirect($actionUrl);
        }
    }

    // ── Computed ────────────────────────────────────────

    public function getNotificationsProperty()
    {
        $query = AdminNotification::where('user_id', Auth::id());

        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }

        return $query->orderBy($this->sortBy, $this->sortDirection)
                     ->paginate($this->perPage);
    }

    public function getUnreadCountProperty(): int
    {
        return AdminNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
    }

    // ── Render ──────────────────────────────────────────
public function approveCoc(int $notificationId): void
{
    $notification = AdminNotification::where('id', $notificationId)
        ->where('user_id', Auth::id())
        ->first();

    if (!$notification || $notification->type !== 'new_coc') {
        session()->flash('error', 'Invalid notification.');
        return;
    }

    $application = \App\Models\CocApplication::find($notification->related_id);

    if (!$application) {
        session()->flash('error', 'Application not found.');
        return;
    }

    $application->coc_status = 'Approved';
    $application->save();

    $notification->markAsRead();

    session()->flash('success', 'COC application approved.');
    $this->dispatch('notification-updated');
}

    public function render()
    {
        return view('livewire.notification-center', [
            'notifications' => $this->notifications,
            'unreadCount'   => $this->unreadCount,
        ]);
    }
}