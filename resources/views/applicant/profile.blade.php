@extends('layouts.applicant')
@section('page-title', 'Profile')
@section('title', 'My Profile')

@section('content')
<style>
        .profile-content {
        padding: clamp(1rem, 3vw, 2rem);
    }

    .profile-header {
        background: linear-gradient(135deg, #c2c4c1 0%, #2d5a2d 100%);
        border-radius: 12px;
        padding: clamp(1rem, 3vw, 2rem);
        color: #fff;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(62, 123, 39, 0.2);
    }

    .profile-header-content {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .profile-avatar {
        width: clamp(70px, 15vw, 100px);
        height: clamp(70px, 15vw, 100px);
        border-radius: 50%;
        border: 3px solid rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: clamp(2rem, 6vw, 3rem);
        background: rgba(255, 255, 255, 0.2);
    }

    .profile-info h2 {
        margin: 0;
        font-size: clamp(1.2rem, 3vw, 1.75rem);
        font-weight: 700;
    }

    .profile-role {
        font-size: clamp(0.8rem, 2vw, 1rem);
        opacity: 0.9;
    }

    .profile-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.2);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: clamp(0.7rem, 1.5vw, 0.85rem);
        margin-top: 0.5rem;
    }

    .status-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #ffc107;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .profile-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 2px solid #e5e5e5;
    }

    .profile-card:hover {
        transform: translateY(-2px);
    }

    .card-header {
        background: #f8f9fa;
        padding: 1rem;
        border-bottom: 1px solid #e9ecef;
    }

    .card-title {
        font-size: clamp(0.95rem, 2vw, 1.1rem);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
         color: #3e7b27;
    }

    .card-title i {
        width: 20px;
        text-align: center;
        color: #3e7b27;
    }

    .card-body {
        padding: 1rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        gap: 0.5rem;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f1f3f4;
        flex-wrap: wrap;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 500;
        color: #6c757d;
        font-size: clamp(0.8rem, 1.8vw, 0.95rem);
    }

    .info-value {
        font-weight: 500;
        color: #222;
        font-size: clamp(0.8rem, 1.8vw, 0.95rem);
    }

    .badge {
        font-weight: 600;
        padding: 0.35rem 0.8rem;
        border-radius: 20px;
        font-size: clamp(0.7rem, 1.5vw, 0.85rem);
    }

    .bg-warning { background: #ffc107 !important; color: #212529 !important; }
    .bg-success { background: #198754 !important; color: #fff !important; }
    .bg-danger { background: #dc3545 !important; color: #fff !important; }
    .bg-secondary { background: #adb5bd !important; color: #fff !important; }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        padding: clamp(0.5rem, 1vw, 0.75rem) clamp(1rem, 2vw, 1.2rem);
        font-size: clamp(0.85rem, 1.6vw, 1rem);
        transition: background 0.2s ease, transform 0.2s ease;
        margin: 10px 0;
        justify-content: center;
        width: 100%;
    }

    .btn-success { background: #3e7b27; color: #fff; }
    .btn-success:hover { background: #245524; }
    .btn-secondary { background: #adb5bd; color: #fff; }
    .btn-secondary:disabled { opacity: 0.7; cursor: not-allowed; }

    @media (max-width: 576px) {
        .profile-header-content {
            flex-direction: column;
            text-align: center;
        }
        .info-row {
            flex-direction: column;
            align-items: flex-start;
        }
        .info-value {
            text-align: left;
            width: 100%;
        }
    }

</style>
<div class="profile-content">
    <div class="profile-header mb-4">
        <div class="profile-header-content d-flex align-items-center gap-3">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info">
                <h2>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h2>
                <div class="profile-role">Certificate of Confirmation Applicant</div>
                <div class="profile-status">
                    <div class="status-indicator"></div>
                    <span>{{ ucfirst(Auth::user()->status ?? 'Pending') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="profile-grid">
        <div class="profile-card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-user"></i> Personal Information
                </div>
            </div>
            <div class="card-body">
                <div class="info-row">
                    <span class="info-label">Full Name</span>
                    <span class="info-value">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ Auth::user()->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Contact</span>
                    <span class="info-value">{{ Auth::user()->contact ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="profile-card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-users"></i> Indigenous Community
                </div>
            </div>
            <div class="card-body">
                <div class="info-row">
                    <span class="info-label">Tribe</span>
                    <span class="info-value">{{ Auth::user()->tribe ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Leader</span>
                    <span class="info-value">{{ Auth::user()->leader ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
        <div class="profile-card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-clipboard-check"></i> Application Status
                </div>
            </div>
            <div class="card-body">
                <div class="info-row">
                    <span class="info-label">Current Status</span>
                    <span class="info-value">
                        @if(!$application)
                            <span class="badge bg-secondary">No Application Submitted</span>
                        @elseif($application->status === 'Approved')
                            <span class="badge bg-success">Issued</span>
                        @elseif($application->status === 'Rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @else
                            <span class="badge bg-warning text-dark">{{ $application->status }}</span>
                        @endif
                    </span>
                </div>

                <div class="info-row mt-2">
                    <span class="info-label">Application Date</span>
                    <span class="info-value">
                        {{ $application ? $application->created_at->format('F d, Y') : 'N/A' }}
                    </span>
                </div>

                <div class="mt-3">
                    @if($application)
                        <a href="{{ route('applicant.track-status') }}" class="btn btn-success">
                            <i class="fas fa-eye"></i> View Detailed Status
                        </a>
                    @else
                        <button class="btn btn-secondary" disabled>
                            <i class="fas fa-eye"></i> No Application Yet
                        </button>
                    @endif
                </div>
            </div>
        </div>

@endsection
