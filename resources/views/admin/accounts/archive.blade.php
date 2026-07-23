@extends('layouts.admin')

@section('title', 'Archived Records')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root {
    --primary-green: #3E7B27;
    --primary-green-hover: #2f5f1e;
    --primary-green-light: #f0f7ed;
}

.header {
    margin-bottom: 32px;
}

.header h2 {
    font-size: 28px;
    font-weight: 600;
    color: #222;
    margin: 0;
}

.search-card {
    margin-bottom: 20px;
}

.search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    background: white;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    padding: 0 12px;
    transition: all 0.2s ease;
}

.search-wrapper:focus-within {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(62, 123, 39, 0.1);
}

.search-icon {
    color: #999;
    margin-right: 8px;
    font-size: 14px;
}

.search-wrapper .form-control {
    border: none;
    padding: 10px 0;
    font-size: 14px;
    background: transparent;
    box-shadow: none;
}

.search-wrapper .form-control:focus {
    box-shadow: none;
    outline: none;
}

.search-wrapper .form-control::placeholder {
    color: #999;
}

.custom-tabs {
    background: #fff;
    border-radius: 10px;
    padding: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 24px;
    display: flex;
    gap: 8px;
}

.custom-tab {
    padding: 12px 24px;
    border-radius: 6px;
    border: none;
    background: transparent;
    color: #222;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.2s ease;
    cursor: pointer;
}

.custom-tab:hover {
    background: #f8f9fa;
    color: var(--primary-green);
}

.custom-tab.active {
    background: var(--primary-green);
    color: white;
}

.custom-table {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
}

.custom-table thead {
    background: var(--primary-green);
}

.custom-table thead th {
    color: white !important;
    font-weight: 600;
    padding: 16px 12px;
    font-size: 14px;
    border: none;
    background: var(--primary-green) !important;
}

.custom-table tbody tr {
    border-bottom: 1px solid #f0f0f0;
    transition: background 0.2s ease;
}

.custom-table tbody tr:hover {
    background: #f8fdf5;
}

.custom-table tbody td {
    padding: 16px 12px;
    vertical-align: middle;
    font-size: 14px;
}

.btn-restore {
    background: var(--primary-green);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-restore:hover {
    background: var(--primary-green-hover);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(62, 123, 39, 0.3);
}

.empty-state {
    text-align: center;
    padding: 48px 20px;
}

.empty-state i {
    font-size: 64px;
    color: #dee2e6;
    margin-bottom: 16px;
}

.empty-state p {
    color: #6c757d;
    font-size: 16px;
    margin: 0;
}

.alert-success {
    background: var(--primary-green-light);
    border: 2px solid var(--primary-green);
    border-radius: 10px;
    color: var(--primary-green);
    padding: 16px;
    margin-bottom: 24px;
}

.alert-success .btn-close {
    filter: brightness(0) saturate(100%) invert(27%) sepia(45%) saturate(1036%) hue-rotate(72deg);
}

.modal-header {
    background: var(--primary-green);
    color: white;
    border-bottom: none;
}

.modal-header .btn-close {
    filter: brightness(0) invert(1);
}

.modal-footer .btn-secondary {
    background: #6c757d;
    border: none;
}

.modal-footer .btn-danger {
    background: #dc3545;
    border: none;
}
</style>

<div class="main">
    <!-- Header -->
    <div class="header">
        <h2>
            <i class="fas fa-archive me-2" style="color: var(--primary-green);"></i>
            Archived Records
        </h2>
    </div>

    <!-- Flash Success -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search Card (Above Tabs) -->
    <div class="search-card" style="max-width: 300px;">
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" 
                   id="searchInput" 
                   class="form-control" 
                   placeholder="Search...">
        </div>
    </div>

    <!-- Custom Tabs -->
    <div class="custom-tabs">
        <button class="custom-tab active" onclick="showTab('ip-records', this)">
            <i class="fas fa-users me-1"></i> IP Records
        </button>
        <button class="custom-tab" onclick="showTab('staff-admin', this)">
            <i class="fas fa-user-tie me-1"></i> Staff & Admin Accounts
        </button>
        <button class="custom-tab" onclick="showTab('ip-accounts', this)">
            <i class="fas fa-user-circle me-1"></i> Applicant Accounts
        </button>
    </div>

    <div class="tab-content">
        <!-- Archived IP Records -->
        <div class="tab-pane active" id="ip-records">
            <div class="custom-table">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Present Address</th>
                            <th>IP Group</th>
                            <th>Date Archived</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records ?? [] as $record)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $record->first_name }} {{ $record->last_name }}</div>
                                </td>
                                <td>{{ $record->barangay }}, {{ $record->municipality }}, {{ $record->province }}</td>
                                <td>
                                    <span class="badge" style="background: var(--primary-green-light); color: var(--primary-green); padding: 6px 12px; border-radius: 6px;">
                                        {{ $record->ip_group }}
                                    </span>
                                </td>
                                <td>
                                    <div style="color: var(--primary-green); font-weight: 500;">
                                        {{ $record->deleted_at ? $record->deleted_at->format('M d, Y') : '' }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.archive.ip_records.restore', $record->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-restore">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p>No archived IP records found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $records->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <!-- Archived Staff & Admin Accounts -->
        <div class="tab-pane" id="staff-admin" style="display: none;">
            <div class="custom-table">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Date Archived</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staffAdminAccounts ?? [] as $account)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $account->first_name }} {{ $account->last_name }}</div>
                                </td>
                                <td>{{ $account->email }}</td>
                                <td>
                                    <span class="badge" style="background: var(--primary-green-light); color: var(--primary-green); padding: 6px 12px; border-radius: 6px;">
                                        {{ ucfirst($account->role) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="color: var(--primary-green); font-weight: 500;">
                                        {{ $account->deleted_at ? $account->deleted_at->format('M d, Y') : '' }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.archive.accounts.restore', ['type' => $account->role, 'id' => $account->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-restore">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p>No archived staff/admin accounts.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $staffAdminAccounts->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <!-- Archived Applicant Accounts -->
        <div class="tab-pane" id="ip-accounts" style="display: none;">
            <div class="custom-table">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Tribe</th>
                            <th>Date Archived</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ipAccounts ?? [] as $account)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $account->first_name }} {{ $account->last_name }}</div>
                                </td>
                                <td>{{ $account->email }}</td>
                                <td>
                                    <span class="badge" style="background: var(--primary-green-light); color: var(--primary-green); padding: 6px 12px; border-radius: 6px;">
                                        {{ $account->tribe ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <div style="color: var(--primary-green); font-weight: 500;">
                                        {{ $account->deleted_at ? $account->deleted_at->format('M d, Y') : '' }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.archive.accounts.restore', ['type' => 'applicant', 'id' => $account->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-restore">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p>No archived applicant accounts found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $ipAccounts->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Archive Confirmation Modal -->
<div class="modal fade" id="archiveModal" tabindex="-1" aria-labelledby="archiveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="archiveModalLabel">
                    <i class="fas fa-archive me-2"></i>Confirm Archive
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="archiveModalBody"></p>
                <small class="text-muted">This action won't delete the record permanently. It can be restored later.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="archiveForm" method="POST" action="" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-archive me-1"></i>Archive
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
let currentTab = 'ip-records';

function showTab(tabId, button) {
    // Hide all tab panes
    document.querySelectorAll('.tab-pane').forEach(pane => {
        pane.style.display = 'none';
        pane.classList.remove('active');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.custom-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Show selected tab pane
    const selectedPane = document.getElementById(tabId);
    if (selectedPane) {
        selectedPane.style.display = 'block';
        selectedPane.classList.add('active');
    }
    
    // Add active class to clicked tab
    button.classList.add('active');
    
    // Update current tab
    currentTab = tabId;
    
    // Clear search when switching tabs
    document.getElementById('searchInput').value = '';
    clearSearch();
}

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    let searchTimeout;
    
    searchInput.addEventListener('keyup', function() {
        clearTimeout(searchTimeout);
        const query = this.value.toLowerCase();
        
        searchTimeout = setTimeout(() => {
            performSearch(query);
        }, 300);
    });
    
    function performSearch(query) {
        const currentTable = document.querySelector(`#${currentTab} tbody`);
        if (!currentTable) return;
        
        const rows = currentTable.querySelectorAll('tr');
        let visibleCount = 0;
        
        rows.forEach(row => {
            if (row.querySelector('.empty-state')) return;
            
            const text = row.textContent.toLowerCase();
            if (text.includes(query) || query === '') {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Show empty state if no results
        const emptyRow = currentTable.querySelector('tr:has(.empty-state)');
        if (visibleCount === 0 && !emptyRow) {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td colspan="5">
                    <div class="empty-state">
                        <i class="fas fa-search"></i>
                        <p>No results found.</p>
                    </div>
                </td>
            `;
            currentTable.appendChild(newRow);
        }
    }
    
    function clearSearch() {
        const currentTable = document.querySelector(`#${currentTab} tbody`);
        if (!currentTable) return;
        
        const rows = currentTable.querySelectorAll('tr');
        rows.forEach(row => {
            row.style.display = '';
        });
    }
});

// Archive Modal Handler
document.addEventListener('DOMContentLoaded', function () {
    var archiveModal = new bootstrap.Modal(document.getElementById('archiveModal'));
    var archiveBody = document.getElementById('archiveModalBody');
    var archiveForm = document.getElementById('archiveForm');

    document.querySelectorAll('.archive-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var name = this.getAttribute('data-name');
            var url = this.getAttribute('data-url');
            
            archiveBody.textContent = `Are you sure you want to move ${name} to the archive?`;
            archiveForm.action = url;

            archiveModal.show();
        });
    });
});
</script>

@endsection
