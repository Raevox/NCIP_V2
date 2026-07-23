<div class="container-fluid py-4">
    <!-- Header with Mark All as Read Button -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h4 class="mb-0">
                Notifications
                @if($unreadCount > 0)
                    <span class="badge bg-danger">{{ $unreadCount }} New</span>
                @endif
            </h4>
        </div>
        <div class="col-md-6 text-end">
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-check-double"></i> Mark all as read
                </button>
            @endif
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="mb-4">
        <div class="btn-group btn-group-sm" role="group">
            <input type="radio" class="btn-check" name="filter" id="filter_all" value="all" 
                   wire:model.live="filterType" checked>
            <label class="btn btn-outline-secondary" for="filter_all">All</label>

            <input type="radio" class="btn-check" name="filter" id="filter_pending" value="pending_account" 
                   wire:model.live="filterType">
            <label class="btn btn-outline-secondary" for="filter_pending">Pending Accounts</label>

            <input type="radio" class="btn-check" name="filter" id="filter_coc_approval" value="coc_approval" 
                   wire:model.live="filterType">
            <label class="btn btn-outline-secondary" for="filter_coc_approval">COC Approval</label>

            <input type="radio" class="btn-check" name="filter" id="filter_coc_returned" value="coc_returned" 
                   wire:model.live="filterType">
            <label class="btn btn-outline-secondary" for="filter_coc_returned">COC Returned</label>

            <input type="radio" class="btn-check" name="filter" id="filter_forwarded" value="application_forwarded" 
                   wire:model.live="filterType">
            <label class="btn btn-outline-secondary" for="filter_forwarded">Forwarded</label>

            <input type="radio" class="btn-check" name="filter" id="filter_approved" value="account_approved" 
                   wire:model.live="filterType">
            <label class="btn btn-outline-secondary" for="filter_approved">Approved</label>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="notification-list">
        @forelse($notifications as $notification)
            <div class="card mb-3 notification-item {{ !$notification->is_read ? 'border-info bg-light' : '' }}" 
                 style="{{ !$notification->is_read ? 'border-left: 4px solid #0d6efd;' : '' }}">
                <div class="card-body p-3">
                    <div class="row align-items-start">
                        <div class="col-auto">
                            <div class="notification-icon" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background-color: {{ $notification->getTypeColor() }}cf;">
                                <i class="fas fa-{{ $notification->getTypeIcon() }} text-white"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h6 class="card-title mb-1 {{ !$notification->is_read ? 'fw-bold' : '' }}">
                                {{ $notification->title }}
                            </h6>
                            <p class="card-text mb-2 text-muted small">
                                {{ $notification->message }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> {{ $notification->created_at->diffForHumans() }}
                                </small>
                                <div class="btn-group btn-group-sm" role="group">
                                    @if(!$notification->is_read)
                                        <button wire:click="markAsRead({{ $notification->id }})" 
                                                class="btn btn-outline-primary btn-sm" title="Mark as read">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                    <button wire:click="deleteNotification({{ $notification->id }})" 
                                            class="btn btn-outline-danger btn-sm" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center py-5">
                <i class="fas fa-inbox fa-3x mb-3 d-block text-muted"></i>
                <p class="mb-0">No notifications yet. You're all caught up!</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($notifications->count() > 0)
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted small">
                Showing <strong>{{ $notifications->firstItem() }}</strong> to 
                <strong>{{ $notifications->lastItem() }}</strong> of 
                <strong>{{ $notifications->total() }}</strong> notifications
            </div>
            <div>
                {{ $notifications->links('pagination::bootstrap-4') }}
            </div>
        </div>
    @endif
</div>

<style>
    .notification-item {
        transition: all 0.3s ease;
    }
    .notification-item:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
</style>
