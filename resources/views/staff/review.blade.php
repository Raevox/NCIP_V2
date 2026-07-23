@extends('layouts.staff')

@section('title', 'Review Applications')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>

<style>
:root {
    --green-900: #1a3d0f;
    --green-700: #2d6a1f;
    --green-500: #3E7B27;
    --green-400: #52a033;
    --green-300: #7cc05a;
    --green-100: #e8f5e2;
    --green-50:  #f4fbf0;
    --sand-100: #f7f5f0;
    --sand-200: #ede9e0;
    --text-dark: #1a1f16;
    --text-mid:  #4a5245;
    --text-soft: #8a9485;
}

body, .main {
    font-family: 'Poppins', sans-serif;
    background-color: #fff
}

.review-header {
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
}

.review-header h2 {
    font-size: 26px;
    font-weight: 700;
    color: #2d6a1f;
    display: flex;
    align-items: center;
    gap: 12px;
    letter-spacing: -0.4px;
    margin: 0;
}

/* ===== Filter Card ===== */
.filter-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    border: 1px solid var(--sand-200);
    margin-bottom: 24px;
    overflow: hidden;
}

.filter-header {
    background: linear-gradient(135deg, var(--green-500) 0%, var(--green-700) 100%);
    padding: 16px 20px;
    border-bottom: none;
}

.filter-header h6 {
    color: white;
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}

.filter-body {
    padding: 24px;
    background: var(--sand-100);
}

.filter-body .form-label {
    font-size: 13px;
    font-weight: 600;
    color: #333;
    margin-bottom: 6px;
}

.filter-body .form-control,
.filter-body .form-select {
    border: 2px solid #e5e5e5;
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.filter-body .form-control:focus,
.filter-body .form-select:focus {
    border-color: var(--green-500);
    box-shadow: 0 0 0 3px rgba(62, 123, 39, 0.1);
    outline: none;
}

.btn-green {
    background: var(--green-500);
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    cursor: pointer;
}

.btn-green:hover {
    background: var(--green-700);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(62, 123, 39, 0.3);
    text-decoration: none;
}

.btn-green-outline {
    background: white;
    color: var(--green-500);
    border: 2px solid var(--green-500);
    padding: 8px 20px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    cursor: pointer;
}

.btn-green-outline:hover {
    background: var(--green-500);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(62, 123, 39, 0.3);
    text-decoration: none;
}

.filter-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: space-between;
    align-items: center;
}

.action-group {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

@media (max-width: 768px) {
    .filter-actions {
        flex-direction: column;
        align-items: stretch;
    }
    .action-group {
        width: 100%;
    }
    .btn-green,
    .btn-green-outline {
        width: 100%;
        justify-content: center;
    }
}
/* ===== End Filter Card ===== */

.tabs-container {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    border: 1px solid var(--sand-200);
    overflow: hidden;
}

.tabs-nav {
    display: flex;
    background: var(--sand-100);
    border-bottom: 2px solid var(--sand-200);
    padding: 0;
}

.tab-item {
    flex: 1;
    text-align: center;
}

.tab-link {
    display: block;
    padding: 16px 20px;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-mid);
    text-decoration: none;
    border-bottom: 3px solid transparent;
    transition: all 0.2s;
    cursor: pointer;
}

.tab-link:hover {
    background: rgba(62, 123, 39, 0.05);
    color: var(--green-500);
}

.tab-link.active {
    background: #fff;
    color: var(--green-500);
    border-bottom-color: var(--green-500);
}

.tab-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 700;
    margin-left: 8px;
}

.tab-link.active .tab-badge { background: var(--green-100); color: var(--green-700); }
.tab-link:not(.active) .tab-badge { background: var(--sand-200); color: var(--text-soft); }

.tab-content-wrapper {
    padding: 24px;
}

.tab-pane {
    display: none;
}

.tab-pane.active {
    display: block;
}

.review-table {
    width: 100%;
    border-collapse: collapse;
}

.review-table thead tr {
    border-bottom: 2px solid var(--sand-200);
}

.review-table th {
    padding: 12px 16px;
    text-align: left;
    font-weight: 600;
    color: var(--text-soft);
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}

.review-table td {
    padding: 16px;
    border-bottom: 1px solid var(--sand-100);
    font-size: 14px;
    color: var(--text-dark);
}

.review-table tbody tr:hover {
    background-color: var(--green-50);
}

.name-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}

.name-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--green-400), var(--green-700));
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    display: grid;
    place-items: center;
}

.name-text {
    font-weight: 600;
    color: var(--text-dark);
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-badge.under-review {
    background: #fff8e1;
    color: #b45309;
}

.status-badge.approved {
    background: #ecfdf5;
    color: #065f46;
}

.status-badge.returned {
    background: #fef2f2;
    color: #991b1b;
}

.date-text {
    font-size: 13px;
    color: var(--text-soft);
}

.btn-view {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border: 1.5px solid var(--green-300);
    border-radius: 8px;
    color: var(--green-500);
    font-size: 13px;
    font-weight: 600;
    background: #fff;
    text-decoration: none;
    transition: all 0.15s;
}

.btn-view:hover {
    background: var(--green-500);
    color: #fff;
    border-color: var(--green-500);
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: var(--text-soft);
}

.empty-state i {
    font-size: 48px;
    opacity: 0.25;
    display: block;
    margin-bottom: 16px;
}

.pagination-wrapper {
    margin-top: 24px;
    display: flex;
    justify-content: center;
}
</style>

<div class="main" style="padding: 24px;">
    <!-- Header -->
    <div class="review-header">
        <h2>
            <i class="fas fa-clipboard-check"></i>
            Review Applications
        </h2>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <div class="filter-header">
            <h6>
                <i class="fas fa-filter"></i>
                Filter Applications
            </h6>
        </div>
        <div class="filter-body">
            <form method="GET" action="{{ route('staff.review') }}" id="filterForm">

                <div class="row g-3 mb-3">
                    <!-- Applicant Name -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Applicant Name</label>
                        <input type="text"
                               name="search"
                               id="searchInput"
                               placeholder="First or last name"
                               value="{{ request('search') }}"
                               class="form-control"
                               autocomplete="off">
                    </div>

                    <!-- Municipality -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Municipality</label>
                        <select name="municipality" id="municipalitySelect" class="form-select">
                            <option value="">All</option>
                            @foreach($municipalities ?? [] as $municipality)
                                <option value="{{ $municipality }}" {{ request('municipality') == $municipality ? 'selected' : '' }}>
                                    {{ $municipality }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date -->
                    <div class="col-lg-2 col-md-4">
                        <label class="form-label">Date</label>
                        <input type="date"
                               name="date"
                               id="dateInput"
                               class="form-control"
                               value="{{ request('date') }}">
                    </div>

                    <!-- Place of Origin -->
                    <div class="col-lg-2 col-md-4">
                        <label class="form-label">Place of Origin</label>
                        <input type="text"
                               name="place_origin"
                               id="placeOriginInput"
                               placeholder="e.g. Nueva Ecija"
                               value="{{ request('place_origin') }}"
                               class="form-control"
                               autocomplete="off">
                    </div>

                    <!-- Purpose -->
                    <div class="col-lg-3 col-md-4">
                        <label class="form-label">Purpose</label>
                        <select name="purpose" id="purposeSelect" class="form-select">
                            <option value="">All</option>
                            @php
                                $purposeOptions = [
                                    'Scholarship (SCH)','Local Employment (LE)','Land Matter (LM)','Civil Service Commission (CSC)',
                                    'NAPOLCOM Requirement (PNP)','BJMP: Age Waiver (AW)','BuCor: Age Waiver (AW)','BFP: Age Waiver (AW)',
                                    'AFP: Age Waiver (AW)','IPMR (IPMR)','Cert. of Tribal Marriage (CTM)','Travel Abroad (TA)'
                                ];
                            @endphp
                            @foreach($purposeOptions as $purpose)
                                <option value="{{ $purpose }}" {{ request('purpose') == $purpose ? 'selected' : '' }}>
                                    {{ $purpose }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="filter-actions">
                    <div class="action-group">
                        <button type="submit" class="btn-green">
                            <i class="fas fa-filter"></i>
                            Apply Filters
                        </button>
                        <a href="{{ route('staff.review') }}" class="btn-green-outline" id="resetFiltersBtn">
                            <i class="fas fa-redo"></i>
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="tabsWrapper">
        @include('staff.partials.review-tabs-content')
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const municipalitySelect = document.getElementById('municipalitySelect');
    const dateInput = document.getElementById('dateInput');
    const placeOriginInput = document.getElementById('placeOriginInput');
    const purposeSelect = document.getElementById('purposeSelect');
    const filterForm = document.getElementById('filterForm');
    const tabsWrapper = document.getElementById('tabsWrapper');

    let currentTab = 'underReview';
    let debounceTimeout;

    // ----- Tab switching (delegated so it survives AJAX re-renders) -----
    tabsWrapper.addEventListener('click', function(e) {
        const link = e.target.closest('.tab-link');
        if (!link) return;
        e.preventDefault();

        currentTab = link.dataset.tab;

        tabsWrapper.querySelectorAll('.tab-link').forEach(l => l.classList.remove('active'));
        tabsWrapper.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));

        link.classList.add('active');
        const pane = document.getElementById(currentTab);
        if (pane) pane.classList.add('active');
    });

    // ----- AJAX filter (realtime) -----
    function performSearch() {
        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData);

        fetch('{{ route("staff.review") }}?ajax=1&' + params.toString(), {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html',
            },
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok: ' + response.status);
            return response.text();
        })
        .then(html => {
            tabsWrapper.innerHTML = html;

            // Restore active tab after the DOM swap
            tabsWrapper.querySelectorAll('.tab-link').forEach(l => l.classList.remove('active'));
            tabsWrapper.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));

            const activeLink = tabsWrapper.querySelector(`.tab-link[data-tab="${currentTab}"]`);
            const activePane = document.getElementById(currentTab);
            if (activeLink) activeLink.classList.add('active');
            if (activePane) activePane.classList.add('active');
        })
        .catch(error => {
            console.error('Filter error:', error);
        });
    }

    function debouncedSearch() {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(performSearch, 500);
    }

    // Realtime triggers
    searchInput.addEventListener('input', debouncedSearch);
    placeOriginInput.addEventListener('input', debouncedSearch);
    municipalitySelect.addEventListener('change', performSearch);
    purposeSelect.addEventListener('change', performSearch);
    dateInput.addEventListener('change', performSearch);

    // Apply button still works, but now via AJAX instead of full reload
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        performSearch();
    });

    // Reset button: clear fields, then run AJAX search instead of navigating away
    document.getElementById('resetFiltersBtn').addEventListener('click', function(e) {
        e.preventDefault();
        filterForm.reset();
        performSearch();
    });

    // Pagination links inside the tabs partial (AJAX-aware)
    tabsWrapper.addEventListener('click', function(e) {
        const pageLink = e.target.closest('.pagination a');
        if (!pageLink) return;
        e.preventDefault();

        const url = pageLink.href + (pageLink.href.includes('?') ? '&' : '?') + 'ajax=1';

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            tabsWrapper.innerHTML = html;
            tabsWrapper.querySelectorAll('.tab-link').forEach(l => l.classList.remove('active'));
            tabsWrapper.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
            const activeLink = tabsWrapper.querySelector(`.tab-link[data-tab="${currentTab}"]`);
            const activePane = document.getElementById(currentTab);
            if (activeLink) activeLink.classList.add('active');
            if (activePane) activePane.classList.add('active');
        })
        .catch(error => console.error('Pagination error:', error));
    });
});
</script>
@endsection