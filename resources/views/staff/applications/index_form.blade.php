<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NCIP Certification Form</title>
    <style>
        * {
            box-sizing: border-box;
        }
        
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            font-size: 14px; 
            background: #f5f5f5; 
            padding: 20px;
            margin: 0;
        }
        
        .form-box { 
            border: 1px solid #000; 
            padding: 30px; 
            max-width: 1200px; 
            margin: auto; 
            background: #fff; 
            border-radius: 6px;
        }
        
        .form-header {
            display: grid;
            grid-template-columns: 130px 1fr 130px;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .header-left {
            text-align: center;
            justify-self: start;
        }
        
        .header-left img { 
            max-width: 100px; 
            height: auto;
            margin-bottom: 8px;
        }
        
        .header-left p { 
            font-size: 11px; 
            font-weight: bold; 
            margin: 3px 0;
            line-height: 1.2;
        }
                
        .header-center {
            text-align: center;
            grid-column: 2;
        }

        .header-center p { 
            margin: 3px 0;
            font-size: 13px;
        }
        
        .header-center b { 
            font-size: 15px;
        }
        
        .location-line { 
            margin-top: 12px; 
            font-size: 14px; 
            line-height: 1.8;
        }
        
        .location-line span { 
            display: inline-block; 
            border-bottom: 1px solid #000; 
            min-width: 180px;
            padding: 0 5px;
        }
        
        h2, h3 { 
            margin: 15px 0; 
            font-size: 17px; 
            text-decoration: underline;
        }
        
        h5 {
            font-size: 16px;
            margin: 15px 0;
            font-weight: bold;
        }
        
        h6 {
            font-size: 15px;
            margin: 15px 0 10px 0;
            font-weight: bold;
        }
        
        .title-form h5 { 
            text-align: center;
        }
        
        .purpose-box { 
            border: 1px solid #000; 
            padding: 15px; 
            margin-top: 15px;
        }
        
        .purpose-box h6 {
            margin-top: 0;
        }
        
        .purpose-grid { 
            display: grid; 
            grid-template-columns: repeat(2, 1fr); 
            gap: 8px 20px;
        }
        
        .purpose-grid label { 
            display: flex; 
            align-items: center; 
            gap: 8px;
            font-size: 14px;
        }
        
        .purpose-grid input[type="checkbox"] {
            accent-color: #0d6efd; 
            width: 18px; 
            height: 18px;
            flex-shrink: 0;
        }
        
        .purpose-grid input[type="text"] {
            flex: 1;
            padding: 5px 8px;
            border: 1px solid #000;
            border-radius: 3px;
            font-size: 14px;
        }
        
        .grid-2, .grid-3 { 
            display: grid; 
            gap: 15px 20px; 
            margin-bottom: 15px;
        }
        
        .grid-2 { 
            grid-template-columns: repeat(2, 1fr);
        }
        
        .grid-3 { 
            grid-template-columns: repeat(3, 1fr);
        }
        
        .grid-2 div, .grid-3 div { 
            display: flex; 
            flex-direction: column;
        }
        
        .grid-2 label, .grid-3 label { 
            font-weight: bold; 
            font-size: 14px; 
            margin-bottom: 5px;
        }
        
        .grid-2 input, .grid-3 input, .grid-2 select, .grid-3 select { 
            padding: 8px 10px; 
            border: 1px solid #000; 
            border-radius: 3px; 
            font-size: 14px;
            width: 100%;
        }
        
        .spouse-section {
            margin-bottom: 20px;
        }
        
        .spouse-section p {
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
            font-size: 14px;
        }
        
        table, th, td { 
            border: 1px solid #000;
        }
        
        th, td { 
            padding: 10px; 
            text-align: left;
        }
        
        th {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        
        .land-section { 
            margin-top: 20px; 
            font-size: 14px;
        }
        
        .land-section p { 
            margin: 8px 0;
        }
        
        .land-section label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .land-section input[type="checkbox"] {
            width: 18px;
            height: 18px;
        }
        
        .underline { 
            display: inline-block; 
            border-bottom: 1px solid #000; 
            min-width: 180px;
            padding: 0 5px;
        }
        
        .pledge { 
            border: 1px solid #000; 
            padding: 15px; 
            margin-top: 20px; 
            line-height: 1.6;
        }
        
        .pledge p { 
            margin-bottom: 12px; 
            text-align: justify;
            font-size: 14px;
        }
        
        .signature { 
            margin-top: 40px; 
            text-align: right;
        }
        
        .signature p { 
            margin: 8px 0;
            font-size: 14px;
        }

        /* Tablet Landscape (iPad Pro, iPad Air) */
        @media screen and (max-width: 1024px) {
            .form-box {
                padding: 25px;
            }
            
            body {
                font-size: 13px;
            }
            

            
            .grid-3 {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .purpose-grid {
                gap: 7px 15px;
            }
        }

        /* Tablet Portrait (iPad) */
        @media screen and (max-width: 768px) {
            body {
                padding: 15px;
                font-size: 13px;
            }
            
            .form-box {
                padding: 20px;
            }
            
            .form-header {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .header-left {
                justify-self: center;
                margin-bottom: 15px;
            }
            
            .header-center {
                grid-column: 1;
            }
            
            .location-line {
                font-size: 13px;
            }
            
            .location-line span {
                min-width: 150px;
            }
            
            .grid-2, .grid-3 {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            
            .purpose-grid {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            
            table {
                font-size: 12px;
            }
            
            th, td {
                padding: 8px;
            }
            
            .underline {
                min-width: 120px;
            }
        }

        /* Small Tablets */
        @media screen and (max-width: 600px) {
            body {
                padding: 10px;
                font-size: 12px;
            }
            
            .form-box {
                padding: 15px;
            }
            
            .header-left img {
                max-width: 80px;
            }
            
            .header-left p {
                font-size: 10px;
            }
            
            .header-center p {
                font-size: 12px;
            }
            
            .header-center b {
                font-size: 13px;
            }
            
            h5 {
                font-size: 14px;
            }
            
            h6 {
                font-size: 13px;
            }
            
            .purpose-grid label,
            .grid-2 label,
            .grid-3 label,
            .pledge p,
            .signature p,
            .land-section {
                font-size: 12px;
            }
            
            table {
                font-size: 11px;
            }
            
            th, td {
                padding: 6px;
            }
            
            .grid-2 input, .grid-3 input {
                padding: 6px 8px;
                font-size: 12px;
            }
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .form-box {
                border: none;
                box-shadow: none;
                max-width: 100%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<div class="form-box">
    <!-- HEADER -->
    <div class="form-header">
        <div class="header-left">
            <img src="{{ asset('images/ncip_logo.jpg') }}" alt="NCIP Logo" />
            <p>REGION 3</p>
            <p>CENTRAL LUZON</p>
        </div>
        <div class="header-center">
            <p>Republic of the Philippines</p>
            <p>OFFICE OF THE PRESIDENT</p>
            <p><b>NATIONAL COMMISSION ON INDIGENOUS PEOPLES</b></p>
            <div class="location-line">
                PROVINCE OF <span>{{ $step1['province_name'] ?? '' }}</span><br>
                AD/MUNICIPALITY<span>{{ $step1['municipality_name'] ?? '' }}</span><br>
                AD/BARANGAY OF <span>{{ $step1['barangay_name'] ?? '' }}</span>
            </div>
        </div>
    </div>

    <!-- TITLE -->
    <div class="title-form"><h5>INFORMATION INDEX</h5></div>

    <!-- PURPOSE -->
    <div class="purpose-box">
        <h6>Purpose: (Check only 1 box)</h6>
        <div class="purpose-grid">
            @php
                $purposes = [
                    'Scholarship (SCH)','Local Employment (LE)','Land Matter (LM)','Civil Service Commission (CSC)',
                    'NAPOLCOM Requirement (PNP)','BJMP: Age Waiver (AW)','BuCor: Age Waiver (AW)','BFP: Age Waiver (AW)',
                    'AFP: Age Waiver (AW)','IPMR (IPMR)','Cert. of Tribal Marriage (CTM)','Travel Abroad (TA)'
                ];
                // Make sure we have an array of selected purposes
                $step1Array = is_string($step1) ? json_decode($step1, true) : $step1;
                $selectedPurposes = isset($step1Array['purpose']) ? (is_array($step1Array['purpose']) ? $step1Array['purpose'] : [$step1Array['purpose']]) : [];
            @endphp
            @foreach($purposes as $index => $p)
                <label>
                    <input type="checkbox" 
                        {{ in_array($p, $selectedPurposes) ? 'checked' : '' }} 
                        disabled
                    > 
                    {{ $index+1 }}. {{ $p }}
                </label>
            @endforeach
            <label>Others: <input type="text" value="{{ $step1['purpose_others'] ?? '' }}" readonly></label>
        </div>
    </div>

    <!-- PERSONAL INFO -->
    <h6>I. Personal Information</h6>
    <div class="grid-2">
        <div><label>First Name</label><input type="text" value="{{ $step1['first_name'] ?? '' }}" readonly></div>
        <div><label>Last Name</label><input type="text" value="{{ $step1['last_name'] ?? '' }}" readonly></div>
    </div>
    <div class="grid-3">
        <div><label>Sex</label><input type="text" value="{{ $step1['sex'] ?? '' }}" readonly></div>
        <div><label>Civil Status</label><input type="text" value="{{ $step1['civil_status'] ?? '' }}" readonly></div>
        <div><label>Place Origin</label><input type="text" value="{{ $step1['place_origin'] ?? '' }}" readonly></div>
    </div>

    <!-- SPOUSE -->
    <div class="spouse-section">
        <p>If married, provide the name of your spouse. If not married, indicate N/A.</p>
        <div class="grid-2">
            <div><label>First Name</label><input type="text" value="{{ $step1['spouse_first_name'] ?? 'N/A' }}" readonly></div>
            <div><label>Last Name</label><input type="text" value="{{ $step1['spouse_last_name'] ?? 'N/A' }}" readonly></div>
        </div>
    </div>

    <!-- EDUCATIONAL -->
    <h6>II. Educational Background</h6>
    <div class="grid-2">
        <div><label>Highest Educational Attainment</label><input type="text" value="{{ $step2['educational_attainment'] ?? '' }}" readonly></div>
        <div><label>Degree Obtained</label><input type="text" value="{{ filled($step2['degree_obtained'] ?? null) ? $step2['degree_obtained'] : 'N/A' }}" readonly></div>
    </div>

    <!-- PARENTAL -->
    <h6>III. Parental Background</h6>
    <table>
        <thead>
            <tr><th>Details</th><th>Father</th><th>Mother (Maiden name)</th></tr>
        </thead>
        <tbody>
            <tr>
                <td>Name</td>
                <td>{{ trim(($step2['father_first_name'] ?? '') . ' ' . ($step2['father_last_name'] ?? '')) ?: ($step2['father_name'] ?? '') }}</td>
                <td>{{ trim(($step2['mother_first_name'] ?? '') . ' ' . ($step2['mother_last_name'] ?? '')) ?: ($step2['mother_name'] ?? '') }}</td>
            </tr>
            <tr><td>IP Group</td><td>{{ $step2['father_ipgroup'] ?? '' }}</td><td>{{ $step2['mother_ipgroup'] ?? '' }}</td></tr>
            <tr><td>Place Origin</td><td>{{ $step2['father_origin'] ?? '' }}</td><td>{{ $step2['mother_origin'] ?? '' }}</td></tr>
            <tr><td>Grandfather</td><td>{{ ($step2['paternal_grandfather_first_name'] ?? '') . ' ' . ($step2['paternal_grandfather_last_name'] ?? '') }}</td><td>{{ ($step2['maternal_grandfather_first_name'] ?? '') . ' ' . ($step2['maternal_grandfather_last_name'] ?? '') }}</td></tr>
            <tr><td>IP Group</td><td>{{ $step2['paternal_grandfather_ipgroup'] ?? '' }}</td><td>{{ $step2['maternal_grandfather_ipgroup'] ?? '' }}</td></tr>
            <tr><td>Place Origin</td><td>{{ $step2['paternal_grandfather_origin'] ?? '' }}</td><td>{{ $step2['maternal_grandfather_origin'] ?? '' }}</td></tr>
            <tr><td>Grandmother</td><td>{{ ($step2['paternal_grandmother_first_name'] ?? '') . ' ' . ($step2['paternal_grandmother_last_name'] ?? '') }}</td><td>{{ ($step2['maternal_grandmother_first_name'] ?? '') . ' ' . ($step2['maternal_grandmother_last_name'] ?? '') }}</td></tr>
            <tr><td>IP Group</td><td>{{ $step2['paternal_grandmother_ipgroup'] ?? '' }}</td><td>{{ $step2['maternal_grandmother_ipgroup'] ?? '' }}</td></tr>
            <tr><td>Place Origin</td><td>{{ $step2['paternal_grandmother_origin'] ?? '' }}</td><td>{{ $step2['maternal_grandmother_origin'] ?? '' }}</td></tr>
        </tbody>
    </table>

    <!-- LAND MATTER -->
    <div class="land-section">
        <label><input type="checkbox" disabled> If Purpose is Land Matter fill up the following:</label>
        <p>Homestead/Free Patent No. <span class="underline">{{ $step2['homestead_no'] ?? '' }}</span> Lot No. <span class="underline">{{ $step2['lot_no'] ?? '' }}</span></p>
        <p>Date of Issuance <span class="underline">{{ $step2['issuance_date'] ?? '' }}</span> Area <span class="underline">{{ $step2['area'] ?? '' }}</span></p>
        <p>Location <span class="underline" style="min-width:300px">{{ $step2['location'] ?? '' }}</span></p>
    </div>

    <!-- PLEDGE -->
    <h6>IV. Applicant Pledge</h6>
    <div class="pledge">
        <p>I, {{ $step2['applicant_name'] ?? $application->user->first_name ?? '' }}, do solemnly swear that all data given in the above information are true and correct to the best of my knowledge and based on authentic records.</p>
        <p>I understand that any false information is enough to cause the denial of my application and could subject me to CRIMINAL and/or ADMINISTRATIVE prosecution.</p>
    </div>

    <!-- SIGNATURE -->
    <div class="signature">
        <p>__________________________</p>
        <p><b>Signature of Applicant</b></p>
    </div>
</div>
</body>
</html>
