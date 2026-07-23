@extends('layouts.applicant')

@section('title', 'COC Application')
@section('page-title', 'Application for COC')

@section('content')

<style>
    /* Wrapper */
    .coc-wrapper {
        display: flex;
        justify-content: center;
    }

    /* Card container */
    .coc-card {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 12px;
        padding: 2rem;
        width: 100%;
        max-width: 1200px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-top: 15px !important;
    }

    /* Title */
    .coc-title {
        font-size: clamp(1rem, 1.8vw, 1.5rem);
        font-weight: 700;
        margin-bottom: 1rem;
        color: #3e7b27;
    }

    /* Description */
    .coc-desc {
        font-size: clamp(0.75rem, 1vw, 0.9rem);
        line-height: 1.6;
        margin-bottom: 1.5rem;
        color: #444;
    }

    /* List */
    .coc-list {
        list-style: none;
        padding: 0;
        margin-bottom: 1.5rem;
    }
    .coc-list li {
        font-size: clamp(0.7rem, 0.9vw, 0.85rem);
        padding: 5px 0;
        /* border-bottom: 1px solid #f1f1f1; */
    }
    .coc-list li:last-child {
        border-bottom: none;
    }

    /* Alert box */
    .coc-alert {
        display: flex;
        gap: 8px;
        align-items: flex-start;
        background: #fff8e5;
        border: 1px solid #ffe199;
        border-radius: 8px;
        padding: 10px 14px;
        margin-bottom: 1.5rem;
        font-size: clamp(0.7rem, 0.9vw, 0.85rem);
        line-height: 1.4;
    }
    .coc-alert i {
        color: #d9a500;
        font-size: 0.9rem;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .coc-alert p {
        margin: 0;
    }

    /* Info box for reapplication */
    .coc-info {
        background: #e8f4ff;
        border: 1px solid #b8daff;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    .coc-info h5 {
        color: #004085;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }
    .coc-info p {
        color: #004085;
        margin-bottom: 1rem;
        font-size: 0.85rem;
    }
    .coc-info .btn-group {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .coc-info .btn {
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        border: none;
    }
    .coc-info .btn-primary {
        background: #3e7b27;
        color: #fff;
    }
    .coc-info .btn-primary:hover {
        background: #2e5e1c;
    }
    .coc-info .btn-outline {
        background: transparent;
        color: #3e7b27;
        border: 1px solid #3e7b27;
    }
    .coc-info .btn-outline:hover {
        background: #3e7b27;
        color: #fff;
    }

    /* Action Button */
    .coc-action {
        display: flex;
        justify-content: flex-end;
    }
    .coc-btn {
        background: #3e7b27;
        color: #fff;
        border: none;
        font-weight: 600;
        font-size: clamp(0.75rem, 1vw, 0.9rem);
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .coc-btn:hover {
        background: #2e5e1c;
    }

    /* Status badges */
    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .status-approved {
        background: #d4edda;
        color: #155724;
    }

    /* Tablet adjustments */
    @media (max-width: 768px) {
        .coc-card {
            padding: 1.2rem;
            max-width: 95%;
        }
        .coc-title {
            font-size: 1.1rem;
        }
        .coc-desc,
        .coc-list li,
        .coc-alert,
        .coc-btn {
            font-size: 0.8rem;
        }
        .coc-info .btn-group {
            flex-direction: column;
        }
        .coc-info .btn {
            width: 100%;
            justify-content: center;
        }
        .coc-action {
            justify-content: center;
        }
        .coc-btn {
            width: 100%;
            text-align: center;
            justify-content: center;
        }
    }

    /* Mobile adjustments */
    @media (max-width: 480px) {
        .coc-card {
            padding: 0.7rem;
            max-width: 100%;
        }
        .coc-title {
            font-size: 1rem;
        }
        .coc-desc,
        .coc-list li,
        .coc-alert,
        .coc-btn {
            font-size: 0.7rem;
        }
    }
</style>

<div class="coc-wrapper">
    <div class="coc-card">
        <h2 class="coc-title">Apply for Certificate of Confirmation (COC)</h2>
        
        {{-- Show reapplication option if user has approved application --}}
        @if(isset($application) && $application->status == 'Approved' && $application->coc_status === 'Approved')
        <div class="coc-info">
            <h5>
                <i class="fas fa-redo-alt"></i> Apply Again Using Previous Data
                <span class="status-badge status-approved">Previously Approved</span>
            </h5>
            <p>
                You have a previously approved application. You can start a new application using your previous information. 
                All your personal details will be prefilled automatically - you only need to update the purpose of application.
            </p>
            <div class="btn-group">
                <a href="{{ route('applicant.coc.start-new-with-old-data') }}" class="btn btn-primary">
                    <i class="fas fa-copy"></i> Apply Again Using Previous Data
                </a>
                <a href="{{ route('applicant.coc.step1') }}" class="btn btn-outline">
                    <i class="fas fa-plus"></i> Start Fresh Application
                </a>
            </div>
            <small class="text-muted mt-2 d-block">
                <i class="fas fa-info-circle"></i> 
                Using previous data will prefill all your information except the purpose. 
                You can review and update any information before submitting.
            </small>
        </div>
        @endif

        <p class="coc-desc">
            The Certificate of Confirmation (COC) is an official document issued by the 
            National Commission on Indigenous Peoples (NCIP). It serves as proof of an 
            individual's recognition as a member of an Indigenous Cultural Community (ICC) 
            or Indigenous Peoples (IP) group.
        </p>
        
        <ul class="coc-list">
            <li>✔ Fill up Information Index Form</li>
            <li>✔ Fill up Genealogy Form</li>
            <li>✔ Certification of IP Membership</li>
            <li>✔ Two (2) identical 2x2 ID photos (Bring to office)</li>
            <li>✔ Two (2) documentary stamps (Pay in office only)</li>
            <li>✔ Birth Certificate</li>
            <li>✔ Certification from the Office of the Tribal Chieftain</li>
        </ul>
        
        <div class="coc-alert">
            <i class="fas fa-exclamation-triangle"></i>
            <p>
                Important Notice: Before applying for the Certificate of Confirmation (COC), 
                ensure you have all the required documents. Incomplete applications may be rejected.
            </p>
        </div>
        
        {{-- Only show regular apply button if no approved application exists --}}
        {{-- Notice for pending application --}}
        @if(isset($application) && $application->status === 'Under Review')
        <div class="coc-info">
            <h5>
                <i class="fas fa-hourglass-half"></i> Application Pending
                <span class="status-badge" style="background:#fff3cd;color:#856404;">Pending Review</span>
            </h5>
            <p>
                You already have a COC application currently under review. Please wait for it to be
                approved or rejected before submitting a new one.
            </p>
        </div>
        @endif

        {{-- Only show the apply button if there's no pending app and no already-approved COC --}}
        @if(!isset($application) 
            || ($application->status !== 'Pending' 
                && !($application->status === 'Approved' && $application->coc_status === 'Approved')))
        <div class="coc-action">
            <a href="{{ route('applicant.coc.step1') }}" class="coc-btn">
                <i class="fas fa-paper-plane"></i> Request COC
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
