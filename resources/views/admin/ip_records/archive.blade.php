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
    background: #2E7D46 !important;
}

.custom-table thead th {
    color: white !important;
    font-weight: 600;
    padding: 16px 12px;
    font-size: 14px;
    border: none;
    
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
                        @forelse($records as $record)
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
                                    <form action="{{ route('admin.archive.ip_records.restore', $record->id) }}" method="POST" style="display: inline;">
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
                        @forelse($staffAdminAccounts as $account)
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
                                    <form action="{{ route('admin.archive.accounts.restore', $account->id) }}" method="POST" style="display: inline;">
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
                        @forelse($ipAccounts as $account)
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
                                    <form action="{{ route('admin.archive.accounts.restore', $account->id) }}" method="POST" style="display: inline;">
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

<script>
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
}
</script>

@endsection
