@extends('layouts.applicant')
@section('title', 'COC History')
@section('page-title', 'COC History')
@section('content')

<style>
:root {
    --primary-green: #3E7B27;
    --primary-green-hover: #2f5f1e;
    --primary-green-light: #f0f7ed;
}

/* Main container spacing */
.main {
    padding-top: clamp(1rem, 4vw, 2.5rem) !important; 
    margin-bottom: 300px;
}

/* Card container */
.coc-history-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    margin-top: clamp(2rem, 4vw, 3rem) !important;
    margin-left: auto;
    margin-right: auto;
    padding: 0;
    max-width: 1000px;
    width: 95%;
    overflow: hidden;
}

/* Header */
.coc-header {
    background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-hover) 100%);
    color: white;
    font-size: clamp(1rem, 1.6vw, 1.3rem);
    font-weight: 600;
    padding: clamp(0.8rem, 2vw, 1.2rem) clamp(1rem, 2vw, 1.5rem);
}

/* Header text */
.coc-header h5 {
    margin: 0;
    font-size: clamp(1rem, 2vw, 1.3rem);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

/* Card body */
.card-body {
    padding: clamp(1rem, 2vw, 1.5rem);
}

/* Desktop Table */
.desktop-table {
    display: block;
}

.mobile-cards {
    display: none;
}

.custom-table {
    background: white;
    border-radius: 12px;
    overflow: hidden;
}

.custom-table table {
    width: 100%;
    margin: 0;
    font-size: clamp(0.75rem, 1.5vw, 0.95rem);
    border-collapse: collapse;
}

.custom-table thead {
    background: var(--primary-green);
}

.custom-table thead th {
    color: white !important;
    font-weight: 600;
    padding: clamp(0.8rem, 2vw, 1rem) clamp(0.5rem, 1.5vw, 0.8rem);
    font-size: clamp(0.8rem, 1.4vw, 0.95rem);
    border: none;
    text-align: center;
}

.custom-table tbody tr {
    border-bottom: 1px solid #f0f0f0;
    transition: background 0.2s ease;
}

.custom-table tbody tr:hover {
    background: #f8fdf5;
}

.custom-table tbody td {
    padding: clamp(0.8rem, 2vw, 1rem) clamp(0.5rem, 1.5vw, 0.8rem);
    vertical-align: middle;
    text-align: center;
    word-break: break-word;
}

/* Badge styling */
.status-badge {
    background: var(--primary-green-light);
    color: var(--primary-green);
    font-size: clamp(0.7rem, 1.2vw, 0.85rem);
    border-radius: 20px;
    padding: clamp(0.3rem, 1vw, 0.5rem) clamp(0.6rem, 1.5vw, 1rem);
    display: inline-block;
    white-space: nowrap;
    font-weight: 600;
}

/* Mobile Card Design */
.history-card-item {
    background: white;
    border: 2px solid #f0f0f0;
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.history-card-item:hover {
    border-color: var(--primary-green);
    box-shadow: 0 4px 12px rgba(62, 123, 39, 0.1);
}

.card-item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #f0f0f0;
}

.card-item-number {
    background: var(--primary-green);
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
}

.card-item-info {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.info-row {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.info-label {
    color: #6c757d;
    font-size: 0.8rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.info-value {
    color: #212529;
    font-weight: 600;
    font-size: 1rem;
    padding-left: 1.25rem;
}

/* Empty state */
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

/* Mobile Responsive - Switch to Cards */
@media (max-width: 768px) {
    .desktop-table {
        display: none;
    }
    
    .mobile-cards {
        display: block;
    }
    
    .coc-history-card {
        width: 100%;
        margin-top: 5.5rem !important;
    }
    
    .card-body {
        padding: 1rem;
    }
}

/* Extra small devices */
@media (max-width: 576px) {
    .coc-header h5 {
        font-size: 1rem;
    }
    
    .card-item-number {
        width: 28px;
        height: 28px;
        font-size: 0.8rem;
    }
    
    .info-label,
    .info-value {
        font-size: 0.8rem;
    }
    
    .status-badge {
        font-size: 0.7rem;
        padding: 0.3rem 0.6rem;
    }
}
</style>

<div class="coc-history-card">
    <!-- Header -->
    <div class="coc-header">
        <h5>
            <i class="fas fa-history"></i>
            My COC History
        </h5>
    </div>
    
    <!-- Body -->
    <div class="card-body">
        @if($cocHistory->isEmpty())
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>No approved COC forms yet.</p>
            </div>
        @else
            <!-- Desktop Table View -->
            <div class="desktop-table">
                <div class="custom-table">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Application No.</th>
                                <th>Status</th>
                                <th>Approved Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cocHistory as $index => $coc)
                            <tr>
                                <td>
                                    <span style="color: var(--primary-green); font-weight: 600;">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td class="fw-semibold">{{ $coc->id }}</td>
                                <td>
                                    <span class="status-badge">
                                        {{ $coc->status }}
                                    </span>
                                </td>
                                <td>
                                    @if($coc->status === 'Approved')
                                        {{ $coc->updated_at->format('M d, Y') }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($coc->status === 'Draft')
                                        <a href="{{ route('applicant.coc.step1') }}" class="btn btn-sm" style="background: var(--primary-green); color: white;">
                                            Continue
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Card View -->
            <div class="mobile-cards">
                @foreach($cocHistory as $index => $coc)
                <div class="history-card-item">
                    <div class="card-item-header">
                        <div class="card-item-number">{{ $index + 1 }}</div>
                        <span class="status-badge">{{ $coc->status }}</span>
                    </div>
                    
                    <div class="card-item-info">
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-hashtag" style="font-size: 0.7rem;"></i> 
                                Application No.
                            </span>
                            <span class="info-value">{{ $coc->id }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-calendar-check" style="font-size: 0.7rem;"></i> 
                                Approved Date
                            </span>
                            <span class="info-value">
                                @if($coc->status === 'Approved')
                                    {{ $coc->updated_at->format('M d, Y') }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </span>
                        </div>
                        @if($coc->status === 'Draft')
                            <div class="info-row">
                                <a href="{{ route('applicant.coc.step1') }}" class="btn btn-sm w-100" style="background: var(--primary-green); color: white;">
                                    Continue Filling Form
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
