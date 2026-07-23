@extends('layouts.admin')

@section('content')
<div class="certificate-container" style="padding: 20px;">
    <!-- Print Button -->
    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Print Certificate
        </button>
        <a href="{{ route('ip_records.print_certificate_pdf', $record->id) }}" class="btn btn-success">
            <i class="fas fa-download"></i> Download PDF
        </a>
        <a href="{{ route('ip_records.show', $record->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Record
        </a>
    </div>

    <!-- Certificate -->
    <div class="certificate-content" style="background: white; padding: 40px; max-width: 800px; margin: 0 auto; border: 2px solid #000;">
        
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="font-size: 14px; line-height: 1.3;">
                <strong>COC-R03-NUE-{{ date('m-d-Y', strtotime($record->census_date)) }}-{{ str_pad($record->id, 4, '0', STR_PAD_LEFT) }}</strong>
            </div>
            <div style="margin: 15px 0; font-size: 12px; line-height: 1.4;">
                Republic of the Philippines<br>
                Office of the President<br>
                <strong>NATIONAL COMMISSION ON INDIGENOUS PEOPLES</strong><br>
                <strong>NUEVA ECIJA PROVINCIAL OFFICE</strong><br>
                Burgos Ave., Old Capitol Bldg., Cabanatuan City, Nueva Ecija<br>
                Tel. No. 044-950-0088
            </div>
        </div>

        <!-- Confirmation Section -->
        <div style="text-align: right; margin-bottom: 20px; font-size: 12px;">
            <strong>CONFIRMED:</strong><br>
            DONATO B. BUMACAS, PhD.<br>
            DMO V/Provincial Officer<br>
            <em>NOT VALID WITHOUT SEAL</em>
        </div>

        <!-- Certificate Title -->
        <div style="text-align: center; margin: 30px 0;">
            <h2 style="font-size: 18px; font-weight: bold; text-decoration: underline; margin-bottom: 20px;">
                CERTIFICATE OF CONFIRMATION
            </h2>
        </div>

        <!-- Main Content -->
        <div style="font-size: 14px; line-height: 1.6; text-align: justify;">
            <p><strong>BE IT KNOWN</strong></p>
            
            <p style="margin: 20px 0; text-align: center;">
                that<br><br>
                <strong style="font-size: 18px; text-decoration: underline;">
                    {{ strtoupper($record->first_name . ' ' . $record->last_name) }}
                </strong>
            </p>

            <p>
                Is a Bonafide member of the <strong>{{ strtoupper($record->ip_group) }}</strong> Indigenous Cultural Communities 
                as certified by their IP Leader <strong>DOMINADOR A. CEPIAN</strong> of Barangay {{ $record->barangay }}, 
                {{ $record->municipality }}, {{ $record->province }}.
            </p>

            <p>
                That this Office hereby presents and confirms the membership of {{ $record->sex == 'Male' ? 'Mr.' : 'Ms.' }} 
                {{ $record->last_name }} with the <strong>{{ strtoupper($record->ip_group) }}</strong> IP/ICC and is hereby 
                entitled to all rights, benefits and privileges accorded to Indigenous Peoples (IPs/ICC's) as provided under 
                Republic Act 8371 and all other laws, decrees, rules and regulations and other issuance of the government.
            </p>

            <p style="margin-top: 30px;">
                Issued this <strong>{{ date('jS') }}</strong> day of <strong>{{ date('F Y', strtotime($record->census_date)) }}</strong>, 
                upon request of {{ $record->sex == 'Male' ? 'Mr.' : 'Ms.' }} {{ $record->last_name }} for identification of 
                ETHNICITY/ IP group membership.
            </p>
        </div>

        <!-- Signature Section -->
        <div style="margin-top: 50px;">
            <div style="text-align: left; font-size: 12px;">
                Recommending Confirmation:<br><br>
                <strong>ENGR. JONELYN D. BANG-OT</strong><br>
                OIC-Administrative Officer IV as per Memo Order no. R3-{{ date('Y') }}-07-294
            </div>
        </div>

        <!-- Additional Info Section -->
        <div style="margin-top: 40px; border-top: 1px solid #ccc; padding-top: 20px; font-size: 12px;">
            <h4 style="margin-bottom: 15px;">Personal Information:</h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div><strong>Birth Date:</strong> {{ date('F d, Y', strtotime($record->birth_date)) }}</div>
                <div><strong>Civil Status:</strong> {{ $record->civil_status }}</div>
                <div><strong>NCIP Number:</strong> {{ $record->ncip_number ?? 'N/A' }}</div>
                <div><strong>Religion:</strong> {{ $record->religion }}</div>
                <div><strong>Occupation:</strong> {{ $record->occupation }}</div>
                <div><strong>Education:</strong> {{ $record->educational_level }}</div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        .certificate-content { 
            box-shadow: none !important; 
            border: 2px solid #000 !important;
            page-break-inside: avoid;
        }
        body { margin: 0; }
        @page { margin: 0.5in; }
    }
</style>
@endsection