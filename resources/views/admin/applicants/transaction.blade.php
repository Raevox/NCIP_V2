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
    justify-content: center;
    gap: 6px;
    white-space: nowrap;
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

.btn-documents {
    background: #fff;
    color: var(--primary-green);
    border: 1px solid var(--primary-green);
}

.btn-documents:hover {
    background: var(--primary-green-light);
    color: var(--primary-green-hover);
    border-color: var(--primary-green-hover);
}

.document-count {
    min-width: 20px;
    padding: 1px 6px;
    border-radius: 10px;
    background: var(--primary-green);
    color: #fff;
    font-size: 11px;
    line-height: 18px;
}

.no-files {
    color: #6c757d;
    font-size: 13px;
    white-space: nowrap;
}

.document-list {
    display: grid;
    gap: 10px;
}

.document-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    color: #212529;
    text-decoration: none;
}

.document-link:hover {
    border-color: var(--primary-green);
    background: var(--primary-green-light);
    color: var(--primary-green-hover);
}

.document-link > i:first-child {
    width: 22px;
    color: var(--primary-green);
    text-align: center;
    font-size: 18px;
}

.document-link .document-details {
    min-width: 0;
    flex: 1;
}

.document-link .document-name,
.document-link .document-file-name {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.document-link .document-name {
    font-weight: 600;
}

.document-link .document-file-name {
    color: #6c757d;
    font-size: 12px;
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
            <div class="d-flex flex-column align-items-end gap-2">
                <div class="stats-badge bg-white text-dark">
                    <i class="fas fa-file-alt"></i>
                    <span>{{ $applications->count() }} Application(s)</span>
                </div>
                @if(!empty($applicant->document_path))
                    <a href="{{ asset('storage/' . $applicant->document_path) }}" target="_blank" rel="noopener noreferrer" class="text-white small fw-semibold">
                        <i class="fas fa-id-card me-1"></i>
                        View Registration Document
                    </a>
                @endif
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
                    <th class="text-center" style="width: 180px;">Documents</th>
                    <th class="text-center" style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $index => $app)
                @php
                    $submissionDocuments = collect([
                        ['name' => 'Applicant Picture', 'path' => $app->applicant_picture, 'icon' => 'fas fa-image'],
                        ['name' => 'Tribal Certificate', 'path' => $app->tribal_certificate, 'icon' => 'fas fa-certificate'],
                        ['name' => 'Birth Certificate', 'path' => $app->birth_certificate, 'icon' => 'fas fa-file-medical'],
                        ['name' => 'Genealogy Form', 'path' => $app->genealogy_form, 'icon' => 'fas fa-sitemap'],
                    ])->filter(fn ($document) => !empty($document['path']))->values();
                @endphp
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
                        @if($submissionDocuments->isNotEmpty())
                            <button type="button" class="action-btn btn-documents" data-bs-toggle="modal" data-bs-target="#documentsModal{{ $app->id }}" aria-label="View documents for application {{ $app->id }}">
                                <i class="fas fa-folder-open"></i>
                                View Files
                                <span class="document-count">{{ $submissionDocuments->count() }}</span>
                            </button>
                        @else
                            <span class="no-files"><i class="fas fa-folder-minus me-1"></i>No files</span>
                        @endif
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
                    <td colspan="5">
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

    @foreach($applications as $app)
        @php
            $submissionDocuments = collect([
                ['name' => 'Applicant Picture', 'path' => $app->applicant_picture, 'icon' => 'fas fa-image'],
                ['name' => 'Tribal Certificate', 'path' => $app->tribal_certificate, 'icon' => 'fas fa-certificate'],
                ['name' => 'Birth Certificate', 'path' => $app->birth_certificate, 'icon' => 'fas fa-file-medical'],
                ['name' => 'Genealogy Form', 'path' => $app->genealogy_form, 'icon' => 'fas fa-sitemap'],
            ])->filter(fn ($document) => !empty($document['path']))->values();
        @endphp

        @if($submissionDocuments->isNotEmpty())
            <div class="modal fade" id="documentsModal{{ $app->id }}" tabindex="-1" aria-labelledby="documentsModalLabel{{ $app->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title" id="documentsModalLabel{{ $app->id }}">Uploaded Documents</h5>
                                <small class="text-muted">Application #{{ $app->id }} &middot; {{ $app->submitted_at?->format('M d, Y') ?? 'Not submitted' }}</small>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="document-list">
                                @foreach($submissionDocuments as $document)
                                    <a href="{{ asset('storage/' . $document['path']) }}" target="_blank" rel="noopener noreferrer" class="document-link">
                                        <i class="{{ $document['icon'] }}"></i>
                                        <span class="document-details">
                                            <span class="document-name">{{ $document['name'] }}</span>
                                            <span class="document-file-name">{{ basename($document['path']) }}</span>
                                        </span>
                                        <i class="fas fa-external-link-alt text-muted"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>

@endsection
