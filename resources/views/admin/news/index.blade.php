@extends('layouts.admin')

@section('title', 'News and Events')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --primary-green: #2E7D46;
    --primary-green-hover: #2f5f1e;
    --primary-green-light: #f0f7ed;
}
body, .news-content {
    font-family: 'Poppins', sans-serif;
    background-color: #fff;
    color: var(--text-dark);
    margin:10px;
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
.page-header {
    display: flex;
    /* justify-content: space-between; */
    justify-content: end;
    align-items: center;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 16px;
}

.page-header h2 {
    font-size: 28px;
    font-weight: 600;
    color: #222;
    margin: 0;
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

.custom-table table th {
    color: #fff !important;
    font-size: 14px !important;
    background: #2E7D46 !important;
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

.news-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #e5e5e5;
}

.status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.status-published {
    background: #d4edda;
    color: #155724;
}

.status-draft {
    background: #e9ecef;
    color: #495057;
}

.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
}

.btn-edit {
    padding: 8px 16px;
    border-radius: 6px;
    background: var(--primary-green);
    color: white;
    border: none;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-edit:hover {
    background: var(--primary-green-hover);
    color: white;
}

.btn-delete {
    padding: 8px 16px;
    border-radius: 6px;
    background: #dc3545;
    color: white;
    border: none;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s ease;
    cursor: pointer;
}

.btn-delete:hover {
    background: #c82333;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .action-buttons {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-edit,
    .btn-delete {
        width: 100%;
    }
}
</style>

<div class="news-content">
    <div class="header">
       <h2><i class="fas fa-users me-2" style="color: var(--primary-green);"></i>News Management</h2>
    </div>

    <div class="page-header">
        <!-- Search Bar Left -->
        

        <!-- Add Button Right -->
        <a href="{{ route('admin.news.create') }}" class="add-btn">
            <i class="fas fa-plus me-2"></i>Add New
        </a>
    </div>

    <div class="custom-table">
        <table class="table table-striped ip-table">
        {{-- <table class="table mb-0"> --}}
            <thead>
                <tr>
                    <th class="ps-4">Title</th>
                    <th class="text-center">Image</th>
                    <th>Description</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Status</th>
                    <th class="text-center pe-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $item)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-semibold">{{ $item->title }}</div>
                        </td>
                        <td class="text-center">
                            @if($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}" class="news-image" alt="News Image">
                            @else
                                <div class="news-image d-flex align-items-center justify-content-center" style="background: #f8f9fa;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="text-muted">{{ Str::limit($item->description, 50) }}</span>
                        </td>
                        <td class="text-center">
                            <span class="text-muted">{{ $item->date }}</span>
                        </td>
                        <td class="text-center">
                            <span class="status-badge {{ $item->status == 'Published' ? 'status-published' : 'status-draft' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="text-center pe-4">
                            <div class="action-buttons">
                                <a href="{{ route('admin.news.edit', $item->id) }}" class="btn-edit">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('Delete this news?')">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                            <p class="mb-0">No news found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $news->links('pagination::bootstrap-4') }}
    </div>
</div>

@endsection
