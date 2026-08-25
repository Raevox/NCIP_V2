@extends('layouts.admin')
@section('title', 'COC Certificate')

<style>
    :root {
        --primary-green: #3E7B27;
        --primary-green-hover: #2f5f1e;
        --ncip-blue: #0066cc;
    }

    body {
        background: #f5f5f5;
    }

    .certificate-wrapper {
        max-width: 850px;
        margin: 40px auto;
        padding: 20px;
    }

    .certificate-container {
        background: white;
        border: 3px solid #000;
        padding: 40px 60px;
        position: relative;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    /* Header with Logo and Title */
    .cert-header {
        display: flex;
        align-items: center;
        gap: 30px;
        border-bottom: 2px solid #000;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .cert-logo {
        width: 120px;
        height: 120px;
        flex-shrink: 0;
        object-fit: contain;
    }

    .cert-header-text {
        flex: 1;
        text-align: center;
        margin-right: 80px;
    }

    .cert-republic {
        font-size: 14px;
        font-weight: normal;
        margin: 0;
        line-height: 1.3;
    }

    .cert-office-title {
        font-size: 15px;
        margin: 2px 0;
        line-height: 1.2;
    }

    .cert-ncip {
        color: var(--ncip-blue);
        font-size: 15px;
        font-weight: bold;
        margin: 5px 0;
        letter-spacing: 0.5px;
    }

    .cert-regional {
        font-size: 16px;
        font-weight: bold;
        margin: 3px 0;
        color: red;
    }

    .cert-address {
        font-size: 14px;
        margin: 3px 0;
        line-height: 1.3;
    }

    /* Certificate Title */
    .cert-title-box {
        text-align: center;
        margin: 30px 0;
    }

    .cert-title-main {
        font-size: 22px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin: 0;
    }

    /* Content */
    .cert-content {
        text-align: justify;
        font-size: 12px;
        line-height: 1.8;
        margin: 25px 0;
    }

    .cert-content p {
        margin: 15px 0;
        text-indent: 50px;
        font-size: 16px;
    }

    .cert-name {
        font-weight: bold;
        font-size: 24px;
        text-transform: uppercase;
        color: #000;
    }

    .cert-highlight {
        font-weight: bold;
    }

    .cert-issued {
        margin: 25px 0;
        font-size: 12px;
        line-height: 1.8;
    }

    .cert-ethnicity {
        font-style: italic;
        font-weight: bold;
    }

    /* Signature Section */
    .cert-signatures {
        margin-top: 40px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .cert-signature-block {
        text-align: center;
        width: 45%;
    }

    .cert-signature-line {
        border-top: 2px solid #000;
        padding-top: 5px;
        margin-top: 50px;
        font-size: 11px;
        font-weight: bold;
    }

    .cert-signature-title {
        font-size: 10px;
        font-style: italic;
        margin-top: 2px;
    }

    /* Footer Box */
    .cert-footer-box {
        border: 2px solid var(--ncip-blue);
        width: 300px;
        padding: 8px;
        text-align: start;
        margin-top: 30px;
        background: #f0f7ff;
    }

    .cert-footer-code {
        font-weight: bold;
        font-size: 15px;
        color: var(--ncip-blue);
    }

    .cert-footer-note {
        font-size: 16px;
        color: #000;
        margin-top: 2px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        flex-direction: column; 
        align-items: center; 
        gap: 15px; 
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 35px;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        border-radius: 10px;
        color: #fff;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        min-width: 220px;
        text-align: center;
    }

    .btn-back {
        background: #2563eb;
        height: 40px;
    }

    .btn-back:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
    }

    .btn-print {
        background: #256d1b;
        height: 40px;
    }

    .btn-print:hover {
        background: #1f5a16;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 109, 27, 0.4);
    }

    .btn-action i {
        font-size: 16px;
    }

    /* Alert Box */
    .alert-box {
        max-width: 600px;
        margin: 100px auto;
        padding: 40px;
        background: white;
        border: 2px solid var(--primary-green);
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .alert-box h4 {
        color: var(--primary-green);
        font-size: 24px;
        margin-bottom: 20px;
    }

    .alert-box p {
        font-size: 16px;
        line-height: 1.6;
        color: #333;
        margin: 10px 0;
    }

    /* Print Styles */
    @media print {
        body * {
            visibility: hidden;
        }
        .certificate-wrapper,
        .certificate-wrapper * {
            visibility: visible;
        }
        .certificate-wrapper {
            position: absolute;
            left: 0;
            top: 0;
            margin: 0;
            padding: 0;
        }
        .certificate-container {
            box-shadow: none;
            border: 3px solid #000;
        }
        .action-buttons {
            display: none !important;
        }
    }

    @media (max-width: 768px) {
        .certificate-container {
            padding: 30px 20px;
        }

        .cert-header {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }

        .cert-logo {
            width: 80px;
            height: 80px;
        }

        .cert-content {
            font-size: 11px;
        }

        .cert-signatures {
            flex-direction: column;
            gap: 30px;
        }

        .cert-signature-block {
            width: 100%;
        }
    }
</style>

@section('content')
<div class="main">
    @if($coc->coc_status == 'Approved')
        <div class="certificate-wrapper">
            <div class="certificate-container">
                <!-- Header -->
                <div class="cert-header">
                    {{-- ✅ FIXED LOGO PATH --}}
                    <img src="{{ asset('images/ncip_logo.jpg') }}" 
                         alt="NCIP Logo" 
                         class="cert-logo"
                         onerror="this.onerror=null; this.src='{{ asset('images/ncip_logo-removebg.png') }}';">
                    
                    <div class="cert-header-text">
                        <p class="cert-republic">Republic of the Philippines<br>Office of the President</p>
                        <p class="cert-ncip">NATIONAL COMMISSION ON INDIGENOUS PEOPLES</p>
                        <p class="cert-regional">NUEVA ECIJA PROVINCIAL OFFICE</p>
                        <p class="cert-address">
                            Burgos Ave, Old Capitol Bldg, Cabanatuan City, Nueva Ecija<br>
                            Tel. No. 044-958-0089
                        </p>
                    </div>
                </div>

                <!-- Certificate Title -->
                <div class="cert-title-box">
                    <h1 class="cert-title-main">Certificate of Confirmation</h1>
                </div>

                <!-- Content -->
                <div class="cert-content">
                    <p style="text-align: center; font-weight: bold; font-size: 20px; text-indent: 0;">BE IT KNOWN</p>
                    <p style="text-align: center; font-weight: bold; font-size: 18px; text-indent: 0;">that</p>

                    <p style="text-align: center; text-indent: 0;">
                        <span class="cert-name">{{ strtoupper($coc->applicant->first_name) }} {{ strtoupper($coc->applicant->last_name) }}</span>
                    </p>

                    <p>
                        Is a <span class="cert-highlight">Bonafide member</span> of the <span class="cert-highlight">{{ $coc->applicant->tribe ?? 'BAGO' }}</span> Indigenous Cultural Communities as certified by their IP Leader 
                        <strong>
                            <span class="cert-highlight">
                                {{ strtoupper($coc->applicant->leader ?? 'IP Leader') }}
                            </span>
                            of 
                            {{ $coc->applicant->barangay_name ?? 'Barangay' }}, 
                            {{ $coc->applicant->municipality_name ?? 'Municipality' }}, 
                            Nueva Ecija.
                        </strong>
                    </p>

                    <p>
                        That this Office hereby presents and confirms the membership of <span class="cert-highlight">{{ $coc->applicant->first_name }} {{ $coc->applicant->last_name }}</span> with the <span class="cert-highlight">{{ $coc->applicant->tribe ?? 'BAGO' }} IP/ICC</span> as is hereby certified as (ethnic, bonafide indigenous community member belonging to ICC's/IP's) and as other living devices, rules and regulations and other issuance of the government.
                    </p>

                    <p class="cert-issued">
                        Issued this <span class="cert-highlight">{{ $coc->updated_at->format('jS') }}</span> day of <span class="cert-highlight">{{ $coc->updated_at->format('F Y') }}</span>, upon request of <span class="cert-highlight">{{ $coc->applicant->first_name }} {{ $coc->applicant->last_name }}</span> for <span class="cert-highlight">Identification of ETHNICITY / IP group membership</span>.
                    </p>

                    <p style="margin-top: 30px;">
                        <span class="cert-highlight">Recommending Confirmation:</span>
                    </p>
                </div>

                <!-- Signatures -->
                <div class="cert-signatures">
                    <div class="cert-signature-block">
                        <div class="cert-signature-line">
                            ENGR. JONELYN D. BANG-OT
                        </div>
                        <div class="cert-signature-title">
                            OIC-Administrative Officer IV, per Memo Order no. 02-2025-47-294
                        </div>
                    </div>

                    <div class="cert-signature-block">
                        <div style="text-align: center; margin-bottom: 60px; font-weight: bold; font-size: 12px;">
                            CONFIRMED:
                        </div>
                        <div class="cert-signature-line">
                            DONATO B. BUMACAS, PhD.
                        </div>
                        <div class="cert-signature-title">
                            DMO/Provincial Officer
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="cert-footer-box">
                    <div class="cert-footer-code">COC-R02-NUE-09-25-2025</div>
                </div>
                <div class="cert-footer-note">NOT VALID WITHOUT SEAL</div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('admin.applicants.transaction', $coc->applicant->id) }}" class="btn-action btn-back">
                <i class="fas fa-arrow-left"></i>
                <span>Back to History</span>
            </a>

            <button onclick="window.print()" class="btn-action btn-print">
                <i class="fas fa-print"></i>
                <span>Print Certificate</span>
            </button>
        </div>

    @else
        <!-- Alert for Non-Approved -->
        @php
            $cocStatus = $coc->coc_status ?: 'Under Review';
            $waitingForStaff = in_array($cocStatus, ['Draft', 'Under Review', 'Submitted', 'Pending'], true);
        @endphp
        <div class="alert-box">
            @if($waitingForStaff)
                <h4>
                    <i class="fas fa-clock"></i> Waiting for Staff Review
                </h4>
                <p>
                    This COC application has not yet been forwarded to the administrator.
                </p>
                <p style="color: #666; font-size: 14px;">
                    Please wait for the staff to review and forward the application for admin approval.
                </p>
            @elseif($cocStatus === 'Admin Approval')
                <h4>
                    <i class="fas fa-user-shield"></i> Ready for Admin Review
                </h4>
                <p>The staff has reviewed and forwarded this COC application to the administrator.</p>
                <p style="color: #666; font-size: 14px;">The certificate will become available after final approval.</p>
            @elseif($cocStatus === 'Returned')
                <h4>
                    <i class="fas fa-undo"></i> Application Returned
                </h4>
                <p>This COC application was returned for revision and is not ready for approval.</p>
            @else
                <h4>
                    <i class="fas fa-exclamation-circle"></i> Notice
                </h4>
                <p>
                    This COC application is <strong>{{ $cocStatus }}</strong> and cannot be viewed as a certificate yet.
                </p>
                <p style="color: #666; font-size: 14px;">Only approved applications can generate certificates.</p>
            @endif
            
            <div style="margin-top: 30px;">
                <a href="{{ route('admin.applicants.transaction', $coc->applicant->id) }}" class="btn-action btn-back">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to History</span>
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
