@extends('layouts.admin')

@section('title', 'News & Updates')

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
body, .news-content {
    font-family: 'Poppins', sans-serif;
    background-color: #fff;
    color: var(--text-dark);
    margin: 10px;
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
.btn-add {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 18px;
    background: var(--green-500);
    color: #fff;
    border: none;
    border-radius: var(--radius-sm);
    font-family: 'Poppins', sans-serif;
    font-size: 13.5px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.18s;
    box-shadow: 0 2px 8px rgba(46,125,70,0.25);
}
.btn-add:hover {
    background: var(--green-700);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(46,125,70,0.35);
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
    padding: 9px 38px 9px 38px;
    border: 1.5px solid var(--sand-200);
    border-radius: var(--radius-sm);
    font-family: 'Poppins', sans-serif;
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
    left: 12px; top: 50%;
    transform: translateY(-50%);
    color: var(--text-soft);
    font-size: 13px;
    pointer-events: none;
}
.search-spinner {
    position: absolute;
    right: 12px; top: 50%;
    transform: translateY(-50%);
    display: none;
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
.stats-pill i { color: var(--green-500); }
.stats-pill strong { color: var(--green-500); }

/* ── Table Card ──────────────────────────── */
.table-card {
    background: var(--white);
    border-radius: var(--radius-md);
    border: 1px solid var(--sand-200);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.news-table { margin: 0; width: 100%; }
.news-table thead th {
    background-color: #2E7D46;
    color: #fff;
    font-weight: 600;
    padding: 14px 16px;
    border: none;
    font-size: 13.5px;
}
.news-table tbody td {
    padding: 12px 16px;
    vertical-align: middle;
    font-size: 13.5px;
    border-bottom: 1px solid #f0f0f0;
}
.news-table tbody tr { transition: background 0.2s ease; }
.news-table tbody tr:hover { background: #f8fdf5; }
.news-table tbody tr:last-child td { border-bottom: none; }

/* Title cell */
.news-title-cell { display: flex; align-items: center; gap: 10px; }
.news-thumb {
    width: 56px; height: 44px;
    border-radius: 6px;
    object-fit: cover;
    flex-shrink: 0;
    background: var(--sand-200);
}
.news-thumb-placeholder {
    width: 56px; height: 44px;
    border-radius: 6px;
    background: linear-gradient(135deg, var(--green-400), var(--green-700));
    display: grid;
    place-items: center;
    color: #fff;
    font-size: 16px;
    flex-shrink: 0;
}
.news-title-text { font-weight: 600; color: var(--text-dark); font-size: 13px; line-height: 1.3; }
.news-date-text  { font-size: 11.5px; color: var(--text-soft); margin-top: 2px; }

/* Status badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 600;
    white-space: nowrap;
}
.status-published { background: #ecfdf5; color: #065f46; }
.status-draft     { background: #f3f4f6; color: #374151; }

/* Action Buttons */
.action-cell { display: flex; align-items: center; gap: 6px; }
.btn-edit {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    border-radius: var(--radius-sm);
    border: 1.5px solid #93c5fd;
    background: #eff6ff;
    color: #1d4ed8;
    font-family: 'Poppins', sans-serif;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.18s;
    white-space: nowrap;
}
.btn-edit:hover { background: #1d4ed8; color: #fff; border-color: #1d4ed8; }
.btn-delete {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    border-radius: var(--radius-sm);
    border: 1.5px solid #fca5a5;
    background: #fef2f2;
    color: #dc2626;
    font-family: 'Poppins', sans-serif;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.18s;
    white-space: nowrap;
}
.btn-delete:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

/* Empty state */
.empty-state {
    padding: 60px 20px;
    text-align: center;
    color: var(--text-soft);
}
.empty-state i { font-size: 44px; opacity: 0.2; margin-bottom: 14px; display: block; }
.empty-state p { font-size: 15px; font-weight: 500; }

/* Pagination */
.pagination-row {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}
.pagination-info { font-size: 13px; color: var(--text-soft); }
.custom-pagination {
    display: flex;
    align-items: center;
    gap: 4px;
    list-style: none;
    margin: 0; padding: 0;
}
.custom-pagination .page-item .page-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 34px; height: 34px;
    padding: 0 10px;
    border-radius: var(--radius-sm);
    border: 1.5px solid var(--sand-200);
    background: var(--white);
    color: var(--text-mid);
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.18s;
    cursor: pointer;
}
.custom-pagination .page-item .page-link:hover { background: var(--green-100); border-color: var(--green-400); color: var(--green-700); }
.custom-pagination .page-item.active .page-link { background: var(--green-500); border-color: var(--green-500); color: #fff; font-weight: 600; }
.custom-pagination .page-item.disabled .page-link { opacity: 0.45; cursor: not-allowed; pointer-events: none; }

/* Modal */
.modal-content { border: none; border-radius: var(--radius-md); overflow: hidden; font-family: 'Poppins', sans-serif; }
.modal-header  { border-bottom: none; padding: 20px 24px 16px; }
.modal-body    { padding: 20px 24px; }
.modal-footer  { border-top: 1px solid var(--sand-200); padding: 16px 24px; }
.modal-icon {
    width: 64px; height: 64px;
    border-radius: 50%;
    display: grid; place-items: center;
    margin: 0 auto 16px;
    font-size: 26px;
    background: #fef2f2; color: #ef4444;
}

@media (max-width: 768px) {
    .controls-bar { flex-direction: column; align-items: stretch; }
    .search-wrapper { width: 100%; }
}
</style>

<div class="news-content">

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert"
             style="border-radius: var(--radius-sm); border: none; font-family: 'Poppins', sans-serif;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="page-header">
        <h2>
            <span class="header-icon"><i class="fas fa-newspaper"></i></span>
            News Management
        </h2>
        <a href="{{ route('admin.news.create') }}" class="btn-add" id="addNewsBtn">
            <i class="fas fa-plus"></i> Add News
        </a>
    </div>

    {{-- Controls --}}
    <div class="controls-bar">
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input
                type="text"
                id="searchInput"
                placeholder="Search by title or description..."
                value="{{ $search }}"
                autocomplete="off"
            />
            <div class="spinner-border spinner-border-sm text-success search-spinner" id="searchSpinner" role="status"></div>
        </div>
        <div class="stats-pill">
            <i class="fas fa-newspaper"></i>
            <strong id="articleCount">{{ $news->total() }}</strong>
            <span>Article(s) found</span>
        </div>
    </div>

    {{-- Dynamic Table Container --}}
    <div id="tableContainer">
        @include('admin.news.partials.table')
    </div>

</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="font-family:'Poppins',sans-serif;">Delete News Article</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div class="modal-icon">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <h6 class="fw-bold mb-2" style="font-family:'Poppins',sans-serif;">Are you sure?</h6>
                <p style="font-size: 13.5px; color: var(--text-mid);">
                    You are about to permanently delete <strong id="deleteNewsTitle"></strong>.
                    This action cannot be undone.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, title) {
    document.getElementById('deleteNewsTitle').textContent = title;
    document.getElementById('deleteForm').action = '/admin/news/' + id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// ── Live AJAX Search + Pagination ──────────────────────────────────
let searchTimer;
const searchInput   = document.getElementById('searchInput');
const searchSpinner = document.getElementById('searchSpinner');

function fetchNewsData(url = '{{ route("admin.news.index") }}') {
    searchSpinner.style.display = 'block';
    const queryUrl = new URL(url, window.location.origin);
    queryUrl.searchParams.set('search', searchInput.value.trim());

    fetch(queryUrl.toString(), {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        searchSpinner.style.display = 'none';
        document.getElementById('tableContainer').innerHTML = data.html;
        document.getElementById('articleCount').textContent = data.total;
    })
    .catch(() => {
        searchSpinner.style.display = 'none';
    });
}

function clearSearch() {
    searchInput.value = '';
    fetchNewsData();
}

searchInput.addEventListener('input', function () {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => fetchNewsData(), 350);
});

// Intercept pagination clicks for smooth AJAX page switching
document.getElementById('tableContainer').addEventListener('click', function (e) {
    const link = e.target.closest('.custom-pagination a.page-link');
    if (link && link.href) {
        e.preventDefault();
        fetchNewsData(link.href);
    }
});
</script>

@endsection
