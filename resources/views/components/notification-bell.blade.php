<!-- Notification Bell Icon and Dropdown -->
<div class="notification-container">
    <button class="btn-notification" id="notificationBtn" onclick="toggleNotifications()" title="Notifications">
        <i class="fas fa-bell"></i>
        <span class="notification-badge" id="notificationBadge" style="display: none;">0</span>
    </button>

    <!-- Notification Dropdown -->
    <div class="notification-dropdown" id="notificationDropdown" style="display: none;">
        <div class="notification-header">
            <h6><i class="fas fa-bell" style="margin-right: 8px; color: #3E7B27;"></i>Notifications</h6>
            <button class="btn-close" onclick="toggleNotifications()" title="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="notification-list" id="notificationList">
            <div class="no-notifications">
                <i class="fas fa-inbox"></i>
                <p>Loading notifications...</p>
            </div>
        </div>

        <div class="notification-footer">
            <a href="{{ route('admin.notifications.index') }}" class="btn-footer-link">
                <i class="fas fa-list-check"></i> View All
            </a>
            <button class="btn-footer-link" id="markAllReadBtn" onclick="markAllAsRead()" style="flex: 1;">
                <i class="fas fa-check-double"></i> Mark All Read
            </button>
        </div>
    </div>
</div>

<style>
.notification-container {
    position: relative;
    display: inline-block;
}

.btn-notification {
    background: transparent;
    border: none;
    color: #3E7B27;
    font-size: 20px;
    cursor: pointer;
    position: relative;
    padding: 8px 12px;
    transition: all 0.3s ease;
}

.btn-notification:hover {
    color: #2f5f1e;
    transform: scale(1.12);
}

.notification-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%);
    color: white;
    border-radius: 50%;
    width: 26px;
    height: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    box-shadow: 0 3px 12px rgba(220, 53, 69, 0.4);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 3px 12px rgba(220, 53, 69, 0.4);
    }
    50% {
        box-shadow: 0 3px 20px rgba(220, 53, 69, 0.6);
    }
    100% {
        box-shadow: 0 3px 12px rgba(220, 53, 69, 0.4);
    }
}

.notification-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    width: 420px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.18);
    z-index: 1000;
    margin-top: 12px;
    overflow: hidden;
    animation: slideDown 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    max-height: 600px;
    display: flex;
    flex-direction: column;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.notification-header {
    padding: 20px;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
}

.notification-header h6 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #1a1a1a;
    display: flex;
    align-items: center;
}

.btn-close {
    background: none;
    border: none;
    color: #999;
    cursor: pointer;
    font-size: 20px;
    padding: 4px 8px;
    margin: -4px -8px 0 0;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-close:hover {
    color: #333;
    background: rgba(0, 0, 0, 0.05);
    border-radius: 6px;
}

.notification-list {
    flex: 1;
    overflow-y: auto;
    max-height: 400px;
}

.notification-list::-webkit-scrollbar {
    width: 6px;
}

.notification-list::-webkit-scrollbar-track {
    background: #f8f9fa;
}

.notification-list::-webkit-scrollbar-thumb {
    background: #ddd;
    border-radius: 3px;
}

.notification-list::-webkit-scrollbar-thumb:hover {
    background: #bbb;
}

.notification-item {
    padding: 16px 20px;
    border-bottom: 1px solid #f5f5f5;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    gap: 14px;
    align-items: flex-start;
    position: relative;
    overflow: hidden;
}

.notification-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #ddd;
    transition: all 0.2s ease;
}

.notification-item:hover {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.notification-item.unread {
    background: linear-gradient(135deg, #f0f7ed 0%, #f5fbf2 100%);
}

.notification-item.unread::before {
    background: #3E7B27;
    width: 4px;
}

.notification-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
    color: white;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.notification-icon.warning {
    background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
}

.notification-icon.info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
}

.notification-icon.danger {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.notification-icon.success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
}

.notification-icon.secondary {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
}

.notification-content {
    flex: 1;
    min-width: 0;
}

.notification-content h6 {
    margin: 0 0 6px 0;
    font-size: 14px;
    font-weight: 700;
    color: #1a1a1a;
}

.notification-content p {
    margin: 0 0 8px 0;
    font-size: 13px;
    color: #666;
    line-height: 1.4;
}

.notification-time {
    font-size: 11px;
    color: #999;
    margin-top: 4px;
}

.notification-footer {
    padding: 14px 20px;
    border-top: 1px solid #f0f0f0;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    display: flex;
    gap: 8px;
}

.btn-footer-link {
    flex: 1;
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 12px;
    border: 1.5px solid #e0e0e0;
    background: white;
    color: #3E7B27;
    cursor: pointer;
    transition: all 0.2s ease;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    text-decoration: none;
}

.btn-footer-link:hover {
    background: linear-gradient(135deg, #3E7B27 0%, #2d6a1f 100%);
    color: white;
    border-color: #3E7B27;
    box-shadow: 0 4px 12px rgba(62, 123, 39, 0.3);
    transform: translateY(-2px);
}

.no-notifications {
    padding: 60px 20px;
    text-align: center;
    color: #999;
}

.no-notifications i {
    font-size: 48px;
    margin-bottom: 12px;
    opacity: 0.4;
}

.no-notifications p {
    margin: 0;
    font-size: 14px;
    font-weight: 500;
}
</style>

<script>
let notificationInterval = null;

function toggleNotifications() {
    const dropdown = document.getElementById('notificationDropdown');
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';

    if (dropdown.style.display === 'block') {
        loadNotifications();
        // Refresh every 10 seconds while open
        if (notificationInterval) clearInterval(notificationInterval);
        notificationInterval = setInterval(loadNotifications, 10000);
    } else {
        if (notificationInterval) clearInterval(notificationInterval);
    }
}

function loadNotifications() {
    fetch('{{ route("admin.notifications.getUnread") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateNotificationUI(data.notifications, data.unreadCount);
            }
        })
        .catch(error => console.error('Error loading notifications:', error));
}

function updateNotificationUI(notifications, unreadCount) {
    const badge = document.getElementById('notificationBadge');
    const list = document.getElementById('notificationList');

    // Update badge
    if (unreadCount > 0) {
        badge.textContent = unreadCount;
        badge.style.display = 'flex';
    } else {
        badge.style.display = 'none';
    }

    // Update list
    if (notifications.length === 0) {
        list.innerHTML = `
            <div class="no-notifications">
                <i class="fas fa-inbox"></i>
                <p>No new notifications</p>
            </div>
        `;
        return;
    }

    list.innerHTML = notifications.map(notif => `
        <div class="notification-item ${notif.id ? 'unread' : ''}" onclick="handleNotificationClick(${notif.id}, '${notif.action_url}')">
            <div class="notification-icon ${notif.color}">
                <i class="fas ${notif.icon}"></i>
            </div>
            <div class="notification-content">
                <h6>${notif.title}</h6>
                <p>${notif.message}</p>
                <small class="notification-time">${notif.created_at}</small>
            </div>
        </div>
    `).join('');

    // Load unread count for badge
    updateUnreadCount();
}

function handleNotificationClick(notificationId, actionUrl) {
    markAsRead(notificationId);
    if (actionUrl && actionUrl !== 'null') {
        window.location.href = actionUrl;
    }
}

function markAsRead(notificationId) {
    fetch(`/admin/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotifications();
            }
        })
        .catch(error => console.error('Error marking notification as read:', error));
}

function markAllAsRead() {
    fetch('{{ route("admin.notifications.markAllAsRead") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotifications();
            }
        })
        .catch(error => console.error('Error marking all as read:', error));
}

function updateUnreadCount() {
    fetch('{{ route("admin.notifications.getUnreadCount") }}')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notificationBadge');
            if (data.unreadCount > 0) {
                badge.textContent = data.unreadCount;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        });
}

// Load notifications on page load
document.addEventListener('DOMContentLoaded', function() {
    updateUnreadCount();
    // Refresh unread count every 30 seconds
    setInterval(updateUnreadCount, 30000);
});

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const container = document.querySelector('.notification-container');
    const dropdown = document.getElementById('notificationDropdown');
    
    if (!container.contains(event.target) && dropdown.style.display === 'block') {
        dropdown.style.display = 'none';
    }
});
</script>
