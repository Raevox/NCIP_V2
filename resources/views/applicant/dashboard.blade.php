@extends('layouts.applicant')
@section('title', __('Dashboard'))
@section('page-title', __('Dashboard'))

@section('content')
<style>
    .dashboard-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-top: 1rem;
    }

    .container-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: clamp(1rem, 2vw, 2rem);
        flex: 1 1 100%;
        min-width: 280px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .container-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 22px rgba(0,0,0,0.12);
    }

    .rounded-circle {
        background: linear-gradient(135deg, #c2c4c1 0%, #2d5a2d 100%);
        width: clamp(65px, 8vw, 80px);
        height: clamp(65px, 8vw, 80px);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        margin: 0 auto 1rem auto;
        font-size: clamp(1.2rem, 3vw, 1.5rem);
        box-shadow: 0 4px 8px rgba(0,0,0,0.12);
    }

    .container-card.text-center p.text-muted {
        text-align: center;
        margin: 0 auto 0.5rem;
    }

    h5 {
        font-size: clamp(1.1rem, 2vw, 1.3rem);
        margin-bottom: .5rem;
        color: #222;
        text-align: center;
    }

    h6 {
        font-size: clamp(0.95rem, 1.8vw, 1.1rem);
        margin-bottom: .5rem;
        color: #333;
    }

    p {
        font-size: clamp(0.85rem, 1.6vw, 1rem);
        color: #6c757d;
        margin-bottom: .5rem;
    }

    .table-sm th, .table-sm td {
        padding: 6px 8px;
        font-size: clamp(0.85rem, 1.6vw, 1rem);
    }

    .table-sm th {
        width: 40%;
        text-align: start;
        font-weight: 500;
        color: #6C757D;
        padding-right: 20px;
    }

    .table-sm td {
        text-align: start;
        color: #222;
    }

    .badge {
        font-weight: 600;
        padding: clamp(0.25rem, 0.8vw, 0.6rem) clamp(0.5rem, 1vw, 0.9rem);
        font-size: clamp(0.75rem, 1.5vw, 0.9rem);
        border-radius: 20px;
        display: inline-block;
    }

    .bg-warning { background: #ffc107 !important; color: #212529 !important; }
    .bg-success { background: #198754 !important; color: #fff !important; }
    .bg-danger { background: #dc3545 !important; color: #fff !important; }
    .bg-secondary { background: #adb5bd !important; color: #fff !important; }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        padding: clamp(0.5rem, 1vw, 0.75rem) clamp(1rem, 2vw, 1.2rem);
        font-size: clamp(0.85rem, 1.6vw, 1rem);
        transition: background .2s ease, transform .2s ease;
        margin: 10px 0;
    }

    .btn-success { background: #3e7b27; color: #fff; }
    .btn-success:hover { background: #245524; }
    .btn-secondary { background: #adb5bd; color: #fff; }
    .btn-secondary:disabled { opacity: .7; cursor: not-allowed; }

    .text-muted {    color: #222 !important; text-align: inherit; }

    @media (min-width: 768px) {
        .dashboard-wrapper { flex-wrap: nowrap; }
        .container-card { flex: 1; }
    }

    @media (max-width: 576px) {
        .dashboard-wrapper { flex-direction: column; }
        .container-card { padding: 1rem; }
        .rounded-circle { width: 65px; height: 65px; font-size: 1.2rem; }
        h5, h6, p, td, th, span, a, button { text-align: center; }
        .table-responsive { overflow-x: auto; }
    }

    .container-card .text-muted.small {
        font-size: clamp(0.7rem, 1.2vw, 0.85rem);
        color: #6c757d;
        text-align: center;
        margin-top: 0.5rem;
    }

    .container-card h5.fw-bold.text-success {
        font-size: clamp(1rem, 2.2vw, 1.3rem);
    }

    .container-card p.text-muted {
        font-size: clamp(0.85rem, 1.6vw, 1rem);
        margin-bottom: 0.75rem;

    }

    .container-card .mt-3 span.fw-semibold {
        font-size: clamp(0.85rem, 1.6vw, 1rem);
    }

    .container-card .badge {
        font-size: clamp(0.75rem, 1.5vw, 0.9rem);
    }

    .container-card .btn {
        font-size: clamp(0.8rem, 1.4vw, 0.95rem);
        padding: 0.4rem 0.9rem;
        gap: 0.4rem;
        border-radius: 8px;
    }

    .container-card .btn i {
        font-size: clamp(0.8rem, 1.4vw, 0.95rem);
    }

    .container-card h5.fw-bold.text-success {
    font-size: clamp(1.1rem, 2.5vw, 1.5rem);
    text-align: center;
    margin-bottom: 0.75rem;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    color: #3e7b27; 
    }

    /* --- Responsive muted paragraph --- */
    .container-card p.text-muted {
        font-size: clamp(0.85rem, 1.5vw, 1rem); 
        text-align: start;
        margin-bottom: 0.5rem;
          color: #222;
    }

    /* Smaller on mobile */
    @media (max-width: 576px) {
        .container-card p.text-muted {
            font-size: 0.8rem; 
            text-align: start; 
          
        }
    }

</style>

<div class="container py-4">
    @php
        // A returned subsection must be visible immediately even if a legacy
        // workflow did not synchronize the two main status columns yet.
        $dashboardStatus = $application && count($application->getReturnedSections()) > 0
            ? 'Returned'
            : ($application?->coc_status ?: $application?->status);
    @endphp
    <div class="dashboard-wrapper">
        {{-- Left Card --}}
        <div class="container-card text-center">
            <div class="rounded-circle">
                <i class="fas fa-user"></i>
            </div>
            <h5 class="fw-bold">{{ $user->first_name }} {{ $user->last_name }}</h5>
            <p class="text-muted">{{ __('Applicant') }}</p>

            <div class="table-responsive">
                <table class="table table-sm table-borderless text-start mx-auto mb-0">
                    <tr>
                        <th class="text-muted">{{ __('IP Group') }}:</th>
                        <td>{{ $user->tribe ?? ($record->tribe ?? '—') }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">{{ __('Application Date') }}:</th>
                        <td>{{ $application ? $application->created_at->format('F d, Y') : __('No Application Submitted') }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">{{ __('COC Status') }}:</th>
                        <td>
                            <span class="badge
                                @if(!$application) bg-secondary
                                @elseif(in_array($dashboardStatus, ['Under Review', 'Admin Approval'])) bg-warning
                                @elseif($dashboardStatus === 'Returned') bg-danger
                                @elseif($dashboardStatus === 'Approved') bg-success
                                @else bg-secondary @endif">
                                {{ $application ? __($dashboardStatus) : __('No Application Submitted') }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Right Card --}}
        <div class="container-card">
            <h5 class="fw-bold text-success">
                <i class="fas fa-clipboard-check me-2"></i> {{ __('Application Status') }}
            </h5>
            <p class="text-muted">{{ __('Track your Certificate of Confirmation application') }}</p>

            <div class="mt-3">
                <span class="fw-semibold">{{ __('Current Status') }}:</span>
                <span class="badge
                    @if(!$application) bg-secondary
                    @elseif($dashboardStatus === 'Approved') bg-success
                    @elseif(in_array($dashboardStatus, ['Returned', 'Rejected'])) bg-danger
                    @else bg-warning @endif">
                    {{ $application ? __($dashboardStatus) : __('No Application Submitted') }}
                </span>
            </div>

            <div class="mt-4">
                @if($application)
                    <a href="{{ route('applicant.track-status') }}" class="btn btn-success">
                        <i class="fas fa-eye"></i> {{ __('View Detailed Status') }}
                    </a>
                @else
                    <button class="btn btn-secondary" disabled>
                        <i class="fas fa-eye"></i> {{ __('No Application Yet') }}
                    </button>
                @endif
            </div>

            <div class="mt-3 text-muted small">
                {{ __('Last updated') }}: {{ now()->format('h:i A, F d, Y') }}
            </div>
        </div>
    </div>

    {{-- Pickup Card (only if approved) --}}
    @if($application && $application->coc_status === 'Approved')
    <div class="container-card mt-4" style="border-left: 4px solid #198754;">
        <h5 class="fw-bold mb-1">{{ __('Pickup Location') }}</h5>
        <p class="mb-3 text-muted">{{ __('Burgos Avenue at Old Capitol, Cabanatuan City, Nueva Ecija') }}</p>
        <h6 class="fw-bold mb-2">{{ __('Instructions') }}</h6>
        <p class="text-muted mb-2">
            {{ __('Please bring the hard copy of the following:') }}
        </p>
        <ul class="mb-0 ps-3">
            <li>{{ __('Certificate of IP Membership') }}</li>
            <li>{{ __('Two (2) identical 2x2 ID photos') }}</li>
            <li>{{ __('Photocopy of Birth Certificate') }}</li>
            <li>{{ __('Certification from the Office of the Tribal Chieftain') }}</li>
            <li>{{ __('Hard copies of all previously uploaded documents') }}</li>
            <li>{{ __('Prepare payment for the documentary stamp') }}</li>
            <li>{{ __('Ensure that all documents are notarized after review by NCIP NEPO staff') }}</li>
        </ul>
    </div>
    @endif
</div>
@endsection
