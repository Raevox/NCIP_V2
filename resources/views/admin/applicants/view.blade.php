@extends('layouts.admin')

@section('title', 'Applicant Details')

@section('content')
<div class="profile-content">

    <!-- Profile Header -->
    <div class="profile-header mb-4">
        <div class="profile-header-content d-flex align-items-center gap-3">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info">
                <h2>{{ $applicant->first_name }} {{ $applicant->last_name }}</h2>
                <div class="profile-role">Certificate of Confirmation Applicant</div>
                <div class="profile-status">
                    <div class="status-indicator"></div>
                    <span>{{ ucfirst($applicant->status) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Grid -->
    <div class="profile-grid">

        <!-- Personal Information Card -->
        <div class="profile-card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-user"></i> Personal Information
                </div>
            </div>
            <div class="card-body">
                <div class="info-row">
                    <span class="info-label">Full Name</span>
                    <span class="info-value">{{ $applicant->first_name }} {{ $applicant->last_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $applicant->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Contact</span>
                    <span class="info-value">{{ $applicant->contact ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Indigenous Community Card -->
        <div class="profile-card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-users"></i> Indigenous Community
                </div>
            </div>
            <div class="card-body">
                <div class="info-row">
                    <span class="info-label">Tribe</span>
                    <span class="info-value">{{ $applicant->tribe }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Leader</span>
                    <span class="info-value">{{ $applicant->leader }}</span>
                </div>
            </div>
        </div>
<div class="profile-card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-file-alt"></i> Birth Certificate Verification
        </div>
    </div>
    <div class="card-body">
        <div class="info-row">
            <span class="info-label">Document</span>
            <span class="info-value">
                <a href="{{ route('admin.applicants.document', $applicant->id) }}" class="btn btn-primary">
                    View Document
                </a>
                
            </span>
        </div>
    </div>
</div>
    </div>
    

</div>

    <!-- Back Button -->
    <div class="mt-4">
        <a href="{{ route('admin.applicants.pending') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Pending
        </a>
    </div>

</div>

<style>
    .profile-content { padding: 2rem; }
    .profile-header { background: linear-gradient(135deg, #c2c4c1 0%, #2d5a2d 100%); border-radius: 12px; padding: 2rem; color: #fff; margin-bottom: 2rem; box-shadow: 0 4px 16px rgba(62,123,39,0.2); }
    .profile-header-content { display: flex; align-items: center; gap: 1.5rem; }
    .profile-avatar { width: 100px; height: 100px; border-radius: 50%; border: 3px solid rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center; font-size: 48px; background: rgba(255,255,255,0.2); }
    .profile-info h2 { margin: 0; font-size: 1.75rem; font-weight: 700; }
    .profile-role { font-size: 1rem; opacity: 0.9; }
    .profile-status { display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(255,255,255,0.2); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; margin-top: 0.5rem; }
    .status-indicator { width: 8px; height: 8px; border-radius: 50%; background: #ffc107; }
    .profile-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }
    .profile-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden; transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .profile-card:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,0.15); }
    .card-header { background: #f8f9fa; padding: 1rem; border-bottom: 1px solid #e9ecef; }
    .card-title { font-size: 1.1rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; }
    .card-title i { width: 20px; text-align: center; color: #495057; }
    .card-body { padding: 1rem; }
    .info-row { display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #f1f3f4; }
    .info-row:last-child { border-bottom: none; }
    .info-label { font-weight: 500; color: #6c757d; }
    .info-value { font-weight: 600; color: #495057; text-align: right; }
</style>
@endsection
