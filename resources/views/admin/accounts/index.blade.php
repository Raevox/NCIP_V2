@extends('layouts.admin')

@section('title', 'Accounts')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
<style>
:root {
    --primary-green: #3E7B27;
    --primary-green-hover: #2f5f1e;
    --primary-green-light: #f0f7ed;
}
body, .account-content {
    font-family: 'Poppins', sans-serif;
    background-color: #fff;
    color: var(--text-dark);
    margin: 10px;
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

.shadow-box {
    background: #fff; 
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.search-wrapper {
    position: relative;
    width: 350px;
}

.search-wrapper input {
    padding-left: 40px;
    border: 2px solid #e5e5e5;
    transition: all 0.3s ease;
}

.search-wrapper input:focus {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(62, 123, 39, 0.1);
}

.search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    pointer-events: none;
}
.custom-table table th {
    color: #fff !important;
    font-size: 14px !important;
    background: #2E7D46 !important;
}

.add-btn {
    padding: 10px 24px;
    border-radius: 8px;
    background: var(--primary-green);
    color: white;
    border: none;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s ease;
}

.add-btn:hover {
    background: var(--primary-green-hover);
    color: white;
}

.custom-table {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
}

.custom-table thead {
    background: var(--primary-green);
}

.custom-table thead th {
    color: white;
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

.avatar-circle {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-hover) 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
    flex-shrink: 0;
}

.status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.status-active {
    background: #d4edda;
    color: #155724;
}

.status-inactive {
    background: #f8d7da;
    color: #721c24;
}

.action-btn {
     border: none;
    background: none;
    color: #6c757d;
    padding: 4px 8px;
    cursor: pointer;
}

.action-btn:hover {
     background: #f8f9fa;
    border-radius: 5px;
}

.dropdown-menu {
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
    border-radius: 10px;
    padding: 8px;
}

.dropdown-item {
    padding: 10px 14px;
    border-radius: 6px;
    font-size: 14px;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background: var(--primary-green-light);
    color: var(--primary-green);
}

.dropdown-item.text-success:hover {
    background: #d4edda;
    color: #155724;
}

.dropdown-item.text-danger:hover {
    background: #fee;
    color: #dc3545;
}

.dropdown-item i {
    width: 20px;
}

@media (max-width: 768px) {
    .search-wrapper {
        width: 100%;
    }
}

</style>

<div class="account-content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="header">
       <h2><i class="fas fa-user-shield me-2" style="color:#3E7B27;"></i>Accounts Management</h2>
    </div>

    {{-- Top Controls --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3 shadow-box">
        <div class="search-wrapper">
            <form action="{{ route('admin.accounts.index') }}" method="GET">
                <i class="fas fa-search search-icon"></i>
                <input type="text" 
                       name="search" 
                       class="form-control"
                       placeholder="Search by name or email..." 
                       value="{{ request('search') }}">
            </form>
        </div>
        
        <a href="{{ route('admin.accounts.create') }}" class="add-btn">
            <i class="fas fa-plus me-2"></i>Add New
        </a>
    </div>

    {{-- Table --}}
    <div class="custom-table">
        <table class="table table-striped ip-table">
        {{-- <table class="table mb-0"> --}}
            <thead>
                <tr>
                    <th class="ps-4">Name</th>
                    <th>Email</th>
                    <th class="text-center">Role</th>
                    <th class="text-center">Status</th>
                    <th class="text-center pe-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($accounts as $account)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle">
                                    {{ strtoupper(substr($account->first_name, 0, 1)) }}{{ strtoupper(substr($account->last_name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $account->first_name }} {{ $account->last_name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-muted">{{ $account->email }}</span>
                        </td>
                        <td class="text-center">
                            <span class="fw-medium" style="color: var(--primary-green);">{{ $account->role ?? 'Staff' }}</span>
                        </td>
                        <td class="text-center">
                            @if(strtolower($account->status ?? '') === 'active')
                                <span class="status-badge status-active">Active</span>
                            @else
                                <span class="status-badge status-inactive">Inactive</span>
                            @endif
                        </td>
                        <td class="text-center pe-4">
                            <div class="dropdown">
                                <button class="action-btn" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a href="{{ route('admin.accounts.show', $account) }}" class="dropdown-item">
                                            <i class="fas fa-eye"></i>View
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.accounts.edit', $account) }}" class="dropdown-item text-success">
                                            <i class="fas fa-edit"></i>Edit
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#archiveModal{{ $account->id }}">
                                            <i class="fas fa-archive"></i>Archive
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            {{-- Archive Modal --}}
                            <div class="modal fade" id="archiveModal{{ $account->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-dark">
                                            <h5 class="modal-title">
                                                <i class="fas fa-exclamation-triangle me-2"></i>Confirm Archive
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="mb-3">Are you sure you want to move <strong>{{ $account->first_name }} {{ $account->last_name }}</strong> to the archive?</p>
                                            <small class="text-muted">This action won't delete the account permanently. It can be restored later.</small>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('admin.accounts.destroy', $account->id) }}" method="POST" style="display: inline;">
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
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                            <p class="mb-0">No accounts found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $accounts->links('pagination::bootstrap-4') }}
    </div>
</div>

@endsection
