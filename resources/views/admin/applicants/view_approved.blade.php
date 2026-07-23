@extends('layouts.admin')

@section('title', 'Account Details')

@section('content')
<div class="profile-content">

    <!-- Profile Header -->
    <div class="profile-header mb-4">
        <div class="profile-header-content d-flex align-items-center gap-3">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info">
                <h2>{{ $account->first_name ?? 'N/A' }} {{ $account->last_name ?? 'N/A' }}</h2>
                <div class="profile-role">Approved Account</div>
                <div class="profile-status">
                    <div class="status-indicator"></div>
                    <span>Approved</span>
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
                    <span class="info-value">{{ $account->first_name ?? 'N/A' }} {{ $account->last_name ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $account->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Contact</span>
                    <span class="info-value">{{ $account->contact ?? 'N/A' }}</span>
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
                    <span class="info-value">{{ $account->tribe ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Leader</span>
                    <span class="info-value">{{ $account->leader ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- COC Transactions -->
    <div class="profile-card mt-4">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-file-certificate"></i> COC Transactions
            </div>
        </div>
        <div class="card-body">
            @if($cocApplications->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Status</th>
                                <th>Date Submitted</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cocApplications as $coc)
                                <tr>
                                    <td>
                                        <span class="badge 
                                            @if($coc->status=='Approved') bg-success
                                            @elseif($coc->status=='Pending') bg-warning text-dark
                                            @elseif($coc->status=='Draft') bg-secondary
                                            @else bg-danger @endif">
                                            {{ ucfirst($coc->status) }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($coc->created_at)->format('M d, Y') }}</td>
                                    <td>
                                        @if($coc->status == 'Approved')
                                            <a href="{{ route('admin.applicants.coc.view', $coc->id) }}" class="btn btn-sm btn-primary">
                                                View
                                            </a>
                                        @else
                                            <span class="text-muted">Not available</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">No COC transactions found.</p>
            @endif
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-4">
        <a href="{{ route('admin.accounts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Accounts
        </a>
    </div>

</div>
@endsection
