<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Confirmation</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 20px;
            background: white;
            line-height: 1.2;
        }
        
        .header-section {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .coc-number {
            font-size: 11px;
            font-weight: bold;
            text-align: left;
            margin-bottom: 15px;
        }
        
        .republic-text {
            font-size: 12px;
            font-weight: bold;
            margin: 2px 0;
        }
        
        .office-text {
            font-size: 11px;
            margin: 1px 0;
        }
        
        .commission-text {
            font-size: 12px;
            font-weight: bold;
            margin: 2px 0;
        }
        
        .provincial-office {
            font-size: 11px;
            font-weight: bold;
            margin: 5px 0;
        }
        
        .address-text {
            font-size: 10px;
            margin: 1px 0;
        }
        
        .confirmed-section {
            text-align: left;
            margin: 20px 0;
        }
        
        .confirmed-text {
            font-size: 11px;
            font-weight: bold;
        }
        
        .officer-name {
            font-size: 11px;
            font-weight: bold;
            margin: 2px 0;
        }
        
        .officer-title {
            font-size: 10px;
            margin: 1px 0;
        }
        
        .validity-text {
            font-size: 9px;
            font-weight: bold;
            margin-top: 5px;
        }
        
        .certificate-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 25px 0 20px 0;
            text-decoration: underline;
        }
        
        .be-it-known {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin: 15px 0;
        }
        
        .applicant-name {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .content-section {
            text-align: justify;
            font-size: 11px;
            line-height: 1.4;
            margin: 15px 0;
        }
        
        .content-section p {
            margin: 8px 0;
        }
        
        .issued-section {
            margin-top: 25px;
            font-size: 11px;
        }
        
        .recommendation-section {
            margin-top: 30px;
            font-size: 10px;
        }
        
        .signature-line {
            border-bottom: 1px solid black;
            width: 200px;
            margin: 20px 0 5px 0;
        }
        
        .underline {
            text-decoration: underline;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- COC Reference Number -->
    <div class="coc-number">
        COC-R03-NUE-{{ date('m-y', strtotime($record->created_at)) }}-{{ str_pad($record->id, 4, '0', STR_PAD_LEFT) }}
    </div>

    <!-- Header Section -->
    <div class="header-section">
        <div class="republic-text">Republic of the Philippines</div>
        <div class="office-text">Office of the President</div>
        <div class="commission-text">NATIONAL COMMISSION ON INDIGENOUS PEOPLES</div>
        <div class="provincial-office">NUEVA ECIJA PROVINCIAL OFFICE</div>
        <div class="address-text">Burgos Ave., Old Capitol Bldg., Cabanatuan City, Nueva Ecija</div>
        <div class="address-text">Tel. No. 044-950-0088</div>
    </div>

    <!-- Confirmed Section -->
    <div class="confirmed-section">
        <div class="confirmed-text">CONFIRMED:</div>
        <div class="officer-name">DONATO B. BUMACAS, PhD.</div>
        <div class="officer-title">DMO V/Provincial Officer</div>
        <div class="validity-text">NOT VALID WITHOUT SEAL</div>
    </div>

    <!-- Certificate Title -->
    <div class="certificate-title">CERTIFICATE OF CONFIRMATION</div>

    <!-- Be It Known -->
    <div class="be-it-known">BE IT KNOWN</div>
    <div class="be-it-known">that</div>

    <!-- Applicant Name -->
    <div class="applicant-name">{{ strtoupper($record->first_name . ' ' . $record->last_name) }}</div>

    <!-- Content Section -->
    <div class="content-section">
        <p>Is a Bonafide member of the <span class="underline">{{ strtoupper($record->ip_group) }}</span> Indigenous Cultural Communities as certified by their IP Leader <span class="underline">DOMINADOR A. CEPIAN</span> of Barangay {{ ucwords($record->barangay) }}, {{ ucwords($record->municipality) }}, Nueva Ecija.</p>
        
        <p>That this Office hereby presents and confirms the membership of {{ $record->sex == 'Male' ? 'Mr.' : ($record->civil_status == 'Married' ? 'Mrs.' : 'Ms.') }} {{ ucwords($record->last_name) }} with the <span class="underline">{{ strtoupper($record->ip_group) }}</span> IP/ICC and is hereby entitled to all rights, benefits and privileges accorded to Indigenous Peoples (IPs/ICC's) as provided under Republic Act 8371 and all other laws, decrees, rules and regulations and other issuance of the government.</p>
    </div>

    <!-- Issued Section -->
    <div class="issued-section">
        Issued this <span class="underline">{{ date('j', strtotime($record->created_at)) }}<sup>{{ date('S', strtotime($record->created_at)) }}</sup></span> day of {{ date('F Y', strtotime($record->created_at)) }}, upon request of {{ $record->sex == 'Male' ? 'Mr.' : ($record->civil_status == 'Married' ? 'Mrs.' : 'Ms.') }} {{ ucwords($record->last_name) }} for identification of ETHNICITY/ IP group membership.
    </div>

    <!-- Recommendation Section -->
    <div class="recommendation-section">
        <p>Recommending Confirmation:</p>
        <div class="signature-line"></div>
        <div style="font-weight: bold;">ENGR. JONELYN D. BANG-OT</div>
        <div>OIC-Administrative Officer IV as per Memo Order no. R3-2025-07-294</div>
    </div>
</body>
</html>