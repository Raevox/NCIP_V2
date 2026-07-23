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
    background-color: var(--sand-100);
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
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 12px;
    letter-spacing: -0.4px;
    margin: 0;
}

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

    <!-- Tabs Container -->
    <div class="tabs-container">
        <!-- Tabs Navigation -->
        <div class="tabs-nav">
            <div class="tab-item">
                <a class="tab-link active" data-tab="underReview">
                    <i class="fas fa-hourglass-half"></i> Under Review
                    <span class="tab-badge" id="underReviewCount">{{ $underReview->total() }}</span>
                </a>
            </div>
            <div class="tab-item">
                <a class="tab-link" data-tab="approved">
                    <i class="fas fa-check-circle"></i> Approved
                    <span class="tab-badge" id="approvedCount">{{ $approved->total() }}</span>
                </a>
            </div>
            <div class="tab-item">
                <a class="tab-link" data-tab="returned">
                    <i class="fas fa-undo"></i> Returned
                    <span class="tab-badge" id="returnedCount">{{ $returned->total() }}</span>
                </a>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content-wrapper">
            <!-- Under Review Tab -->
            <div id="underReview" class="tab-pane active">
                @if($underReview->count() > 0)
                    <table class="review-table">
                        <thead>
                            <tr>
                                <th>Applicant</th>
                                <th>Date Submitted</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($underReview as $app)
                                @php
                                    $firstName = $app->applicant->first_name ?? 'N';
                                    $lastName  = $app->applicant->last_name ?? 'A';
                                    $initials  = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                                    $fullName  = trim($firstName . ' ' . $lastName);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="name-cell">
                                            <div class="name-avatar">{{ $initials }}</div>
                                            <span class="name-text">{{ $fullName }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="date-text">{{ $app->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td>
                                        <span class="status-badge under-review">Under Review</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('staff.review.show', $app->id) }}" class="btn-view">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    @if($underReview->hasPages())
                        <div class="pagination-wrapper">
                            {{ $underReview->links() }}
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>No applications under review</p>
                    </div>
                @endif
            </div>

            <!-- Approved Tab -->
            <div id="approved" class="tab-pane">
                @if($approved->count() > 0)
                    <table class="review-table">
                        <thead>
                            <tr>
                                <th>Applicant</th>
                                <th>Date Submitted</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approved as $app)
                                @php
                                    $firstName = $app->applicant->first_name ?? 'N';
                                    $lastName  = $app->applicant->last_name ?? 'A';
                                    $initials  = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                                    $fullName  = trim($firstName . ' ' . $lastName);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="name-cell">
                                            <div class="name-avatar">{{ $initials }}</div>
                                            <span class="name-text">{{ $fullName }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="date-text">{{ $app->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td>
                                        <span class="status-badge approved">Approved</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('staff.review.show', $app->id) }}" class="btn-view">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    @if($approved->hasPages())
                        <div class="pagination-wrapper">
                            {{ $approved->links() }}
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <i class="fas fa-check-circle"></i>
                        <p>No approved applications yet</p>
                    </div>
                @endif
            </div>

            <!-- Returned Tab -->
            <div id="returned" class="tab-pane">
                @if($returned->count() > 0)
                    <table class="review-table">
                        <thead>
                            <tr>
                                <th>Applicant</th>
                                <th>Date Submitted</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($returned as $app)
                                @php
                                    $firstName = $app->applicant->first_name ?? 'N';
                                    $lastName  = $app->applicant->last_name ?? 'A';
                                    $initials  = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                                    $fullName  = trim($firstName . ' ' . $lastName);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="name-cell">
                                            <div class="name-avatar">{{ $initials }}</div>
                                            <span class="name-text">{{ $fullName }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="date-text">{{ $app->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td>
                                        <span class="status-badge returned">Returned</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('staff.review.show', $app->id) }}" class="btn-view">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    @if($returned->hasPages())
                        <div class="pagination-wrapper">
                            {{ $returned->links() }}
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <i class="fas fa-undo"></i>
                        <p>No returned applications yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Tab switching
document.querySelectorAll('.tab-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const tabId = this.dataset.tab;
        
        // Update active states
        document.querySelectorAll('.tab-link').forEach(l => l.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
        
        this.classList.add('active');
        document.getElementById(tabId).classList.add('active');
    });
});
</script>
@endsection
