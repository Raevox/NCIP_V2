@extends('layouts.admin')

@section('title', 'Approved Accounts')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
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

*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

body, .applicants-content {
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

/* View Switcher (Application / Account) */
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

/* Sub-tabs: Approved / Pending */
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

.tab-btn:hover { background: var(--green-50); color: var(--green-500); }

.tab-btn.active {
    background: var(--green-500);
    color: var(--white);
    box-shadow: 0 2px 8px rgba(62,123,39,0.2);
}

/* Stats pill */
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

.stats-pill i { color: var(--green-500); }
.stats-pill strong { color: var(--green-500); font-family: 'DM Mono', monospace; }

/* ── Table Card ──────────────────────────── */
.table-card {
    background: var(--white);
    border-radius: var(--radius-md);
    border: 1px solid var(--sand-200);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.table-scroll { overflow-x: auto; }

.accounts-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 680px;
}

.accounts-table thead tr { background: var(--green-500); }

.accounts-table thead th {
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

.accounts-table thead th.text-center { text-align: center; }

.accounts-table tbody tr {
    border-bottom: 1px solid var(--sand-100);
    transition: background 0.15s;
}

.accounts-table tbody tr:last-child { border-bottom: none; }
.accounts-table tbody tr:hover { background: var(--green-50); }

.accounts-table tbody td {
    padding: 14px 16px;
    font-size: 13.5px;
    color: var(--text-dark);
    vertical-align: middle;
}

.accounts-table tbody td.text-center { text-align: center; }

/* Avatar */
.applicant-cell { display: flex; align-items: center; gap: 11px; }

.applicant-cell-clickable {
    cursor: pointer;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
    padding: 6px 8px;
    border-radius: var(--radius-sm);
    display: inline-flex;
    align-items: center;
    gap: 11px;
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

.applicant-name { font-weight: 600; color: var(--text-dark); font-size: 13.5px; transition: color 0.2s ease; }

.email-text { font-size: 13px; color: var(--text-soft); }

.contact-text {
    font-family: 'DM Mono', monospace;
    font-size: 12.5px;
    color: var(--text-mid);
}

/* Tribe badge */
.tribe-badge {
    display: inline-block;
    background: var(--green-100);
    color: var(--green-700);
    padding: 4px 11px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 600;
    white-space: nowrap;
}

/* Status active */
.status-active {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #ecfdf5;
    color: #065f46;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 600;
}

.status-active::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #10b981;
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
    min-width: 170px;
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

/* ── Pagination ──────────────────────────── */
.pagination-row {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.pagination-info { font-size: 13px; color: var(--text-soft); }

/* ── Responsive ──────────────────────────── */
@media (max-width: 768px) {
    .controls-bar { flex-direction: column; align-items: stretch; }
    .search-wrapper { width: 100%; }
    .view-switcher { justify-content: center; }
    .tab-stats-row { flex-direction: column; align-items: flex-start; }
    .applicant-avatar { display: none; }
}
</style>

<div class="applicants-content">

    {{-- Page Header --}}
    <div class="page-header">
        <h2>
            <span class="header-icon"><i class="fas fa-users"></i></span>
            Applicant Accounts
        </h2>
    </div>

    {{-- Controls Bar: Search + Application/Account switcher --}}
    <div class="controls-bar">
        <div class="search-wrapper">
            <form action="{{ route('admin.applicants.accounts') }}" method="GET" style="margin:0;">
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
                class="view-btn {{ request()->routeIs('admin.applicants.accounts') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Account
            </a>
        </div>
    </div>

    {{-- Account count --}}
    <div class="tab-stats-row">
        <div></div>
        <div class="stats-pill">
            <i class="fas fa-user-check"></i>
            <strong>{{ $approvedUsers->total() }}</strong>
            <span>Account(s)</span>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-scroll">
            <table class="accounts-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th class="text-center">Contact</th>
                        <th class="text-center">Tribe</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($approvedUsers as $user)
                        @php
                            $initials = strtoupper(substr($user->first_name,0,1) . substr($user->last_name,0,1));
                        @endphp
                        <tr>
                            {{-- Name --}}
                            <td>
                                <a href="{{ route('admin.applicants.transaction', $user->id) }}" 
                                   class="applicant-cell-clickable" 
                                   title="Click to view applicant profile">
                                    <div class="applicant-avatar">{{ $initials }}</div>
                                    <span class="applicant-name">{{ $user->first_name }} {{ $user->last_name }}</span>
                                </a>
                            </td>

                            {{-- Email --}}
                            <td><span class="email-text">{{ $user->email }}</span></td>

                            {{-- Contact --}}
                            <td class="text-center">
                                <span class="contact-text">{{ $user->contact ?? '—' }}</span>
                            </td>

                            {{-- Tribe --}}
                            <td class="text-center">
                                @if($user->tribe)
                                    <span class="tribe-badge">{{ $user->tribe }}</span>
                                @else
                                    <span style="color:var(--text-soft);">—</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="text-center">
                                <span class="status-active">Active</span>
                            </td>

                            {{-- 3-dot Dropdown --}}
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="action-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="{{ route('admin.applicants.transaction', $user->id) }}"
                                               class="dropdown-item">
                                                <i class="fas fa-clock-rotate-left"></i> Transaction
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.applicants.accounts.archive', $user->id) }}"
                                                  method="POST"
                                                  style="margin:0;"
                                                  onsubmit="return confirm('Archive this account?')">
                                                @csrf
                                                <button type="submit" class="dropdown-item item-danger w-100">
                                                    <i class="fas fa-box-archive"></i> Archive
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>No approved accounts found.</p>
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
        <div class="pagination-info">
            Showing {{ $approvedUsers->firstItem() ?? 0 }} to {{ $approvedUsers->lastItem() ?? 0 }}
            of {{ $approvedUsers->total() }} entries
        </div>
        <div>{{ $approvedUsers->links('pagination::bootstrap-4') }}</div>
    </div>

</div>

@endsection