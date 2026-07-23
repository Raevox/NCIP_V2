@extends('layouts.admin')

@section('title', 'Pending Accounts')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>

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

*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

body, .pending-accounts-content {
    font-family: 'DM Sans', sans-serif;
    background-color: #fff;
    color: var(--text-dark);
    margin:10px;
}


/* ── Page Header ─────────────────────────── */
.page-header {
    margin-bottom: 24px;
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

.header-icon {
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

.search-wrapper input::placeholder { color: var(--text-soft); }

.search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-soft);
    font-size: 13px;
    pointer-events: none;
}

/* View Switcher */
.view-switcher {
    display: flex;
    gap: 6px;
    background: var(--sand-100);
    padding: 5px;
    border-radius: var(--radius-sm);
    border: 1px solid var(--sand-200);
    flex-wrap: wrap;
}

.view-btn {
    padding: 7px 16px;
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

.view-btn:hover { background: var(--white); color: var(--green-500); }

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
    white-space: nowrap;
}

.tab-btn:hover { background: var(--green-50); color: var(--green-500); }

.tab-btn.active {
    background: var(--green-500);
    color: var(--white);
    box-shadow: 0 2px 8px rgba(62,123,39,0.2);
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

.stats-pill i { color: #f59e0b; }
.stats-pill strong { color: #b45309; font-family: 'DM Mono', monospace; }

/* ── Table Card ──────────────────────────── */
.table-card {
    background: var(--white);
    border-radius: var(--radius-md);
    border: 1px solid var(--sand-200);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.table-scroll { overflow-x: auto; }

.pending-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 620px;
}

.pending-table thead tr { background: var(--green-500); }

.pending-table thead th {
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

.pending-table thead th.text-center { text-align: center; }

.pending-table tbody tr {
    border-bottom: 1px solid var(--sand-100);
    transition: background 0.15s;
}

.pending-table tbody tr:last-child { border-bottom: none; }
.pending-table tbody tr:hover { background: var(--green-50); }

.pending-table tbody td {
    padding: 14px 16px;
    font-size: 13.5px;
    color: var(--text-dark);
    vertical-align: middle;
}

.pending-table tbody td.text-center { text-align: center; }

/* Avatar */
.applicant-cell { display: flex; align-items: center; gap: 11px; }

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
}

.applicant-name { font-weight: 600; color: var(--text-dark); font-size: 13.5px; }
.email-text { font-size: 13px; color: var(--text-soft); }

.contact-text {
    font-family: 'DM Mono', monospace;
    font-size: 12.5px;
    color: var(--text-mid);
}

/* Status pending badge */
.status-pending {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #fffbeb;
    color: #92400e;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 600;
}

.status-pending::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #f59e0b;
    flex-shrink: 0;
}

/* ── 3-dot Dropdown ──────────────────────── */
.action-btn {
    width: 32px; height: 32px;
    border: 1.5px solid var(--sand-200);
    background: var(--white);
    color: var(--text-mid);
    border-radius: var(--radius-sm);
    display: grid;
    place-items: center;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.18s;
}

.action-btn:hover {
    border-color: var(--green-300);
    color: var(--green-500);
    background: var(--green-50);
}

.dropdown-menu {
    border: none !important;
    box-shadow: 0 6px 24px rgba(30,60,20,0.13) !important;
    border-radius: var(--radius-md) !important;
    padding: 8px !important;
    min-width: 180px;
    font-family: 'DM Sans', sans-serif;
}

.dropdown-item {
    padding: 9px 13px !important;
    border-radius: var(--radius-sm) !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    color: var(--text-dark) !important;
    display: flex !important;
    align-items: center !important;
    gap: 9px !important;
    transition: all 0.15s !important;
    cursor: pointer;
    background: none;
    border: none;
    width: 100%;
    text-align: left;
}

.dropdown-item i {
    width: 16px;
    text-align: center;
    font-size: 12px;
    color: var(--text-soft);
    flex-shrink: 0;
}

.dropdown-item:hover {
    background: var(--green-50) !important;
    color: var(--green-500) !important;
}

.dropdown-item:hover i { color: var(--green-500) !important; }

.dropdown-item.item-success { color: #065f46 !important; }
.dropdown-item.item-success i { color: #10b981 !important; }
.dropdown-item.item-success:hover { background: #ecfdf5 !important; color: #065f46 !important; }

.dropdown-item.item-danger { color: #991b1b !important; }
.dropdown-item.item-danger i { color: #ef4444 !important; }
.dropdown-item.item-danger:hover { background: #fef2f2 !important; color: #991b1b !important; }

.dropdown-divider {
    border-color: var(--sand-200) !important;
    margin: 6px 0 !important;
}

/* ── Empty State ─────────────────────────── */
.empty-state { padding: 60px 20px; text-align: center; color: var(--text-soft); }
.empty-state i { font-size: 44px; opacity: 0.2; margin-bottom: 14px; display: block; }
.empty-state p { font-size: 15px; font-weight: 500; }

/* ── Modal Polish ────────────────────────── */
.modal-content {
    border: none;
    border-radius: var(--radius-md);
    overflow: hidden;
    font-family: 'DM Sans', sans-serif;
}

.modal-header { border-bottom: none; padding: 20px 24px 16px; }
.modal-body   { padding: 20px 24px; }
.modal-footer { border-top: 1px solid var(--sand-200); padding: 16px 24px; }
.modal-title  { font-weight: 700; font-size: 16px; }

.modal-icon {
    width: 64px; height: 64px;
    border-radius: 50%;
    display: grid;
    place-items: center;
    margin: 0 auto 16px;
    font-size: 26px;
}

.modal-icon.success { background: #ecfdf5; color: #10b981; }
.modal-icon.danger  { background: #fef2f2; color: #ef4444; }
.modal-icon.warning { background: #fffbeb; color: #f59e0b; }

.modal-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 22px;
    border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.18s;
}

.modal-btn.secondary {
    background: var(--sand-200);
    color: var(--text-mid);
}

.modal-btn.secondary:hover { background: var(--sand-100); }

.modal-btn.success-btn {
    background: var(--green-500);
    color: #fff;
}

.modal-btn.success-btn:hover { background: var(--green-700); }

.modal-btn.danger-btn {
    background: #ef4444;
    color: #fff;
}

.modal-btn.danger-btn:hover { background: #dc2626; }

/* Decline textarea */
.decline-textarea {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid var(--sand-200);
    border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 13.5px;
    color: var(--text-dark);
    resize: vertical;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.decline-textarea:focus {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239,68,68,0.10);
}

.decline-textarea::placeholder { color: var(--text-soft); }

.decline-label {
    font-size: 13px;
    font-weight: 600;
    color: #991b1b;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.email-highlight {
    font-family: 'DM Mono', monospace;
    font-size: 12px;
    color: var(--green-500);
    font-weight: 500;
}

/* ── Responsive ──────────────────────────── */
@media (max-width: 768px) {
    .controls-bar { flex-direction: column; align-items: stretch; }
    .search-wrapper { width: 100%; }
    .view-switcher { justify-content: center; }
    .tab-stats-row { flex-direction: column; align-items: flex-start; }
    .applicant-avatar { display: none; }
}
</style>

<div class="pending-accounts-content">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert"
             style="border-radius:var(--radius-sm);border:none;font-family:'DM Sans',sans-serif;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert"
             style="border-radius:var(--radius-sm);border:none;font-family:'DM Sans',sans-serif;">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="page-header">
        <h2>
            <span class="header-icon"><i class="fas fa-users"></i></span>
            Pending Accounts
        </h2>
    </div>

    {{-- Controls Bar: Search + Application/Account switcher --}}
    <div class="controls-bar">
        <div class="search-wrapper">
            <form action="{{ route('admin.applicants.pending') }}" method="GET" style="margin:0;">
                <i class="fas fa-search search-icon"></i>
                <input
                    type="text"
                    name="search"
                    placeholder="Search by name or email..."
                    value="{{ request('search') }}"
                />
            </form>
        </div>

        {{-- Application ↔ Account top-level switcher --}}
        <div class="view-switcher">
            <a href="{{ route('admin.applicants.index') }}"
               class="view-btn {{ request()->routeIs('admin.applicants.index') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> Application
            </a>
            <a href="{{ route('admin.applicants.accounts') }}"
               class="view-btn {{ request()->routeIs('admin.applicants.accounts') || request()->routeIs('admin.applicants.pending') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Account
            </a>
        </div>
    </div>

    {{-- Approved / Pending sub-tabs + count pill --}}
    <div class="tab-stats-row">
        <div class="tab-navigation">
            <a href="{{ route('admin.applicants.accounts') }}"
               class="tab-btn {{ request()->routeIs('admin.applicants.accounts') ? 'active' : '' }}">
                <i class="fas fa-check-circle" style="font-size:11px;"></i> Approved
            </a>
            <a href="{{ route('admin.applicants.pending') }}"
               class="tab-btn {{ request()->routeIs('admin.applicants.pending') ? 'active' : '' }}">
                <i class="fas fa-clock" style="font-size:11px;"></i> Pending
            </a>
        </div>

        <div class="stats-pill">
            <i class="fas fa-hourglass-half"></i>
            <strong>{{ $pendingAccounts->count() }}</strong>
            <span>Pending Account(s)</span>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-scroll">
            <table class="pending-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th class="text-center">Contact</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingAccounts as $account)
                        @php
                            $initials = strtoupper(substr($account->first_name,0,1) . substr($account->last_name,0,1));
                        @endphp
                        <tr>
                            {{-- Name --}}
                            <td>
                                <div class="applicant-cell">
                                    <div class="applicant-avatar">{{ $initials }}</div>
                                    <span class="applicant-name">{{ $account->first_name }} {{ $account->last_name }}</span>
                                </div>
                            </td>

                            {{-- Email --}}
                            <td><span class="email-text">{{ $account->email }}</span></td>

                            {{-- Contact --}}
                            <td class="text-center">
                                <span class="contact-text">{{ $account->contact ?? '—' }}</span>
                            </td>

                            {{-- Status --}}
                            <td class="text-center">
                                <span class="status-pending">{{ ucfirst($account->status) }}</span>
                            </td>

                            {{-- 3-dot Dropdown --}}
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="action-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item"
                                               href="{{ route('admin.applicants.view', $account->id) }}">
                                                <i class="fas fa-eye"></i> View Details
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <button type="button"
                                                    class="dropdown-item item-success"
                                                    onclick="showApproveModal('{{ $account->first_name }} {{ $account->last_name }}', '{{ $account->id }}')">
                                                <i class="fas fa-check-circle"></i> Approve Account
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button"
                                                    class="dropdown-item item-danger"
                                                    onclick="showDeclineModal('{{ $account->first_name }} {{ $account->last_name }}', '{{ $account->id }}', '{{ $account->email }}')">
                                                <i class="fas fa-times-circle"></i> Decline & Remove
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>No pending accounts found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ── Approve Modal ─────────────────────── --}}
<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:var(--green-500);">
                <h5 class="modal-title text-white">
                    <i class="fas fa-user-check me-2"></i>Approve Account
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="modal-icon success">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h6 style="font-weight:700;font-size:16px;margin-bottom:8px;">Confirm Account Approval</h6>
                <p style="font-size:14px;color:var(--text-mid);margin-bottom:6px;">
                    Approve the account for <strong id="approveAccountName" style="color:var(--text-dark);"></strong>?
                </p>
                <small style="color:var(--text-soft);">This will move the account to active IP accounts and send a welcome email.</small>
            </div>
            <div class="modal-footer justify-content-center gap-2">
                <button type="button" class="modal-btn secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="modal-btn success-btn" onclick="submitApproval()">
                    <i class="fas fa-check"></i> Approve Account
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ── Decline Modal ─────────────────────── --}}
<div class="modal fade" id="declineModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:#ef4444;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-user-times me-2"></i>Decline & Remove Account
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="modal-icon danger">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h6 style="font-weight:700;font-size:16px;margin-bottom:8px;">Decline Account Registration</h6>
                    <p style="font-size:14px;color:var(--text-mid);margin-bottom:4px;">
                        You are about to decline <strong id="declineAccountName" style="color:var(--text-dark);"></strong>'s registration.
                    </p>
                    <small style="color:var(--text-soft);">This account will be permanently removed from the database.</small>
                </div>

                <div>
                    <div class="decline-label">
                        <i class="fas fa-clipboard-list"></i> Reason for Decline <span style="color:#ef4444;">*</span>
                    </div>
                    <textarea id="declineReason"
                              class="decline-textarea"
                              rows="4"
                              placeholder="Please specify what needs to be corrected or why this account is being declined..."></textarea>
                    <div style="font-size:12px;color:var(--text-soft);margin-top:6px;">
                        This message will be sent via email to:
                        <span id="declineAccountEmail" class="email-highlight"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center gap-2">
                <button type="button" class="modal-btn secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="modal-btn danger-btn" onclick="submitDecline()">
                    <i class="fas fa-trash"></i> Decline & Remove
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
                <button type="button" class="modal-btn" id="resultModalBtn" onclick="reloadPage()"
                        style="padding:9px 28px;">OK</button>
            </div>
        </div>
    </div>
</div>

{{-- ── Loading Modal ─────────────────────── --}}
<div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
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

<script>
let currentAccountId = null;
let actionType = null;

function showApproveModal(accountName, accountId) {
    document.getElementById('approveAccountName').textContent = accountName;
    currentAccountId = accountId;
    actionType = 'approve';
    new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function showDeclineModal(accountName, accountId, accountEmail) {
    document.getElementById('declineAccountName').textContent = accountName;
    document.getElementById('declineAccountEmail').textContent = accountEmail;
    document.getElementById('declineReason').value = '';
    currentAccountId = accountId;
    actionType = 'decline';
    new bootstrap.Modal(document.getElementById('declineModal')).show();
}

function submitApproval() {
    if (!currentAccountId) return;

    hideCurrentModals();
    showLoadingModal();

    const token = getCSRFToken();
    if (!token) { hideLoadingModal(); showResultModal(false, 'CSRF token not found. Please refresh.', 'error'); return; }

    const fd = new FormData();
    fd.append('_token', token);

    fetch(`/admin/applicants/${currentAccountId}/approve`, {
        method: 'POST', body: fd,
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => { if (!r.ok) throw new Error(`HTTP ${r.status}`); return r.json(); })
    .then(data => { hideLoadingModal(); showResultModal(data.success, data.message, 'approved'); })
    .catch(err => { hideLoadingModal(); showResultModal(false, 'Error approving account: ' + err.message, 'error'); });
}

function submitDecline() {
    if (!currentAccountId) return;

    const reason = document.getElementById('declineReason').value.trim();
    if (!reason) { alert('Please provide a reason for declining this account.'); return; }

    hideCurrentModals();
    showLoadingModal();

    const token = getCSRFToken();
    if (!token) { hideLoadingModal(); showResultModal(false, 'CSRF token not found. Please refresh.', 'error'); return; }

    const fd = new FormData();
    fd.append('_token', token);
    fd.append('reason', reason);

    fetch(`/admin/applicants/${currentAccountId}/decline`, {
        method: 'POST', body: fd,
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => { if (!r.ok) throw new Error(`HTTP ${r.status}`); return r.json(); })
    .then(data => { hideLoadingModal(); showResultModal(data.success, data.message, 'declined'); })
    .catch(err => { hideLoadingModal(); showResultModal(false, 'Error declining account: ' + err.message, 'error'); });
}

function showResultModal(success, message, type) {
    const header  = document.getElementById('resultModalHeader');
    const title   = document.getElementById('resultModalTitle');
    const icon    = document.getElementById('resultModalIcon');
    const msgEl   = document.getElementById('resultModalMessage');
    const btn     = document.getElementById('resultModalBtn');

    if (success && type === 'approved') {
        header.style.cssText = 'background:var(--green-500);border-bottom:none;padding:20px 24px 16px;';
        title.innerHTML = '<span style="color:#fff;font-weight:700;font-size:16px;"><i class="fas fa-user-check me-2"></i>Account Approved</span>';
        icon.innerHTML  = '<div class="modal-icon success"><i class="fas fa-user-check"></i></div>';
        btn.style.cssText = 'background:var(--green-500);color:#fff;border:none;border-radius:var(--radius-sm);padding:9px 28px;font-family:DM Sans,sans-serif;font-weight:600;font-size:13px;cursor:pointer;';
    } else if (success && type === 'declined') {
        header.style.cssText = 'background:#f59e0b;border-bottom:none;padding:20px 24px 16px;';
        title.innerHTML = '<span style="color:#fff;font-weight:700;font-size:16px;"><i class="fas fa-user-times me-2"></i>Account Declined</span>';
        icon.innerHTML  = '<div class="modal-icon warning"><i class="fas fa-user-times"></i></div>';
        btn.style.cssText = 'background:#f59e0b;color:#fff;border:none;border-radius:var(--radius-sm);padding:9px 28px;font-family:DM Sans,sans-serif;font-weight:600;font-size:13px;cursor:pointer;';
    } else {
        header.style.cssText = 'background:#ef4444;border-bottom:none;padding:20px 24px 16px;';
        title.innerHTML = '<span style="color:#fff;font-weight:700;font-size:16px;"><i class="fas fa-times-circle me-2"></i>Error</span>';
        icon.innerHTML  = '<div class="modal-icon danger"><i class="fas fa-times-circle"></i></div>';
        btn.style.cssText = 'background:#ef4444;color:#fff;border:none;border-radius:var(--radius-sm);padding:9px 28px;font-family:DM Sans,sans-serif;font-weight:600;font-size:13px;cursor:pointer;';
    }

    msgEl.textContent = message;
    new bootstrap.Modal(document.getElementById('resultModal')).show();
}

function getCSRFToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
           document.querySelector('input[name="_token"]')?.value;
}

function hideCurrentModals() {
    ['approveModal','declineModal'].forEach(id => {
        const inst = bootstrap.Modal.getInstance(document.getElementById(id));
        if (inst) inst.hide();
    });
}

function showLoadingModal() {
    new bootstrap.Modal(document.getElementById('loadingModal')).show();
}

function hideLoadingModal() {
    const el   = document.getElementById('loadingModal');
    const inst = bootstrap.Modal.getInstance(el);
    if (inst) inst.dispose();
    el.style.display = 'none';
    document.body.classList.remove('modal-open');
    document.querySelector('.modal-backdrop')?.remove();
}

function reloadPage() { window.location.reload(); }

document.addEventListener('DOMContentLoaded', () => {
    currentAccountId = null;
    actionType = null;
});
</script>

@endsection