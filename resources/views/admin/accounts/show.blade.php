@extends('layouts.admin')

@section('title', 'View Account Details')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root {
    --primary-green: #3E7B27;
    --primary-green-hover: #2f5f1e;
    --primary-green-light: #f0f7ed;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 24px;
    gap: 16px;
}

.page-title h4 {
    font-size: 24px;
    font-weight: 600;
    color: #222;
    margin: 0 0 4px 0;
}

.page-title p {
    color:#333;
    font-size: 15px;
    margin: 0;
}

.action-buttons {
    display: flex;
    flex-direction: column; 
    gap: 10px;
    align-items: flex-end; 
}

.btn-back,
.btn-edit {
    padding: 8px 16px;
    border-radius: 8px;
    color: white;
    border: none;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    text-align: center;
    transition: all 0.2s ease;
    width: 100px; 
}

.btn-back {
    background: #555;
    color: #fff;
}

.btn-back:hover {
    background: #222;
    color: #fff;
}

.btn-edit {
    background: var(--primary-green);
}

.btn-edit:hover {
    background: var(--primary-green-hover);
}

/* Cards */
.profile-card, .details-card {
    background: white;
    border-radius: 10px;
    padding: 32px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    border: 1px solid #e5e5e5;
}

.profile-card {
    text-align: center;
}

.profile-image {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid var(--primary-green-light);
    margin: 0 auto 20px;
}

.profile-placeholder {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    background: var(--primary-green-light);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    border: 4px solid var(--primary-green-light);
}

.profile-placeholder i {
    font-size: 56px;
    color: var(--primary-green);
}

.profile-name {
    font-size: 22px;
    font-weight: 600;
    color: #222;
    margin-bottom: 16px;
}

.badge-group {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-bottom: 24px;
}

.role-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    background: var(--primary-green-light);
    color: var(--primary-green);
}

.status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-active {
    background: #d4edda;
    color: #155724;
}

.status-inactive {
    background: #f8d7da;
    color: #721c24;
}

.info-section {
    border-top: 2px solid #f0f0f0;
    padding-top: 24px;
    margin-top: 24px;
    text-align: left;
}

.info-item {
    margin-bottom: 20px;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-label {
    font-size: 13px;
    font-weight: 600;
    color: #222;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
    display: block;
}

.info-value {
    font-size: 13px;
    color: #222;
    font-weight: 500;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    color: #222;
    margin-bottom: 24px;
    padding-bottom: 12px;
    border-bottom: 2px solid #f0f0f0;
}

.detail-row {
    margin-bottom: 24px;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .action-buttons {
        align-items: flex-start; 
        width: 100%;
    }

    .btn-back,
    .btn-edit {
        width: 100%;
    }
}
</style>

<div class="main">
    <div class="row">
        {{-- Profile Card --}}
        <div class="col-lg-4 col-md-5 mb-4">
            <div class="profile-card">
                @if($account->profile_picture)
                    <img src="{{ asset('storage/' . $account->profile_picture) }}" 
                         alt="Profile" 
                         class="profile-image">
                @else
                    <div class="profile-placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                @endif

                <h5 class="profile-name">{{ $account->name }}</h5>
                
                <div class="badge-group">
                    <span class="role-badge">
                        {{ ucfirst($account->role) }}
                    </span>
                    <span class="status-badge {{ $account->status == 'active' ? 'status-active' : 'status-inactive' }}">
                        {{ ucfirst($account->status) }}
                    </span>
                </div>

                <div class="info-section">
                    <div class="info-item">
                        <span class="info-label">Account ID</span>
                        <div class="info-value">#{{ $account->id }}</div>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Member Since</span>
                        <div class="info-value">{{ $account->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Details Card --}}
        <div class="col-lg-8 col-md-7">
            <div class="page-header">
                <div class="page-title">
                    <h4><i class="fas fa-user-circle me-2" style="color: var(--primary-green);"></i>Account Details</h4>
                    <p>View employee account information</p>
                </div>
                <div class="action-buttons">
                    <a href="{{ route('admin.accounts.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                    <a href="{{ route('admin.accounts.edit', $account->id) }}" class="btn-edit">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                </div>
            </div>

            <div class="details-card">
                <h6 class="section-title">Personal Information</h6>
                
                <div class="row detail-row">
                    <div class="col-sm-6 mb-3">
                        <span class="info-label">First Name</span>
                        <div class="info-value">{{ $account->first_name }}</div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <span class="info-label">Last Name</span>
                        <div class="info-value">{{ $account->last_name }}</div>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-sm-6 mb-3">
                        <span class="info-label">Email Address</span>
                        <div class="info-value">{{ $account->email }}</div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <span class="info-label">Phone Number</span>
                        <div class="info-value">{{ $account->contact ?? 'Not provided' }}</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <span class="info-label">Address</span>
                        <div class="info-value">{{ $account->address ?? 'Not provided' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
