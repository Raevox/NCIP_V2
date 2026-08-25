<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminNotification extends Model
{
    protected $table = 'admin_notifications';

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'related_id',
        'related_type',
        'action_url',
        'is_read',
        'read_at',
        'priority',
    ];

    protected $casts = [
        'is_read'    => 'boolean',
        'read_at'    => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    /**
     * Mark this notification as read (idempotent — safe to call multiple times).
     */
    public function markAsRead(): static
    {
        if (! $this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        return $this;
    }

    /**
     * Mark this notification as unread.
     */
    public function markAsUnread(): static
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);

        return $this;
    }

    // ── Scopes / static helpers ────────────────────────────────────────────

    /**
     * All unread notifications for a user, newest first.
     */
    public static function unreadForUser(int $userId)
    {
        return static::where('user_id', $userId)
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Paginated notifications for a user.
     */
    public static function forUser(int $userId, int $perPage = 15, string $type = 'all')
    {
        $query = static::where('user_id', $userId);

        if ($type !== 'all') {
            $query->where('type', $type);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    // ── Presentation helpers ───────────────────────────────────────────────

    public function getTypeColor(): string
    {
        return match ($this->type) {
            'pending_account'        => 'warning',
            'coc_approval'           => 'info',
            'coc_returned'           => 'danger',
            'application_forwarded'  => 'info',
            'coc_approved'           => 'success',
            default                  => 'secondary',
        };
    }

    public function getTypeIcon(): string
    {
        return match ($this->type) {
            'pending_account'        => 'fa-user-clock',
            'coc_approval'           => 'fa-file-alt',
            'coc_returned'           => 'fa-undo',
            'application_forwarded'  => 'fa-share',
            'coc_approved'           => 'fa-check-circle',
            default                  => 'fa-bell',
        };
    }
}
