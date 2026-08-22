@extends('layouts.admin')

@section('title', 'Applicants')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --green-900: #1a3d0f;
    --green-700: #2d6a1f;
    --green-500: #2E7D46;;
    --green-400: #52a033;
    --green-300: #7cc05a;
    --green-100: #e8f5e2;
    --green-50:  #f4fbf0;

    --sand-100: #f7f5f0;
    --sand-200: #ede9e0;

    --text-dark: #1a1f16;
    --text-mid:  #4a5245;
    --text-soft: #8a9485;

    --white: #ffffff;
    --shadow-sm: 0 1px 4px rgba(30,60,20,0.07);
    --shadow-md: 0 4px 18px rgba(30,60,20,0.10);

    --radius-sm: 8px;
    --radius-md: 14px;
}

*, *::before, *::after {
    margin: 0; padding: 0;
    box-sizing: border-box;
}

body, .applicants-content {
    font-family: 'Poppins', sans-serif;
    background-color: #fff;
    color: var(--text-dark);
    margin:10px;
}



/* ── Page Header ─────────────────────────── */
.page-header {
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}

.page-header h2 {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 10px;
    letter-spacing: -0.3px;
}

.page-header h2 .header-icon {
    width: 38px; height: 38px;
    background: var(--green-500);
    color: #fff;
    border-radius: var(--radius-sm);
    display: grid;
    place-items: center;
    font-size: 16px;
    flex-shrink: 0;
}

/* ── Controls Bar ────────────────────────── */
.controls-bar {
    background: var(--white);
    border: 1px solid var(--sand-200);
    border-radius: var(--radius-md);
    padding: 14px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 16px;
    box-shadow: var(--shadow-sm);
    flex-wrap: wrap;
}

.search-wrapper {
    position: relative;
    width: 320px;
}

.search-wrapper input {
    width: 100%;
    padding: 9px 14px 9px 38px;
    border: 1.5px solid var(--sand-200);
    border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 13.5px;
    color: var(--text-dark);
    background: var(--sand-100);
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
}

.search-wrapper input:focus {
    border-color: var(--green-400);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(62,123,39,0.10);
}

.search-wrapper input::placeholder {
    color: var(--text-soft);
}

.search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-soft);
    font-size: 13px;
    pointer-events: none;
}

.search-spinner {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
}

/* View Switcher */
.view-switcher {
    display: flex;
    gap: 6px;
    background: var(--sand-100);
    padding: 5px;
    border-radius: var(--radius-sm);
    border: 1px solid var(--sand-200);
}

.view-btn {
    padding: 7px 18px;
    border-radius: 6px;
    border: none;
    background: transparent;
    color: var(--text-mid);
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.18s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    white-space: nowrap;
}

.view-btn:hover {
    background: var(--white);
    color: var(--green-500);
}

.view-btn.active {
    background: var(--green-500);
    color: var(--white);
    box-shadow: 0 2px 8px rgba(62,123,39,0.2);
}

/* ── Tab + Stats Row ─────────────────────── */
.tab-stats-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 16px;
}

.tab-navigation {
    display: flex;
    gap: 6px;
    background: var(--white);
    padding: 6px;
    border-radius: var(--radius-sm);
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--sand-200);
    flex-wrap: wrap;
}

.tab-btn {
    padding: 8px 20px;
    border-radius: 6px;
    border: none;
    background: transparent;
    color: var(--text-mid);
    font-family: 'DM Sans', sans-serif;
    font-weight: 600;
    font-size: 13px;
    transition: all 0.18s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    cursor: pointer;
    white-space: nowrap;
}

.tab-btn:hover {
    background: var(--green-50);
    color: var(--green-500);
}

.tab-btn.active {
    background: var(--green-500);
    color: var(--white);
    box-shadow: 0 2px 8px rgba(62,123,39,0.2);
}

.tab-btn .tab-count {
    background: rgba(255,255,255,0.25);
    color: inherit;
    font-size: 11px;
    padding: 1px 7px;
    border-radius: 20px;
    font-weight: 700;
}

.tab-btn:not(.active) .tab-count {
    background: var(--sand-200);
    color: var(--text-soft);
}

.tab-dot {
    width: 8px;
    height: 8px;
    background-color: #ef4444;
    border-radius: 50%;
    margin-left: 4px;
    display: inline-block;
    flex-shrink: 0;
    box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.3);
    animation: pulse-tab-dot 2s infinite ease-in-out;
}
.tab-btn.active .tab-dot {
    box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.6);
    background-color: #ff4d4f;
}
.tab-dot:not(.show) {
    display: none !important;
}

@keyframes pulse-tab-dot {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.25); opacity: 0.85; }
}

.stats-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--white);
    border: 1px solid var(--sand-200);
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-mid);
    box-shadow: var(--shadow-sm);
    white-space: nowrap;
}

.stats-pill i {
    color: var(--green-500);
}

.stats-pill strong {
    color: var(--green-500);
    font-family: 'DM Mono', monospace;
}

/* ── Table Card ──────────────────────────── */
.table-card {
    background: var(--white);
    border-radius: var(--radius-md);
    border: 1px solid var(--sand-200);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.table-scroll {
    overflow-x: auto;
}

.applicants-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 900px;
}

.account-table {
    margin: 0;
    width: 100%;
}

.account-table thead th {
    background-color: #2E7D46;
    color: #fff;
    font-weight: 600;
    padding: 16px 12px;
    border: none;
    font-size: 14px;
}

.account-table tbody td {
    padding: 16px 12px;
    vertical-align: middle;
    font-size: 14px;
    border-bottom: 1px solid #f0f0f0;
}

.account-table tbody tr {
    transition: background 0.2s ease;
}

.account-table tbody tr:hover {
    background: #f8fdf5;
}
/* .applicants-table thead tr {
    background: var(--green-500);
}

.applicants-table thead th {
    padding: 13px 16px;
    text-align: left;
    font-size: 11.5px;
    font-weight: 700;
    color: rgba(255,255,255,0.90);
    text-transform: uppercase;
    letter-spacing: 0.7px;
    border: none;
    white-space: nowrap;
}

.applicants-table thead th.text-center {
    text-align: center;
}

.applicants-table tbody tr {
    border-bottom: 1px solid var(--sand-100);
    transition: background 0.15s;
}

.applicants-table tbody tr:last-child {
    border-bottom: none;
}

.applicants-table tbody tr:hover {
    background: var(--green-50);
}

.applicants-table tbody td {
    padding: 14px 16px;
    font-size: 13.5px;
    color: var(--text-dark);
    vertical-align: middle;
}

.applicants-table tbody td.text-center {
    text-align: center;
} */

/* Avatar */
.applicant-cell {
    display: flex;
    align-items: center;
    gap: 11px;
}

.applicant-cell-clickable {
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 6px 8px;
    border-radius: var(--radius-sm);
}

.applicant-cell-clickable:hover {
    background-color: rgba(46, 125, 70, 0.08);
}

.applicant-cell-clickable:hover .applicant-name {
    color: var(--green-500);
    text-decoration: underline;
}

.applicant-cell-clickable:hover .applicant-avatar {
    transform: scale(1.06);
    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
}

.applicant-avatar {
    width: 38px; height: 38px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--green-400), var(--green-700));
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    display: grid;
    place-items: center;
    flex-shrink: 0;
    letter-spacing: 0.5px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.applicant-name {
    font-weight: 600;
    color: var(--text-dark);
    font-size: 13.5px;
    line-height: 1.3;
    transition: color 0.2s ease;
}

.applicant-email {
    font-size: 12px;
    color: var(--text-soft);
    margin-top: 2px;
}

/* Date */
.date-val {
    font-family: 'DM Mono', monospace;
    font-size: 12.5px;
    color: var(--green-500);
    font-weight: 500;
}

/* Info badge */
.info-badge {
    display: inline-block;
    background: var(--green-100);
    color: var(--green-700);
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 600;
    white-space: nowrap;
    margin: 2px;
}

/* Purpose list */
.purpose-list {
    list-style: none;
    padding: 0; margin: 0;
    font-size: 12.5px;
    text-align: left;
    display: inline-block;
}

.purpose-list li {
    padding: 2px 0;
    display: flex;
    align-items: baseline;
    gap: 5px;
    color: var(--text-mid);
}

.purpose-list li::before {
    content: '•';
    color: var(--green-400);
    font-weight: 700;
    flex-shrink: 0;
}

/* Address */
.address-text {
    font-size: 12.5px;
    line-height: 1.5;
    color: var(--text-mid);
    text-align: center;
}

/* Status badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 600;
    white-space: nowrap;
}

.status-badge::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
}

.status-approved        { background: #ecfdf5; color: #065f46; }
.status-approved::before { background: #10b981; }

.status-returned        { background: #fef2f2; color: #991b1b; }
.status-returned::before { background: #ef4444; }

.status-admin           { background: #fffbeb; color: #92400e; }
.status-admin::before   { background: #f59e0b; }

.status-default         { background: #f1f5f9; color: #475569; }
.status-default::before { background: #94a3b8; }

/* ── Action Buttons ──────────────────────── */
.action-cell {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    flex-wrap: wrap;
}

.btn-transaction {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 13px;
    border-radius: var(--radius-sm);
    border: 1.5px solid var(--sand-200);
    background: var(--white);
    color: var(--text-mid);
    font-family: 'DM Sans', sans-serif;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.18s;
    cursor: pointer;
    white-space: nowrap;
}

.btn-transaction:hover {
    border-color: var(--green-300);
    color: var(--green-500);
    background: var(--green-50);
}

.btn-transaction i {
    font-size: 11px;
}

.btn-approve {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 13px;
    border-radius: var(--radius-sm);
    border: 1.5px solid #10b981;
    background: #ecfdf5;
    color: #065f46;
    font-family: 'DM Sans', sans-serif;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.18s;
    white-space: nowrap;
}

.btn-approve:hover {
    background: #10b981;
    color: var(--white);
    border-color: #10b981;
}

.btn-approve i {
    font-size: 11px;
}

/* ── Pagination Area ─────────────────────── */
.pagination-row {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.pagination-info {
    font-size: 13px;
    color: var(--text-soft);
}

/* ── Empty State ─────────────────────────── */
.empty-state {
    padding: 60px 20px;
    text-align: center;
    color: var(--text-soft);
}

.empty-state i {
    font-size: 44px;
    opacity: 0.2;
    margin-bottom: 14px;
    display: block;
}

.empty-state p {
    font-size: 15px;
    font-weight: 500;
}

/* ── Responsive ──────────────────────────── */
@media (max-width: 992px) {
    .tab-stats-row { flex-direction: column; align-items: flex-start; }
}

@media (max-width: 768px) {
    .controls-bar { flex-direction: column; align-items: stretch; }
    .search-wrapper { width: 100%; }
    .view-switcher { justify-content: center; }
}

/* ── Modal Polish ────────────────────────── */
.modal-content {
    border: none;
    border-radius: var(--radius-md);
    overflow: hidden;
    font-family: 'DM Sans', sans-serif;
}

.modal-header {
    border-bottom: none;
    padding: 20px 24px 16px;
}

.modal-body {
    padding: 20px 24px;
}

.modal-footer {
    border-top: 1px solid var(--sand-200);
    padding: 16px 24px;
}

.modal-title {
    font-weight: 700;
    font-size: 16px;
}

.modal-icon {
    width: 64px; height: 64px;
    border-radius: 50%;
    display: grid;
    place-items: center;
    margin: 0 auto 16px;
    font-size: 26px;
}

.modal-icon.success { background: #ecfdf5; color: #10b981; }
.modal-icon.warning { background: #fffbeb; color: #f59e0b; }
.modal-icon.danger  { background: #fef2f2; color: #ef4444; }
</style>

<div class="applicant-content">

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: var(--radius-sm); border: none; font-family: 'DM Sans', sans-serif;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="page-header">
        <h2>
            <span class="header-icon"><i class="fas fa-users"></i></span>
            Applicant Management
        </h2>
    </div>

    {{-- Controls Bar --}}
    <div class="controls-bar">
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input
                type="text"
                id="searchInput"
                placeholder="Search by name or email..."
                value="{{ request('search') }}"
            />
            <div id="searchSpinner" class="search-spinner" style="display:none;">
                <div class="spinner-border spinner-border-sm text-success" role="status">
                    <span class="visually-hidden">Searching...</span>
                </div>
            </div>
        </div>

        <div class="view-switcher">
            <a href="{{ route('admin.applicants.index') }}"
               class="view-btn {{ request()->routeIs('admin.applicants.index') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> Application
            </a>
            <a href="{{ route('admin.applicants.accounts') }}"
               class="view-btn {{ request()->routeIs('admin.applicants.accounts') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Account
            </a>
        </div>
    </div>

    {{-- Tabs + Stats Row --}}
    <div class="tab-stats-row">
        <div class="tab-navigation">
            <a class="tab-btn {{ $status === 'all' ? 'active' : '' }}"
               href="{{ route('admin.applicants.index', ['status' => 'all']) }}">
                All
            </a>
            <a class="tab-btn {{ $status === 'Approved' ? 'active' : '' }}"
               href="{{ route('admin.applicants.index', ['status' => 'Approved']) }}">
                <i class="fas fa-check-circle" style="font-size:11px;"></i> Approved
            </a>
            <a class="tab-btn {{ $status === 'Admin Approval' ? 'active' : '' }}"
               href="{{ route('admin.applicants.index', ['status' => 'Admin Approval']) }}"
               id="tabAdminApproval">
                <i class="fas fa-user-shield" style="font-size:11px;"></i> Admin Approval
                <span class="tab-dot {{ (!empty($applicantBadge['has_under_review'])) ? 'show' : '' }}" id="dotAdminApproval" title="Pending applications awaiting action"></span>
            </a>
            <a class="tab-btn {{ $status === 'Returned' ? 'active' : '' }}"
               href="{{ route('admin.applicants.index', ['status' => 'Returned']) }}"
               id="tabReturned">
                <i class="fas fa-rotate-left" style="font-size:11px;"></i> Returned
                <span class="tab-dot {{ (!empty($applicantBadge['has_unread_returned'])) ? 'show' : '' }}" id="dotReturned" title="New returned items"></span>
            </a>
        </div>

        <div class="stats-pill">
            <i class="fas fa-users"></i>
            <strong id="applicantCount">{{ $applications->total() }}</strong>
            <span>Applicant(s) found</span>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-card">
        {{-- <div class="table-scroll">
            <table class="applicants-table"> --}}
            <div class="table-responsive">
                <table class="table table-striped account-table">
                <thead>
                    <tr>
                        <th>Applicant</th>
                        <th class="text-center">Date Applied</th>
                        <th class="text-center">IP Group</th>
                        <th class="text-center">Endorsement</th>
                        <th class="text-center">Purpose</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="applicantsTableBody">
                    @forelse($applications as $coc)
                        @php
                            $step1 = json_decode($coc->step1, true);
                            $fn = $coc->applicant->first_name ?? '';
                            $ln = $coc->applicant->last_name ?? '';
                            $fullName = trim($fn . ' ' . $ln);
                            $initials = strtoupper(substr($fn,0,1) . substr($ln,0,1)) ?: '--';
                            $email = $coc->applicant->email ?? '-';
                            $contact = $coc->applicant->contact ?? 'N/A';
                            $tribe = $coc->applicant->tribe ?? '-';
                            $leader = $coc->applicant->leader ?? '-';
                            $dateApplied = $coc->created_at?->format('M d, Y') ?? '-';
                            $status = $coc->coc_status ?? 'Pending';
                            $transactionUrl = route('admin.applicants.transaction', $coc->applicant->id ?? $coc->id);

                            $addressStr = '';
                            if(!empty($step1)) {
                                $parts = array_filter([
                                    ucwords(strtolower($step1['barangay_name'] ?? '')),
                                    ucwords(strtolower($step1['municipality_name'] ?? '')),
                                    ucwords(strtolower($step1['province_name'] ?? ''))
                                ]);
                                $addressStr = implode(', ', $parts);
                            } else {
                                $addressStr = $coc->applicant->address ?? '-';
                            }

                            $purposeStr = '';
                            if(!empty($step1['purpose'])) {
                                $purposeStr = is_array($step1['purpose']) ? implode(', ', $step1['purpose']) : $step1['purpose'];
                                if(!empty($step1['purpose_others'])) {
                                    $purposeStr .= ' (Other: ' . $step1['purpose_others'] . ')';
                                }
                            } else {
                                $purposeStr = '-';
                            }

                            $documents = [];
                            if (!empty($coc->applicant_picture)) {
                                $documents[] = ['name' => 'Applicant Picture', 'url' => asset('storage/' . $coc->applicant_picture), 'icon' => 'fas fa-image'];
                            }
                            if (!empty($coc->tribal_certificate)) {
                                $documents[] = ['name' => 'Tribal Certificate', 'url' => asset('storage/' . $coc->tribal_certificate), 'icon' => 'fas fa-certificate'];
                            }
                            if (!empty($coc->birth_certificate)) {
                                $documents[] = ['name' => 'Birth Certificate', 'url' => asset('storage/' . $coc->birth_certificate), 'icon' => 'fas fa-file-medical'];
                            }
                            if (!empty($coc->genealogy_form)) {
                                $documents[] = ['name' => 'Genealogy Form', 'url' => asset('storage/' . $coc->genealogy_form), 'icon' => 'fas fa-sitemap'];
                            }
                            if (!empty($coc->applicant->document_path)) {
                                $documents[] = ['name' => 'Registration Document', 'url' => asset('storage/' . $coc->applicant->document_path), 'icon' => 'fas fa-file-alt'];
                            }

                            $cocViewUrl = $coc->coc_status === 'Approved' ? route('admin.applicants.coc.view', $coc->id) : null;

                            $profileJson = json_encode([
                                'name' => $fullName,
                                'initials' => $initials,
                                'email' => $email,
                                'contact' => $contact,
                                'tribe' => $tribe,
                                'leader' => $leader,
                                'address' => $addressStr,
                                'purpose' => $purposeStr,
                                'classification' => $coc->classification ?? [],
                                'status' => $status,
                                'date' => $dateApplied,
                                'documents' => $documents,
                                'cocViewUrl' => $cocViewUrl,
                                'transactionUrl' => $transactionUrl
                            ]);
                        @endphp
                        <tr class="applicant-row">
                            {{-- Name --}}
                            <td>
                                <div class="applicant-cell applicant-cell-clickable"
                                     onclick='showApplicantProfileModal({!! htmlspecialchars($profileJson, ENT_QUOTES, "UTF-8") !!})'
                                     title="Click to view applicant profile">
                                    <div class="applicant-avatar">{{ $initials }}</div>
                                    <div>
                                        <div class="applicant-name">{{ $fullName }}</div>
                                        <div class="applicant-email">{{ $email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Date --}}
                            <td class="text-center">
                                <span class="date-val">
                                    {{ $coc->created_at?->format('M d, Y') ?? '-' }}
                                </span>
                            </td>

                            {{-- Tribe --}}
                            <td class="text-center">
                                <span class="info-badge">{{ $coc->applicant->tribe ?? '-' }}</span>
                            </td>

                            {{-- Endorsement --}}
                            <td class="text-center">
                                @if(!empty($coc->classification))
                                    @foreach($coc->classification as $class)
                                        <span class="info-badge">{{ $class }}</span>
                                    @endforeach
                                @else
                                    <span style="color:var(--text-soft);font-size:13px;">—</span>
                                @endif
                            </td>

                            {{-- Purpose --}}
                            <td class="text-center">
                                @if(!empty($step1['purpose']))
                                    <ul class="purpose-list">
                                        @foreach($step1['purpose'] as $p)
                                            <li>{{ $p }}</li>
                                        @endforeach
                                    </ul>
                                    @if(!empty($step1['purpose_others']))
                                        <div style="font-size:12px;color:var(--text-soft);margin-top:4px;">
                                            Other: {{ $step1['purpose_others'] }}
                                        </div>
                                    @endif
                                @else
                                    <span style="color:var(--text-soft);font-size:13px;">—</span>
                                @endif
                            </td>

                            {{-- Address --}}
                            <td class="text-center">
                                <div class="address-text">
                                    @if(!empty($step1))
                                        {{ ucwords(strtolower($step1['province_name'] ?? '')) }},<br>
                                        {{ ucwords(strtolower($step1['municipality_name'] ?? '')) }},<br>
                                        {{ ucwords(strtolower($step1['barangay_name'] ?? '')) }}
                                    @else
                                        {{ $coc->applicant->address ?? '-' }}
                                    @endif
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="text-center">
                                @if($coc->coc_status === 'Approved')
                                    <span class="status-badge status-approved">Approved</span>
                                @elseif($coc->coc_status === 'Returned')
                                    <span class="status-badge status-returned">Returned</span>
                                @elseif($coc->coc_status === 'Admin Approval')
                                    <span class="status-badge status-admin">Admin Approval</span>
                                @else
                                    <span class="status-badge status-default">{{ $coc->coc_status ?? 'Pending' }}</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="text-center">
                                <div class="action-cell">
                                    <a href="{{ route('admin.applicants.transaction', $coc->applicant->id) }}"
                                       class="btn-transaction">
                                        <i class="fas fa-clock-rotate-left"></i> Transaction
                                    </a>
                                    @if($coc->coc_status === 'Admin Approval')
                                        <button type="button"
                                                class="btn-approve"
                                                onclick="showApproveModal('{{ $fn }} {{ $ln }}', '{{ $coc->id }}')">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>No applications found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="pagination-row">
        <div class="pagination-info" id="paginationInfo">
            Showing {{ $applications->firstItem() ?? 0 }} to {{ $applications->lastItem() ?? 0 }}
            of {{ $applications->total() }} entries
        </div>
        <div id="paginationLinks">
            {{ $applications->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

{{-- ── Approve Modal ─────────────────────── --}}
<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: var(--green-500);">
                <h5 class="modal-title text-white">
                    <i class="fas fa-check-circle me-2"></i>Approve Application
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="modal-icon success">
                    <i class="fas fa-user-check"></i>
                </div>
                <h6 class="fw-bold mb-2" style="font-size:16px;">Confirm Approval</h6>
                <p class="mb-1" style="font-size:14px;color:var(--text-mid);">
                    Issue COC to <strong id="approveApplicantName" style="color:var(--text-dark);"></strong>?
                </p>
                <small style="color:var(--text-soft);">A Certificate of Confirmation will be generated for this applicant.</small>
            </div>
            <div class="modal-footer justify-content-center gap-2">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                        style="font-family:'DM Sans',sans-serif;font-weight:600;font-size:13px;border-radius:var(--radius-sm);">
                    Cancel
                </button>
                <button type="button" onclick="submitApproval()"
                        style="background:var(--green-500);color:#fff;border:none;padding:9px 22px;border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-weight:600;font-size:13px;cursor:pointer;transition:background 0.2s;"
                        onmouseover="this.style.background='var(--green-700)'" onmouseout="this.style.background='var(--green-500)'">
                    <i class="fas fa-check me-2"></i>Approve & Issue COC
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ── Result Modal ──────────────────────── --}}
<div class="modal fade" id="resultModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" id="resultModalHeader">
                <h5 class="modal-title" id="resultModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div id="resultModalIcon" class="mb-3"></div>
                <p id="resultModalMessage" style="font-size:14px;color:var(--text-mid);margin:0;"></p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn" id="resultModalBtn" data-bs-dismiss="modal"
                        style="font-family:'DM Sans',sans-serif;font-weight:600;font-size:13px;border-radius:var(--radius-sm);padding:8px 28px;">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ── Loading Modal ─────────────────────── --}}
<div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <div class="spinner-border mb-3" style="color:var(--green-500);" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p style="font-size:14px;color:var(--text-mid);margin:0;">Processing request...</p>
            </div>
        </div>
    </div>
</div>

{{-- ── Applicant Profile Modal ─────────────────────── --}}
<div class="modal fade" id="applicantProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: var(--radius-md); overflow: hidden; border: none; font-family: 'Poppins', sans-serif;">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, var(--green-500) 0%, #1e4d2b 100%); padding: 20px 24px;">
                <div class="d-flex align-items-center gap-3">
                    <div id="modalAvatarCircle" class="applicant-avatar" style="width: 52px; height: 52px; font-size: 18px; font-weight: 700; border: 2px solid rgba(255,255,255,0.4); box-shadow: 0 4px 10px rgba(0,0,0,0.15);">--</div>
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-0" id="modalApplicantName" style="font-size: 18px;">Applicant Profile</h5>
                        <div class="small text-white-50" id="modalApplicantEmail" style="opacity: 0.85;">-</div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="background-color: #fcfdfc;">
                <div class="row g-3 mb-3">
                    <!-- Status & Basic Tags -->
                    <div class="col-12 d-flex flex-wrap align-items-center justify-content-between gap-2 p-3 bg-white border rounded-3 shadow-sm">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted small fw-semibold">Application Status:</span>
                            <span id="modalStatusBadge" class="status-badge status-default">Pending</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted small fw-semibold">Date Applied:</span>
                            <span id="modalDateApplied" class="date-val fw-bold">-</span>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Personal & Contact Information -->
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm" style="border-radius: 10px; background: #fff;">
                            <div class="card-header bg-transparent border-bottom py-3">
                                <h6 class="mb-0 fw-bold text-success" style="color: var(--green-500) !important;">
                                    <i class="fas fa-id-card me-2"></i>Personal & Contact Info
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="text-muted small d-block">Full Name</span>
                                    <strong id="modalFullName" class="text-dark">-</strong>
                                </div>
                                <div class="mb-3">
                                    <span class="text-muted small d-block">Email Address</span>
                                    <span id="modalEmailText" class="text-dark fw-medium">-</span>
                                </div>
                                <div class="mb-3">
                                    <span class="text-muted small d-block">Contact Number</span>
                                    <span id="modalContact" class="text-dark fw-medium">-</span>
                                </div>
                                <div class="mb-0">
                                    <span class="text-muted small d-block">IP Group / Tribe</span>
                                    <span id="modalTribe" class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-2 mt-1" style="font-size: 12px; font-family: 'Poppins', sans-serif;">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Application Details & Address -->
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm" style="border-radius: 10px; background: #fff;">
                            <div class="card-header bg-transparent border-bottom py-3">
                                <h6 class="mb-0 fw-bold text-success" style="color: var(--green-500) !important;">
                                    <i class="fas fa-file-lines me-2"></i>Application Info
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="text-muted small d-block">Endorsement / Classification</span>
                                    <div id="modalClassification" class="mt-1">-</div>
                                </div>
                                <div class="mb-3">
                                    <span class="text-muted small d-block">Purpose</span>
                                    <div id="modalPurpose" class="text-dark small fw-medium mt-1">-</div>
                                </div>
                                <div class="mb-0">
                                    <span class="text-muted small d-block">Address</span>
                                    <div id="modalAddress" class="text-dark small mt-1">-</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Uploaded Documents & Attachments -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm" style="border-radius: 10px; background: #fff;">
                            <div class="card-header bg-transparent border-bottom py-3 d-flex align-items-center justify-content-between">
                                <h6 class="mb-0 fw-bold text-success" style="color: var(--green-500) !important;">
                                    <i class="fas fa-folder-open me-2"></i>Uploaded Documents & Attachments
                                </h6>
                                <span id="modalDocCountBadge" class="badge bg-secondary bg-opacity-10 text-dark fw-normal" style="font-size: 11px;">0 File(s)</span>
                            </div>
                            <div class="card-body">
                                <div id="modalDocumentsList" class="d-flex flex-wrap gap-2">
                                    <span class="text-muted small">No uploaded documents found.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light justify-content-between p-3 flex-wrap gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-2" data-bs-dismiss="modal">Close</button>
                <div class="d-flex align-items-center gap-2">
                    <a id="modalCocCertBtn" href="#" target="_blank" class="btn btn-outline-primary btn-sm rounded-2 px-3 fw-semibold" style="display:none;">
                        <i class="fas fa-certificate me-1"></i> View COC Certificate
                    </a>
                    <a id="modalTransactionBtn" href="#" class="btn btn-success btn-sm rounded-2 px-3 fw-semibold" style="background: var(--green-500); border-color: var(--green-500);">
                        <i class="fas fa-clock-rotate-left me-1"></i> View Transaction History
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentApplicationId = null;
let actionType = null;
let searchTimeout = null;
const approvalUrlTemplate = @json(route('admin.applicants.coc-approve', ['application' => '__APPLICATION_ID__']));

// ── Show Applicant Profile Modal ─────────────────────────
function showApplicantProfileModal(data) {
    if (!data) return;
    document.getElementById('modalApplicantName').textContent = data.name || 'Applicant Profile';
    document.getElementById('modalApplicantEmail').textContent = data.email || '-';
    document.getElementById('modalAvatarCircle').textContent = data.initials || '--';
    document.getElementById('modalFullName').textContent = data.name || '-';
    document.getElementById('modalEmailText').textContent = data.email || '-';
    document.getElementById('modalContact').textContent = data.contact || 'N/A';
    document.getElementById('modalTribe').textContent = data.tribe || '-';
    document.getElementById('modalDateApplied').textContent = data.date || '-';
    document.getElementById('modalAddress').textContent = data.address || '-';
    document.getElementById('modalPurpose').textContent = data.purpose || '-';

    // Classification
    const classContainer = document.getElementById('modalClassification');
    if (data.classification && Array.isArray(data.classification) && data.classification.length > 0) {
        classContainer.innerHTML = data.classification.map(c => `<span class="info-badge">${c}</span>`).join(' ');
    } else {
        classContainer.textContent = '-';
    }

    // Application Status
    const statusEl = document.getElementById('modalStatusBadge');
    statusEl.className = 'status-badge';
    if (data.status === 'Approved') {
        statusEl.classList.add('status-approved');
        statusEl.textContent = 'Approved';
    } else if (data.status === 'Returned') {
        statusEl.classList.add('status-returned');
        statusEl.textContent = 'Returned';
    } else if (data.status === 'Admin Approval') {
        statusEl.classList.add('status-admin');
        statusEl.textContent = 'Admin Approval';
    } else {
        statusEl.classList.add('status-default');
        statusEl.textContent = data.status || 'Pending';
    }

    // Render Uploaded Documents
    const docsContainer = document.getElementById('modalDocumentsList');
    const docCountBadge = document.getElementById('modalDocCountBadge');
    if (data.documents && Array.isArray(data.documents) && data.documents.length > 0) {
        docCountBadge.textContent = `${data.documents.length} File(s)`;
        docCountBadge.className = 'badge bg-success bg-opacity-10 text-success fw-bold';
        docsContainer.innerHTML = data.documents.map(doc => `
            <a href="${doc.url}" target="_blank" class="btn btn-outline-success btn-sm d-inline-flex align-items-center gap-2 rounded-2 px-3 py-2 text-decoration-none" style="font-size: 12.5px; border-color: var(--sand-200); background: #fdfdfd; color: var(--text-dark);">
                <i class="${doc.icon || 'fas fa-file-pdf'}" style="color: var(--green-500);"></i>
                <span class="fw-semibold">${doc.name}</span>
                <i class="fas fa-external-link-alt ms-1 text-muted" style="font-size: 10px;"></i>
            </a>
        `).join('');
    } else {
        docCountBadge.textContent = '0 File(s)';
        docCountBadge.className = 'badge bg-secondary bg-opacity-10 text-dark fw-normal';
        docsContainer.innerHTML = `<span class="text-muted small"><i class="fas fa-info-circle me-1"></i>No uploaded documents available for this applicant.</span>`;
    }

    // COC Certificate Button
    const cocCertBtn = document.getElementById('modalCocCertBtn');
    if (data.cocViewUrl) {
        cocCertBtn.href = data.cocViewUrl;
        cocCertBtn.style.display = 'inline-flex';
    } else {
        cocCertBtn.style.display = 'none';
    }

    // Transaction Button Link
    const transBtn = document.getElementById('modalTransactionBtn');
    if (data.transactionUrl) {
        transBtn.href = data.transactionUrl;
        transBtn.style.display = 'inline-flex';
    } else {
        transBtn.style.display = 'none';
    }

    const modal = new bootstrap.Modal(document.getElementById('applicantProfileModal'));
    modal.show();
}

// ── Search ────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    const searchInput  = document.getElementById('searchInput');
    const searchSpinner = document.getElementById('searchSpinner');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            const term = this.value.trim();
            if (term.length >= 2 || term.length === 0) {
                searchSpinner.style.display = 'block';
                searchTimeout = setTimeout(() => performSearch(term), 500);
            } else {
                searchSpinner.style.display = 'none';
            }
        });

        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                clearTimeout(searchTimeout);
                searchSpinner.style.display = 'block';
                performSearch(this.value.trim());
            }
        });
    }

    // ── Handle Returned Tab Click ──
    const tabReturned = document.getElementById('tabReturned');
    if (tabReturned) {
        tabReturned.addEventListener('click', function () {
            const dotReturned = document.getElementById('dotReturned');
            if (dotReturned) {
                dotReturned.classList.remove('show');
            }
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            fetch('/api/admin/notifications/mark-returned-viewed', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.badgeStatus) {
                    const appDot = document.getElementById('applicantsNavDot');
                    if (appDot) {
                        if (data.badgeStatus.main_dot) {
                            appDot.classList.add('show');
                        } else {
                            appDot.classList.remove('show');
                        }
                    }
                }
            })
            .catch(console.error);
        });
    }

    @if($status === 'Returned')
        const dotRet = document.getElementById('dotReturned');
        if (dotRet) dotRet.classList.remove('show');
    @endif
});

function performSearch(searchTerm) {
    const token  = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const status = '{{ $status }}';

    fetch('{{ route("admin.applicants.search") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ search: searchTerm, status: status })
    })
    .then(r => { if (!r.ok) throw new Error(`HTTP ${r.status}`); return r.json(); })
    .then(data => {
        document.getElementById('searchSpinner').style.display = 'none';
        if (data.success) {
            updateTable(data.applicants, data.pagination);
            updateCount(data.total);
            updatePaginationInfo(data.pagination);
        } else {
            showError('Search failed: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(err => {
        document.getElementById('searchSpinner').style.display = 'none';
        showError('Search error: ' + err.message);
    });
}

function updateTable(applicants, pagination) {
    const tbody = document.getElementById('applicantsTableBody');

    if (!applicants || applicants.length === 0) {
        tbody.innerHTML = `
            <tr><td colspan="8">
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>No applications found.</p>
                </div>
            </td></tr>`;
        return;
    }

    let html = '';
    applicants.forEach(coc => {
        const fn       = coc.first_name  || coc.applicant?.first_name || '';
        const ln       = coc.last_name   || coc.applicant?.last_name  || '';
        const fullName = `${fn} ${ln}`.trim();
        const email    = coc.email       || coc.applicant?.email      || '-';
        const contact  = coc.contact     || coc.applicant?.contact    || 'N/A';
        const tribe    = coc.tribe       || coc.applicant?.tribe      || '-';
        const leader   = coc.leader      || coc.applicant?.leader     || '-';
        const address  = coc.address     || coc.applicant?.address    || '-';
        const purpose  = coc.purpose     || '-';
        const initials = (fn.charAt(0) + ln.charAt(0)).toUpperCase() || '--';
        const appDate  = coc.created_at ? new Date(coc.created_at).toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'}) : '-';
        const st       = coc.coc_status || 'Pending';
        const transUrl = `/admin/applicants/${coc.applicant_id || coc.applicant?.id || coc.id}/transaction`;

        let statusBadge = '';
        if (st === 'Approved')        statusBadge = `<span class="status-badge status-approved">Approved</span>`;
        else if (st === 'Returned')   statusBadge = `<span class="status-badge status-returned">Returned</span>`;
        else if (st === 'Admin Approval') statusBadge = `<span class="status-badge status-admin">Admin Approval</span>`;
        else                          statusBadge = `<span class="status-badge status-default">${st}</span>`;

        let classHtml = '-';
        if (coc.classification && coc.classification.length > 0)
            classHtml = coc.classification.map(c => `<span class="info-badge">${c}</span>`).join('');

        const approveBtn = st === 'Admin Approval' ? `
            <button type="button" class="btn-approve"
                    onclick="showApproveModal('${fn} ${ln}', '${coc.id}')">
                <i class="fas fa-check"></i> Approve
            </button>` : '';

        const profileData = {
            name: fullName,
            initials: initials,
            email: email,
            contact: contact,
            tribe: tribe,
            leader: leader,
            address: address,
            purpose: purpose,
            classification: coc.classification || [],
            status: st,
            date: appDate,
            transactionUrl: transUrl
        };
        const profileJson = JSON.stringify(profileData).replace(/'/g, "&#39;");

        html += `
            <tr class="applicant-row">
                <td>
                    <div class="applicant-cell applicant-cell-clickable"
                         onclick='showApplicantProfileModal(${profileJson})'
                         title="Click to view applicant profile">
                        <div class="applicant-avatar">${initials}</div>
                        <div>
                            <div class="applicant-name">${fullName}</div>
                            <div class="applicant-email">${email}</div>
                        </div>
                    </div>
                </td>
                <td class="text-center"><span class="date-val">${appDate}</span></td>
                <td class="text-center"><span class="info-badge">${tribe}</span></td>
                <td class="text-center">${classHtml}</td>
                <td class="text-center">${purpose}</td>
                <td class="text-center"><div class="address-text">${address}</div></td>
                <td class="text-center">${statusBadge}</td>
                <td class="text-center">
                    <div class="action-cell">
                        <a href="${transUrl}" class="btn-transaction">
                            <i class="fas fa-clock-rotate-left"></i> Transaction
                        </a>
                        ${approveBtn}
                    </div>
                </td>
            </tr>`;
    });

    tbody.innerHTML = html;
}

function updateCount(total) {
    const el = document.getElementById('applicantCount');
    if (el) el.textContent = total || 0;
}

function updatePaginationInfo(pagination) {
    const info  = document.getElementById('paginationInfo');
    const links = document.getElementById('paginationLinks');
    if (info && pagination)
        info.textContent = `Showing ${pagination.from || 0} to ${pagination.to || 0} of ${pagination.total || 0} entries`;
    if (links && pagination?.links)
        links.innerHTML = pagination.links;
}

function showError(message) {
    const div = document.createElement('div');
    div.className = 'alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3';
    div.style.cssText = 'z-index:9999;font-family:DM Sans,sans-serif;border:none;border-radius:var(--radius-sm);';
    div.innerHTML = `${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
    document.body.appendChild(div);
    setTimeout(() => { if (div.parentNode) div.remove(); }, 5000);
}

// ── Approval Flow ─────────────────────────────────────────
function showApproveModal(name, id) {
    document.getElementById('approveApplicantName').textContent = name;
    currentApplicationId = id;
    actionType = 'approve';
    new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function submitApproval() {
    if (!currentApplicationId) return;

    bootstrap.Modal.getInstance(document.getElementById('approveModal')).hide();
    new bootstrap.Modal(document.getElementById('loadingModal')).show();

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const fd = new FormData();
    fd.append('_token', token);

    const approvalUrl = approvalUrlTemplate.replace('__APPLICATION_ID__', currentApplicationId);

    fetch(approvalUrl, {
        method: 'POST', body: fd,
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => { if (!r.ok) throw new Error(`HTTP ${r.status}`); return r.json(); })
    .then(data => {
        closeLoadingModal();
        showResultModal(data.success, data.message, 'approved');
    })
    .catch(err => {
        closeLoadingModal();
        showResultModal(false, 'An error occurred: ' + err.message, 'error');
    });
}

function closeLoadingModal() {
    const el = document.getElementById('loadingModal');
    const inst = bootstrap.Modal.getInstance(el);
    if (inst) inst.dispose();
    el.style.display = 'none';
    document.body.classList.remove('modal-open');
    document.querySelector('.modal-backdrop')?.remove();
}

function showResultModal(success, message, type) {
    const modal   = document.getElementById('resultModal');
    const header  = document.getElementById('resultModalHeader');
    const title   = document.getElementById('resultModalTitle');
    const icon    = document.getElementById('resultModalIcon');
    const msgEl   = document.getElementById('resultModalMessage');
    const btn     = document.getElementById('resultModalBtn');

    if (success && type === 'approved') {
        header.style.cssText = 'background:var(--green-500);';
        title.innerHTML = '<span style="color:#fff"><i class="fas fa-check-circle me-2"></i>Application Approved</span>';
        icon.innerHTML  = '<div class="modal-icon success"><i class="fas fa-check-circle"></i></div>';
        btn.style.cssText = 'background:var(--green-500);color:#fff;border:none;border-radius:var(--radius-sm);padding:8px 28px;font-family:DM Sans,sans-serif;font-weight:600;';
    } else {
        header.style.cssText = 'background:#ef4444;';
        title.innerHTML = '<span style="color:#fff"><i class="fas fa-times-circle me-2"></i>Error</span>';
        icon.innerHTML  = '<div class="modal-icon danger"><i class="fas fa-times-circle"></i></div>';
        btn.style.cssText = 'background:#ef4444;color:#fff;border:none;border-radius:var(--radius-sm);padding:8px 28px;font-family:DM Sans,sans-serif;font-weight:600;';
    }

    msgEl.textContent = message;
    const inst = new bootstrap.Modal(modal);
    inst.show();
    modal.addEventListener('hidden.bs.modal', () => window.location.reload(), { once: true });
}
</script>

@endsection
