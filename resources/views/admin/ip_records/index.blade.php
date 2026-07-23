@extends('layouts.admin')

@section('title', 'IP Records')

@section('content')
<style>
:root {
    --primary-green:  #2E7D46;;
    --primary-green-hover: #2f5f1e;
    --primary-green-light: #f0f7ed;
}
body, .IP-content {
    font-family: 'Poppins', sans-serif;
    background-color: #fff;
    color: var(--text-dark);
    margin:10px;
}
.filter-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    margin-bottom: 24px;
    overflow: hidden;
}

.filter-header {
    background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-hover) 100%);
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
    background: #f8f9fa;
}

.form-label {
    font-size: 13px;
    font-weight: 600;
    color: #333;
    margin-bottom: 6px;
}

.form-control,
.form-select {
    border: 2px solid #e5e5e5;
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-control:focus,
.form-select:focus {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(62, 123, 39, 0.1);
    outline: none;
}

.search-wrapper {
    position: relative;
}

.clear-search-btn {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6c757d;
    padding: 4px 8px;
    cursor: pointer;
    transition: color 0.2s;
}

.clear-search-btn:hover {
    color: var(--primary-green);
}

.btn-green {
    background: var(--primary-green);
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
}

.btn-green:hover {
    background: var(--primary-green-hover);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(62, 123, 39, 0.3);
    text-decoration: none;
}

.btn-green-outline {
    background: white;
    color: var(--primary-green);
    border: 2px solid var(--primary-green);
    padding: 8px 20px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
}

.btn-green-outline:hover {
    background: var(--primary-green);
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

.loading-spinner {
    text-align: center;
    padding: 40px 20px;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
    border-width: 0.3em;
}

.spinner-border.text-success {
    color: var(--primary-green) !important;
}

.results-count {
    margin-bottom: 16px;
}

.results-count p {
    color: #6c757d;
    font-size: 14px;
    margin: 0;
}

.table-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
}

.ip-table {
    margin: 0;
    width: 100%;
}

.ip-table thead th {
    background-color: var(--primary-green);
    color: #fff;
    font-weight: 600;
    padding: 16px 12px;
    border: none;
    font-size: 14px;
}

.ip-table tbody td {
    padding: 16px 12px;
    vertical-align: middle;
    font-size: 14px;
    border-bottom: 1px solid #f0f0f0;
}

.ip-table tbody tr {
    transition: background 0.2s ease;
}

.ip-table tbody tr:hover {
    background: #f8fdf5;
}

.ip-table .btn-action-dots {
    border: none;
    background: none;
    color: #6c757d;
    padding: 4px 8px;
}

.ip-table .btn-action-dots:hover {
    background: #f8f9fa;
    border-radius: 4px;
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
</style>

<div class="IP-content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Card -->
    <div class="filter-card">
        <div class="filter-header">
            <h6>
                <i class="fas fa-filter"></i>
                Filter Records
            </h6>
        </div>
        <div class="filter-body">
            <form method="GET" action="{{ route('ip_records.index') }}" id="filterForm">
                <div class="row g-3 mb-3">
                    <!-- Search -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Search</label>
                        <div class="search-wrapper">
                            <input type="text" 
                                   name="search" 
                                   id="searchInput" 
                                   placeholder="Name, address, or IP group" 
                                   value="{{ request('search') }}" 
                                   class="form-control" 
                                   autocomplete="off">
                            <button type="button" 
                                    id="clearSearch" 
                                    class="clear-search-btn" 
                                    style="display: {{ request('search') ? 'block' : 'none' }};">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Municipality -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Municipality</label>
                        <select name="municipality" class="form-select">
                            <option value="">All</option>
                            @foreach($municipalities as $municipality)
                                <option value="{{ $municipality }}" {{ request('municipality') == $municipality ? 'selected' : '' }}>
                                    {{ $municipality }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- IP Group -->
                    <div class="col-lg-2 col-md-4">
                        <label class="form-label">IP Group</label>
                        <select name="ip_group" class="form-select">
                            <option value="">All</option>
                            @foreach($ipGroups as $group)
                                <option value="{{ $group }}" {{ request('ip_group') == $group ? 'selected' : '' }}>
                                    {{ $group }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Month -->
                    <div class="col-lg-2 col-md-4">
                        <label class="form-label">Month</label>
                        <select name="month" class="form-select">
                            <option value="">All Months</option>
                            @foreach(range(1, 12) as $month)
                                <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Year -->
                    <div class="col-lg-2 col-md-4">
                        <label class="form-label">Year</label>
                        <select name="year" class="form-select">
                            <option value="">All Years</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
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
                        <button type="button" id="resetFilters" class="btn-green-outline">
                            <i class="fas fa-redo"></i>
                            Reset
                        </button>
                        <button type="button" id="exportCsv" class="btn-green">
                            <i class="fas fa-download"></i>
                            Export CSV
                        </button>
                    </div>
                    <div class="action-group">
                        <a href="{{ route('ip_records.create') }}" class="btn-green">
                            <i class="fas fa-plus"></i>
                            Add New Record
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="loading-spinner" style="display: none;">
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3 text-muted">Searching records...</p>
    </div>

    <!-- Results Count -->
    <div id="resultsCount" class="results-count">
        @if($records->total() > 0)
            <p>Showing {{ $records->firstItem() }} to {{ $records->lastItem() }} of {{ $records->total() }} records</p>
        @endif
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div id="tableContainer">
            @include('admin.ip_records.partials.table')
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const clearButton = document.getElementById('clearSearch');
    const filterForm = document.getElementById('filterForm');
    const tableContainer = document.getElementById('tableContainer');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const resetButton = document.getElementById('resetFilters');
    const exportCsvButton = document.getElementById('exportCsv');
    
    let searchTimeout;

    function toggleClearButton() {
        if (searchInput.value.trim().length > 0) {
            clearButton.style.display = 'block';
        } else {
            clearButton.style.display = 'none';
        }
    }

    toggleClearButton();
    
    function performSearch() {
        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData);
        
        loadingSpinner.style.display = 'block';
        tableContainer.style.opacity = '0.6';
        
        const url = '{{ route("ip_records.index") }}?ajax=1&' + params.toString();
        
        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html',
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.status);
            }
            return response.text();
        })
        .then(html => {
            tableContainer.innerHTML = html;
            loadingSpinner.style.display = 'none';
            tableContainer.style.opacity = '1';
            updateResultsCount();
        })
        .catch(error => {
            console.error('Error:', error);
            loadingSpinner.style.display = 'none';
            tableContainer.style.opacity = '1';
            tableContainer.innerHTML = `
                <div class="alert alert-danger m-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error loading results. Please try refreshing the page.
                </div>
            `;
        });
    }

    function updateResultsCount() {
        const noRecordsElement = tableContainer.querySelector('td.text-center');
        const hasNoRecords = noRecordsElement && noRecordsElement.textContent.includes('No records found');
        
        const dataRows = tableContainer.querySelectorAll('tbody tr');
        const hasDataRows = dataRows.length > 0 && !hasNoRecords;
        
        if (hasDataRows) {
            const paginationInfo = tableContainer.querySelector('.pagination-container .text-muted');
            if (paginationInfo) {
                document.getElementById('resultsCount').innerHTML = `<p>${paginationInfo.textContent}</p>`;
            } else {
                document.getElementById('resultsCount').innerHTML = `<p>Showing ${dataRows.length} record(s)</p>`;
            }
        } else {
            document.getElementById('resultsCount').innerHTML = '<p>No records found</p>';
        }
    }

    function exportToCSV() {
        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData);
        
        const originalText = exportCsvButton.innerHTML;
        exportCsvButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Exporting...';
        exportCsvButton.disabled = true;
        
        const downloadUrl = '{{ route("ip_records.download") }}?' + params.toString();
        
        console.log('Exporting with filters:', params.toString());

        const link = document.createElement('a');
        link.href = downloadUrl;
        link.target = '_blank';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        setTimeout(() => {
            exportCsvButton.innerHTML = originalText;
            exportCsvButton.disabled = false;
        }, 2000);
    }

    searchInput.addEventListener('input', function() {
        toggleClearButton();
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performSearch();
        }, 800);
    });

    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        toggleClearButton();
        performSearch();
    });

    resetButton.addEventListener('click', function() {
        filterForm.reset();
        toggleClearButton();
        performSearch();
    });
   
    exportCsvButton.addEventListener('click', exportToCSV);

    document.querySelectorAll('select[name="municipality"], select[name="ip_group"], select[name="month"], select[name="year"]').forEach(select => {
        select.addEventListener('change', function() {
            performSearch();
        });
    });

    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        performSearch();
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            const url = e.target.closest('a').href;
            
            loadingSpinner.style.display = 'block';
            tableContainer.style.opacity = '0.6';
            
            fetch(url + '&ajax=1', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.text())
            .then(html => {
                tableContainer.innerHTML = html;
                loadingSpinner.style.display = 'none';
                tableContainer.style.opacity = '1';
                updateResultsCount();
            })
            .catch(error => {
                console.error('Error:', error);
                loadingSpinner.style.display = 'none';
                tableContainer.style.opacity = '1';
            });
        }
    });

    updateResultsCount();
});
</script>
@endsection
