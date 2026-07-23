@extends('layouts.admin')
@section('title', 'COC Audit Log')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --green-900: #1a3d0f;
    --green-700: #2d6a1f;
    --green-500: #2E7D46;
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

body, .audit-content {
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

/* ── Search Bar ──────────────────────────── */
.search-bar {
    background: var(--white);
    border: 1px solid var(--sand-200);
    border-radius: var(--radius-md);
    padding: 14px 18px;
    margin-bottom: 16px;
    box-shadow: var(--shadow-sm);
    display: flex;
    align-items: center;
    gap: 12px;
}

.search-wrapper {
    position: relative;
    flex: 1;
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
    flex-shrink: 0;
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

.audit-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px;
}

.audit-table thead tr { background: var(--green-500); }

.audit-table thead th {
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

.audit-table thead th.text-center { text-align: center; }

.audit-table tbody tr {
    border-bottom: 1px solid var(--sand-100);
    transition: background 0.15s;
}

.audit-table tbody tr:last-child { border-bottom: none; }
.audit-table tbody tr:hover { background: var(--green-50); }

.audit-table tbody td {
    padding: 14px 16px;
    font-size: 13.5px;
    color: var(--text-dark);
    vertical-align: middle;
}

.audit-table tbody td.text-center { text-align: center; }

/* Row number */
.row-num {
    font-family: 'DM Mono', monospace;
    font-size: 12.5px;
    font-weight: 600;
    color: var(--green-500);
    background: var(--green-50);
    border: 1px solid var(--green-100);
    width: 30px; height: 30px;
    border-radius: 6px;
    display: grid;
    place-items: center;
}

/* Applicant cell */
.applicant-cell { display: flex; align-items: center; gap: 10px; }

.applicant-avatar {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--green-400), var(--green-700));
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    display: grid;
    place-items: center;
    flex-shrink: 0;
    letter-spacing: 0.5px;
}

.applicant-name { font-weight: 600; color: var(--text-dark); font-size: 13.5px; }

/* IP Group badge */
.badge-ip {
    display: inline-block;
    background: var(--green-100);
    color: var(--green-700);
    padding: 4px 11px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 600;
    white-space: nowrap;
}

/* Purpose text */
.purpose-text {
    font-size: 13px;
    color: var(--text-mid);
    max-width: 220px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Approved by cell */
.approved-by-cell { display: flex; align-items: center; gap: 8px; }

.approver-avatar {
    width: 28px; height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2196a8, #43c6d4);
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    display: grid;
    place-items: center;
    flex-shrink: 0;
}

.approver-name { font-size: 13px; font-weight: 600; color: var(--text-dark); }

/* Date */
.date-val {
    font-family: 'DM Mono', monospace;
    font-size: 12.5px;
    color: var(--green-500);
    font-weight: 500;
    white-space: nowrap;
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

/* Override Bootstrap pagination */
.pagination { gap: 4px; margin: 0; }

.pagination .page-link {
    border: 1.5px solid var(--sand-200) !important;
    color: var(--green-500) !important;
    border-radius: var(--radius-sm) !important;
    font-family: 'DM Sans', sans-serif !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    padding: 7px 13px !important;
    transition: all 0.18s !important;
    background: var(--white) !important;
}

.pagination .page-link:hover {
    background: var(--green-50) !important;
    border-color: var(--green-300) !important;
}

.pagination .page-item.active .page-link {
    background: var(--green-500) !important;
    border-color: var(--green-500) !important;
    color: #fff !important;
}

.pagination .page-item.disabled .page-link {
    color: var(--text-soft) !important;
    background: var(--sand-100) !important;
    border-color: var(--sand-200) !important;
}

/* ── Responsive ──────────────────────────── */
@media (max-width: 768px) {
    .search-bar { flex-direction: column; align-items: stretch; }
    .audit-table { font-size: 12px; }
    .audit-table th,
    .audit-table td { padding: 10px; }
    .applicant-avatar { display: none; }
    .approver-avatar { display: none; }
    .purpose-text { max-width: 140px; }
}
</style>

<div class="audit-content">

    {{-- Page Header --}}
    <div class="page-header">
        <h2>
            <span class="header-icon"><i class="fas fa-clipboard-list"></i></span>
            COC Audit Log
        </h2>
    </div>

    {{-- Search Bar + Stats --}}
    <div class="search-bar">
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input
                type="text"
                id="searchInput"
                placeholder="Search by applicant, IP group, or purpose..."
            />
        </div>
        <div class="stats-pill" id="statsCount">
            <i class="fas fa-clipboard-check"></i>
            <strong>{{ $applications->total() }}</strong>
            <span>Log(s)</span>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-scroll">
            <table class="audit-table" id="auditTable">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th>Applicant Name</th>
                        <th>IP Group</th>
                        <th>Purpose</th>
                        <th>Approved By</th>
                        <th>Approved Date</th>
                    </tr>
                </thead>
                <tbody id="auditBody">
                    @forelse($applications as $index => $app)
                        @php
                            $step1 = is_array($app->step1)
                                ? $app->step1
                                : (json_decode($app->step1, true) ?? []);

                            $ipGroup      = $step1['ip_group'] ?? 'N/A';
                            $purposeList  = $step1['purpose'] ?? [];

                            if (is_string($purposeList)) {
                                $decoded     = json_decode($purposeList, true);
                                $purposeList = is_array($decoded) ? $decoded : [$purposeList];
                            }

                            $purposeOthers = $step1['purpose_others'] ?? null;
                            $purposeText   = !empty($purposeOthers)
                                ? $purposeOthers
                                : (!empty($purposeList) ? implode(', ', $purposeList) : 'N/A');

                            $applicantName = $app->applicant->first_name ?? ($app->applicant->name ?? 'N/A');
                            $applicantLast = $app->applicant->last_name ?? '';
                            $fullName      = trim($applicantName . ' ' . $applicantLast);
                            $initials      = strtoupper(substr($applicantName,0,1) . substr($applicantLast,0,1));

                            $approverName    = $app->approvedBy->name ?? ($app->approvedBy->first_name ?? 'N/A');
                            $approverInitial = strtoupper(substr($approverName,0,1));
                        @endphp
                        <tr>
                            {{-- # --}}
                            <td class="text-center">
                                <div class="row-num">{{ $applications->firstItem() + $index }}</div>
                            </td>

                            {{-- Applicant --}}
                            <td>
                                <div class="applicant-cell">
                                    <div class="applicant-avatar">{{ $initials }}</div>
                                    <span class="applicant-name">{{ $fullName }}</span>
                                </div>
                            </td>

                            {{-- IP Group --}}
                            <td>
                                <span class="badge-ip">{{ ucfirst($ipGroup) }}</span>
                            </td>

                            {{-- Purpose --}}
                            <td>
                                <span class="purpose-text" title="{{ $purposeText }}">
                                    {{ $purposeText }}
                                </span>
                            </td>

                            {{-- Approved By --}}
                            <td>
                                <div class="approved-by-cell">
                                    <div class="approver-avatar">{{ $approverInitial }}</div>
                                    <span class="approver-name">{{ $approverName }}</span>
                                </div>
                            </td>

                            {{-- Approved Date --}}
                            <td>
                                <span class="date-val">
                                    {{ $app->approved_at ? date('M d, Y', strtotime($app->approved_at)) : 'N/A' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>No audit logs found.</p>
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
        <div id="paginationWrapper">
            {{ $applications->links('pagination::bootstrap-4') }}
        </div>
    </div>

</div>

<script>
let isSearching = false;

// ── Init ─────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    updatePaginationLinks();
});

// ── Search ────────────────────────────────────────────────
document.getElementById('searchInput').addEventListener('keyup', function () {
    const query = this.value.trim();

    if (query === '') {
        isSearching = false;
        location.reload();
        return;
    }

    isSearching = true;
    performSearch(query, 1);
});

// ── Pagination click handler ──────────────────────────────
document.addEventListener('click', function (e) {
    const link = e.target.closest('.pagination a');
    if (!link) return;

    e.preventDefault();
    const href = link.getAttribute('href') || link.dataset.page;

    if (isSearching) {
        const query = document.getElementById('searchInput').value;
        // Extract page number from data-page attribute (search pagination)
        const page = link.dataset.page || new URLSearchParams(new URL(href, window.location.origin).search).get('page') || 1;
        performSearch(query, page);
    } else {
        window.location.href = href;
    }
});

// ── AJAX Search ───────────────────────────────────────────
function performSearch(query, page) {
    const url = `{{ route('admin.audit.trail.search') }}?query=${encodeURIComponent(query)}&page=${page}`;

    fetch(url)
        .then(r => r.json())
        .then(res => {
            const tbody = document.getElementById('auditBody');
            tbody.innerHTML = '';

            // Update stats pill
            document.getElementById('statsCount').innerHTML = `
                <i class="fas fa-clipboard-check" style="color:var(--green-500);"></i>
                <strong style="color:var(--green-500);font-family:'DM Mono',monospace;">${res.total || 0}</strong>
                <span>Log(s)</span>
            `;

            if (!res.data || res.data.length === 0) {
                tbody.innerHTML = `
                    <tr><td colspan="6">
                        <div class="empty-state">
                            <i class="fas fa-search"></i>
                            <p>No results found.</p>
                        </div>
                    </td></tr>`;
                document.getElementById('paginationWrapper').innerHTML = '';
                document.getElementById('paginationInfo').textContent = 'No entries found';
                return;
            }

            res.data.forEach((app, index) => {
                const rowNum   = (res.current_page - 1) * res.per_page + index + 1;
                const initials = getInitials(app.applicant || '');
                const approverInit = (app.approved_by || 'A').charAt(0).toUpperCase();

                tbody.innerHTML += `
                    <tr>
                        <td class="text-center">
                            <div class="row-num">${rowNum}</div>
                        </td>
                        <td>
                            <div class="applicant-cell">
                                <div class="applicant-avatar">${initials}</div>
                                <span class="applicant-name">${app.applicant || 'N/A'}</span>
                            </div>
                        </td>
                        <td><span class="badge-ip">${ucfirst(app.ip_group || 'N/A')}</span></td>
                        <td><span class="purpose-text" title="${app.purpose || ''}">${app.purpose || 'N/A'}</span></td>
                        <td>
                            <div class="approved-by-cell">
                                <div class="approver-avatar">${approverInit}</div>
                                <span class="approver-name">${app.approved_by || 'N/A'}</span>
                            </div>
                        </td>
                        <td><span class="date-val">${app.approved_at || 'N/A'}</span></td>
                    </tr>
                `;
            });

            // Update pagination info
            const from = (res.current_page - 1) * res.per_page + 1;
            const to   = Math.min(res.current_page * res.per_page, res.total);
            document.getElementById('paginationInfo').textContent =
                `Showing ${from} to ${to} of ${res.total} entries`;

            buildPagination(res, query);
        })
        .catch(err => {
            console.error('Search error:', err);
            document.getElementById('auditBody').innerHTML = `
                <tr><td colspan="6">
                    <div class="empty-state">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>Error loading results. Please try again.</p>
                    </div>
                </td></tr>`;
        });
}

// ── Build AJAX Pagination ─────────────────────────────────
function buildPagination(res, query) {
    if (res.last_page <= 1) {
        document.getElementById('paginationWrapper').innerHTML = '';
        return;
    }

    let html = '<nav><ul class="pagination">';

    // Prev
    if (res.current_page > 1) {
        html += `<li class="page-item"><a class="page-link" href="#" data-page="${res.current_page - 1}"><i class="fas fa-chevron-left" style="font-size:11px;"></i></a></li>`;
    } else {
        html += `<li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-left" style="font-size:11px;"></i></span></li>`;
    }

    // Pages
    const start = Math.max(1, res.current_page - 2);
    const end   = Math.min(res.last_page, res.current_page + 2);

    for (let i = start; i <= end; i++) {
        if (i === res.current_page) {
            html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
        } else {
            html += `<li class="page-item"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
        }
    }

    // Next
    if (res.current_page < res.last_page) {
        html += `<li class="page-item"><a class="page-link" href="#" data-page="${res.current_page + 1}"><i class="fas fa-chevron-right" style="font-size:11px;"></i></a></li>`;
    } else {
        html += `<li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-right" style="font-size:11px;"></i></span></li>`;
    }

    html += '</ul></nav>';
    document.getElementById('paginationWrapper').innerHTML = html;
}

// ── Update server-rendered pagination links ───────────────
function updatePaginationLinks() {
    document.querySelectorAll('.pagination a').forEach(link => {
        link.addEventListener('click', function (e) {
            if (!isSearching) {
                // Let normal navigation happen
            }
        });
    });
}

// ── Helpers ───────────────────────────────────────────────
function getInitials(name) {
    const parts = name.trim().split(' ');
    if (parts.length >= 2) return (parts[0].charAt(0) + parts[parts.length - 1].charAt(0)).toUpperCase();
    return name.charAt(0).toUpperCase();
}

function ucfirst(str) {
    if (!str) return '';
    return str.charAt(0).toUpperCase() + str.slice(1);
}
</script>

@endsection