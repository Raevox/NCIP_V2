@extends('layouts.admin')

@section('title', 'COC Application History')

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

.back-btn {
    background: var(--primary-green);
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.back-btn:hover {
    background: var(--primary-green-hover);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(62, 123, 39, 0.3);
}

.applicant-info-card {
    background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-hover) 100%);
    color: white;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 24px;
}

.applicant-info-card .avatar-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 32px;
    border: 4px solid rgba(255, 255, 255, 0.3);
}

.applicant-info-card h3 {
    font-size: 24px;
    font-weight: 700;
    margin: 0;
}

.applicant-info-card .info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    opacity: 0.95;
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
    background: #3E7B27 !important;
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

.status-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    display: inline-block;
}

.status-approved {
    background: #d4edda;
    color: #155724;
}

.status-returned {
    background: #f8d7da;
    color: #721c24;
}

.status-admin {
    background: #fff3cd;
    color: #856404;
}

.status-review {
    background: #d1ecf1;
    color: #0c5460;
}

.status-default {
    background: #e9ecef;
    color: #495057;
}

.action-btn {
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s ease;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-view {
    background: var(--primary-green);
    color: white;
}

.btn-view:hover {
    background: var(--primary-green-hover);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(62, 123, 39, 0.3);
}

.btn-locked {
    background: #e9ecef;
    color: #6c757d;
    cursor: not-allowed;
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

.stats-badge {
    background: var(--primary-green-light);
    color: var(--primary-green);
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
</style>

<div class="main">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="header">
            <h2>
                <i class="fas fa-history me-2" style="color: var(--primary-green);"></i>
                COC Application History
            </h2>
        </div>
        <a href="{{ route('admin.applicants.accounts') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Back to Accounts
        </a>
    </div>

    {{-- Applicant Info Card --}}
    <div class="applicant-info-card">
        <div class="d-flex align-items-center gap-4">
            <div class="avatar-circle">
                {{ strtoupper(substr($applicant->first_name, 0, 1)) }}{{ strtoupper(substr($applicant->last_name, 0, 1)) }}
            </div>
            <div class="flex-grow-1">
                <h3 class="mb-2">{{ $applicant->first_name }} {{ $applicant->last_name }}</h3>
                <div class="d-flex flex-wrap gap-3">
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <span>{{ $applicant->email ?? 'No email' }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-users"></i>
                        <span>{{ $applicant->tribe ?? 'No tribe info' }}</span>
                    </div>
                </div>
            </div>
            <div class="stats-badge bg-white text-dark">
                <i class="fas fa-file-alt"></i>
                <span>{{ $applications->count() }} Application(s)</span>
            </div>
        </div>
    </div>

    {{-- History Table --}}
    <div class="custom-table">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th class="text-center" style="width: 80px;">#</th>
                    <th>Submitted Date</th>
                    <th class="text-center">Status</th>
                    <th class="text-center" style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $index => $app)
                <tr>
                    <td class="text-center">
                        <span class="fw-bold" style="color: var(--primary-green);">{{ $index + 1 }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-calendar-alt" style="color: var(--primary-green);"></i>
                            <div>
                                <div class="fw-semibold">
                                    {{ $app->submitted_at?->format('M d, Y') ?? 'Not submitted' }}
                                </div>
                                @if($app->submitted_at)
                                <small class="text-muted">{{ $app->submitted_at->format('h:i A') }}</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        @php
                            $statusClass = match($app->coc_status) {
                                'Approved' => 'status-approved',
                                'Admin Approval' => 'status-admin',
                                'Under Review' => 'status-review',
                                'Returned' => 'status-returned',
                                default => 'status-default'
                            };
                        @endphp
                        <span class="status-badge {{ $statusClass }}">
                            {{ $app->coc_status ?? 'Draft' }}
                        </span>
                    </td>
                    <td class="text-center">
                        @if($app->coc_status === 'Approved')
                            <a href="{{ route('admin.applicants.coc.view', $app->id) }}" 
                               class="action-btn btn-view">
                                <i class="fas fa-eye"></i>
                                View COC
                            </a>
                        @else
                            <button class="action-btn btn-locked" disabled>
                                <i class="fas fa-lock"></i>
                                Locked
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>No COC applications found for this applicant.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
