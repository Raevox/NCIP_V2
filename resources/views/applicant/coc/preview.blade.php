@extends('layouts.applicant')

@section('title', 'COC Preview')
@section('page-title', 'Step 6: Preview & Confirm')

@section('content')
@include('applicant.coc.progress-circle', ['currentStep' => 6])

<style>
   /* Base Styles */
body { 
    font-family: Arial, Helvetica, sans-serif; 
    font-size: 13px; 
    background: #f5f5f5; 
    padding: 15px;
}

.form-box { 
    border: 1px solid #000; 
    padding: 20px; 
    max-width: 1000px; 
    margin: 20px auto;
    background: #fff; 
    border-radius: 6px; 
    page-break-after: always; 
    box-sizing: border-box;
}

.form-header { 
    display: grid; 
    grid-template-columns: 120px 1fr; 
    align-items: center; 
    margin-bottom: 10px; 
    gap: 15px;
}

.header-left { 
    text-align: center; 
}

.header-left img { 
    max-width: 90px; 
    width: 100%;
    height: auto;
    margin-bottom: 5px; 
}

.header-left p { 
    font-size: 11px; 
    font-weight: bold; 
    margin: 2px 0; 
}

.header-center { 
    text-align: center; 
    line-height: 1.4; 
}

.header-center p { 
    margin: 2px 0; 
    font-size: 12px; 
}

.header-center b { 
    font-size: 13px; 
}

.location-line { 
    margin-top: 8px; 
    font-size: 12px; 
    line-height: 1.6; 
}

.location-line span { 
    display: inline-block; 
    border-bottom: 1px solid #000; 
    min-width: 120px; 
    word-wrap: break-word;
}

h2, h3 { 
    margin: 12px 0; 
    font-size: 15px; 
    text-decoration: underline; 
    word-wrap: break-word;
}

.title-form h2 { 
    text-align: center; 
}

.purpose-box { 
    border: 1px solid #000; 
    padding: 12px; 
    margin-top: 10px; 
}

.purpose-grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
    gap: 8px 15px; 
}

.purpose-grid label { 
    display: flex; 
    align-items: center; 
    gap: 5px; 
    font-size: 12px;
    word-wrap: break-word;
}

.purpose-grid input[type="checkbox"] {
    accent-color: #0d6efd; 
    width: 16px; 
    height: 16px;
    flex-shrink: 0;
}

.grid-2, .grid-3 { 
    display: grid; 
    gap: 10px 15px; 
    margin-bottom: 12px; 
}

.grid-2 { 
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
}

.grid-3 { 
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); 
}

.grid-2 div, .grid-3 div { 
    display: flex; 
    flex-direction: column; 
}

.grid-2 label, .grid-3 label { 
    font-weight: bold; 
    font-size: 12px; 
    margin-bottom: 3px; 
    word-wrap: break-word;
}

.grid-2 input, .grid-3 input, .grid-2 select, .grid-3 select { 
    padding: 6px 8px; 
    border: 1px solid #000; 
    border-radius: 3px; 
    font-size: 12px;
    width: 100%;
    box-sizing: border-box;
}

.spouse-section {
    margin: 15px 0;
}

.spouse-section p {
    font-size: 12px;
    margin-bottom: 10px;
    font-style: italic;
    word-wrap: break-word;
}

table { 
    width: 100%; 
    border-collapse: collapse; 
    margin-top: 10px; 
    font-size: 12px;
    overflow-x: auto;
    display: table;
}

table, th, td { 
    border: 1px solid #000; 
}

th, td { 
    padding: 8px; 
    text-align: left;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.land-section { 
    margin-top: 15px; 
    font-size: 12px; 
}

.land-section p { 
    margin: 5px 0; 
    word-wrap: break-word;
}

.underline { 
    display: inline-block; 
    border-bottom: 1px solid #000; 
    min-width: 100px;
    word-wrap: break-word;
}

.pledge { 
    border: 1px solid #000; 
    padding: 12px; 
    margin-top: 15px; 
    line-height: 1.5; 
}

.pledge p { 
    margin-bottom: 8px; 
    text-align: justify; 
    font-size: 12px;
    word-wrap: break-word;
}

/* DOCUMENTS SECTION */
.documents-container {
    max-width: 1000px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    box-sizing: border-box;
}

.documents-header {
    background: #3e7b27;
    color: white;
    padding: 1.5rem;
    border-radius: 8px 8px 0 0;
    margin: -20px -20px 20px -20px;
    text-align: center;
}

.documents-header h3 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
    text-decoration: none;
    word-wrap: break-word;
}

.documents-list {
    display: grid;
    gap: 1rem;
}

.doc-item {
    background: #ffffff;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    transition: all 0.3s ease;
}

.doc-item:hover {
    border-color: #222;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    transform: translateY(-2px);
}

.doc-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.doc-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #c2c4c1 0%, #2d5a2d 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.doc-info {
    flex: 1;
    min-width: 0;
}

.doc-label {
    font-weight: 600;
    font-size: 0.95rem;
    color: #333;
    display: block;
    margin-bottom: 0.25rem;
    word-wrap: break-word;
}

.doc-status {
    font-size: 0.8rem;
    color: #6c757d;
}

.doc-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.view-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.6rem 1.2rem;
    background: #3e7b27;
    color: white !important;
    text-decoration: none;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    min-height: 44px;
    white-space: nowrap;
    width: auto;
    max-width: 40%;
}

.view-btn:hover {
    background: #2d5a1f;
    transform: translateY(-2px);
}

.view-btn i {
    font-size: 1rem;
}

.no-document {
    color: #dc3545;
    font-size: 0.875rem;
    font-style: italic;
}

.text-muted {
    color: #6c757d !important;
    font-size: 0.875rem;
}

/* Action Buttons */
.action-buttons,
div[style*="display: flex"] {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 2px solid #e9ecef;
    flex-wrap: wrap;
}

.btn {
    padding: 0.75rem 1.5rem;
    font-size: 0.95rem;
    font-weight: 500;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    min-height: 48px;
    white-space: nowrap;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
}

.btn-primary {
    background: #3e7b27;
    color: white;
}

.btn-primary:hover {
    background: #245524;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(62, 123, 39, 0.3);
}

/* ===========================
   RESPONSIVE BREAKPOINTS
   =========================== */

/* Tablets and smaller (max-width: 768px) */
@media (max-width: 768px) {
    body {
        padding: 10px;
        font-size: 12px;
    }

    .form-box {
        padding: 15px;
        margin: 15px auto;
    }

    .form-header {
        grid-template-columns: 80px 1fr;
        gap: 10px;
    }

    .header-left img {
        max-width: 70px;
    }

    .header-left p {
        font-size: 9px;
    }

    .header-center p {
        font-size: 10px;
    }

    .header-center b {
        font-size: 11px;
    }

    .location-line {
        font-size: 10px;
    }

    .location-line span {
        min-width: 80px;
    }

    h2, h3 {
        font-size: 13px;
        margin: 10px 0;
    }

    .purpose-box {
        padding: 10px;
    }

    .purpose-grid {
        grid-template-columns: 1fr;
        gap: 6px;
    }

    .purpose-grid label {
        font-size: 11px;
    }

    .grid-2,
    .grid-3 {
        grid-template-columns: 1fr;
        gap: 8px;
    }

    .grid-2 label,
    .grid-3 label {
        font-size: 11px;
    }

    .grid-2 input,
    .grid-3 input {
        font-size: 11px;
        padding: 5px;
    }

    table {
        font-size: 10px;
        display: block;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    th, td {
        padding: 6px 4px;
        font-size: 10px;
    }

    .land-section,
    .spouse-section p,
    .pledge p {
        font-size: 11px;
    }

    .underline {
        min-width: 70px;
    }

    .documents-container {
        padding: 15px;
        margin: 15px auto;
    }

    .documents-header {
        padding: 1.2rem;
        margin: -15px -15px 15px -15px;
    }

    .documents-header h3 {
        font-size: 1.1rem;
    }

    .doc-item {
        padding: 0.875rem;
    }

    .doc-icon {
        width: 36px;
        height: 36px;
        font-size: 1rem;
    }

    .doc-label {
        font-size: 0.875rem;
    }

    .view-btn {
        width: 100%;
        padding: 0.7rem 1rem;
        font-size: 0.85rem;
    }

    .action-buttons,
    div[style*="display: flex"] {
        flex-direction: column;
        gap: 0.75rem;
    }

    .btn {
        width: 100%;
        font-size: 0.875rem;
        padding: 0.75rem 1rem;
    }
}

/* Mobile devices (max-width: 480px) */
@media (max-width: 480px) {
    body {
        padding: 5px;
        font-size: 11px;
    }

    .form-box {
        padding: 12px;
        margin: 10px auto;
        border-radius: 4px;
    }

    .form-header {
        grid-template-columns: 60px 1fr;
        gap: 8px;
        margin-bottom: 8px;
    }

    .header-left img {
        max-width: 50px;
    }

    .header-left p {
        font-size: 8px;
    }

    .header-center p {
        font-size: 9px;
    }

    .header-center b {
        font-size: 10px;
    }

    .location-line {
        font-size: 9px;
        margin-top: 6px;
    }

    .location-line span {
        min-width: 60px;
        font-size: 9px;
    }

    h2, h3 {
        font-size: 12px;
        margin: 8px 0;
    }

    .purpose-box {
        padding: 8px;
        margin-top: 8px;
    }

    .purpose-grid {
        gap: 5px;
    }

    .purpose-grid label {
        font-size: 10px;
        gap: 4px;
    }

    .purpose-grid input[type="checkbox"] {
        width: 14px;
        height: 14px;
    }

    .grid-2,
    .grid-3 {
        gap: 6px;
        margin-bottom: 10px;
    }

    .grid-2 label,
    .grid-3 label {
        font-size: 10px;
        margin-bottom: 2px;
    }

    .grid-2 input,
    .grid-3 input {
        font-size: 10px;
        padding: 4px 6px;
    }

    .spouse-section {
        margin: 12px 0;
    }

    .spouse-section p {
        font-size: 10px;
        margin-bottom: 8px;
    }

    table {
        font-size: 9px;
        margin-top: 8px;
    }

    th, td {
        padding: 4px 3px;
        font-size: 9px;
    }

    .land-section {
        margin-top: 12px;
        font-size: 10px;
    }

    .land-section p {
        margin: 4px 0;
    }

    .underline {
        min-width: 50px;
    }

    .pledge {
        padding: 10px;
        margin-top: 12px;
    }

    .pledge p {
        font-size: 10px;
        margin-bottom: 6px;
    }

    .documents-container {
        padding: 12px;
        margin: 12px auto;
    }

    .documents-header {
        padding: 1rem;
        margin: -12px -12px 12px -12px;
        border-radius: 6px 6px 0 0;
    }

    .documents-header h3 {
        font-size: 1rem;
    }

    .documents-list {
        gap: 0.75rem;
    }

    .doc-item {
        padding: 0.75rem;
        gap: 0.625rem;
    }

    .doc-header {
        gap: 0.625rem;
    }

    .doc-icon {
        width: 32px;
        height: 32px;
        font-size: 0.9rem;
    }

    .doc-label {
        font-size: 0.8125rem;
    }

    .doc-status {
        font-size: 0.75rem;
    }

    .view-btn {
        padding: 0.625rem 0.875rem;
        font-size: 0.8125rem;
        min-height: 42px;
    }

    .view-btn i {
        font-size: 0.875rem;
    }

    .no-document,
    .text-muted {
        font-size: 0.8125rem;
    }

    .btn {
        font-size: 0.8125rem;
        padding: 0.7rem 0.875rem;
        min-height: 46px;
    }
}

/* Very small devices (max-width: 360px) */
@media (max-width: 360px) {
    body {
        padding: 3px;
        font-size: 10px;
    }

    .form-box {
        padding: 10px;
        margin: 8px auto;
    }

    .form-header {
        grid-template-columns: 50px 1fr;
        gap: 6px;
    }

    .header-left img {
        max-width: 45px;
    }

    .header-left p {
        font-size: 7px;
    }

    .header-center p {
        font-size: 8px;
    }

    .header-center b {
        font-size: 9px;
    }

    h2, h3 {
        font-size: 11px;
    }

    .purpose-box {
        padding: 6px;
    }

    .purpose-grid label {
        font-size: 9px;
    }

    .grid-2 label,
    .grid-3 label {
        font-size: 9px;
    }

    .grid-2 input,
    .grid-3 input {
        font-size: 9px;
    }

    table {
        font-size: 8px;
    }

    th, td {
        padding: 3px 2px;
        font-size: 8px;
    }

    .documents-header h3 {
        font-size: 0.9rem;
    }

    .doc-icon {
        width: 28px;
        height: 28px;
        font-size: 0.8rem;
    }

    .doc-label {
        font-size: 0.75rem;
    }

    .view-btn {
        font-size: 0.75rem;
        padding: 0.55rem 0.75rem;
        min-height: 40px;
    }

    .btn {
        font-size: 0.75rem;
        padding: 0.625rem 0.75rem;
        min-height: 44px;
    }
}

/* Landscape orientation for mobile */
@media (max-width: 767px) and (orientation: landscape) {
    .form-header {
        grid-template-columns: 70px 1fr;
    }

    .header-left img {
        max-width: 60px;
    }

    table {
        font-size: 9px;
    }

    th, td {
        padding: 4px;
    }
}

/* Print Styles */
@media print {
    body {
        background: white;
        padding: 0;
    }

    .form-box {
        box-shadow: none;
        margin-bottom: 0;
        page-break-after: always;
        border-radius: 0;
    }

    .documents-container,
    .action-buttons,
    .btn,
    div[style*="display: flex"] {
        display: none !important;
    }

    table {
        page-break-inside: avoid;
    }
}

/* High DPI Screens */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .form-box {
        border-width: 0.75px;
    }
    
    table, th, td {
        border-width: 0.75px;
    }
}

/* Accessibility - Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    * {
        transition: none !important;
        animation: none !important;
    }
}

/* Touch-friendly improvements */
@media (hover: none) and (pointer: coarse) {
    .btn {
        min-height: 52px;
        padding: 0.875rem 1.25rem;
    }

    .view-btn {
        min-height: 48px;
        padding: 0.75rem 1rem;
    }

    .purpose-grid input[type="checkbox"] {
        width: 18px;
        height: 18px;
    }
}
</style>

<div class="form-box">
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
                Province of <span>{{ $step1['province_name'] ?? '' }}</span><br>
                AD/Municipality <span>{{ $step1['municipality_name'] ?? '' }}</span><br>
                AD/Barangay of <span>{{ $step1['barangay_name'] ?? '' }}</span>
            </div>
        </div>
    </div>
    
    <div class="title-form"><h2>INFORMATION INDEX</h2></div>
    
    <div class="purpose-box">
        <h3>Purpose: (Check only 1 box)</h3>
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
            <label>Others: <input type="text" value="{{ $step1Array['purpose_others'] ?? '' }}" readonly></label>
        </div>
    </div>
    
    <h2>I. Personal Information</h2>
    <div class="grid-2">
        <div><label>First Name</label><input type="text" value="{{ $step1['first_name'] ?? '' }}" readonly></div>
        <div><label>Last Name</label><input type="text" value="{{ $step1['last_name'] ?? '' }}" readonly></div>
    </div>
    <div class="grid-3">
        <div><label>Sex</label><input type="text" value="{{ $step1['sex'] ?? '' }}" readonly></div>
        <div><label>Civil Status</label><input type="text" value="{{ $step1['civil_status'] ?? '' }}" readonly></div>
        <div><label>Place of Origin</label><input type="text" value="{{ $step1['place_origin'] ?? '' }}" readonly></div>
    </div>
    
    <div class="spouse-section">
        <p>If married, provide the name of your spouse. If not married, indicate N/A.</p>
        <div class="grid-2">
            <div><label>First Name</label><input type="text" value="{{ $step1['spouse_first_name'] ?? 'N/A' }}" readonly></div>
            <div><label>Last Name</label><input type="text" value="{{ $step1['spouse_last_name'] ?? 'N/A' }}" readonly></div>
        </div>
    </div>
    
    <h3>II. Educational Background</h3>
    <div class="grid-2">
        <div><label>Highest Educational Attainment</label><input type="text" value="{{ $step2['educational_attainment'] ?? '' }}" readonly></div>
        <div><label>Degree Obtained</label><input type="text" value="{{ $step2['degree_obtained'] ?? '' }}" readonly></div>
    </div>
    
    <h3>III. Parental Background</h3>
    <table>
        <thead>
            <tr><th>Details</th><th>Father</th><th>Mother(Maiden name)</th></tr>
        </thead>
        <tbody>
            <tr><td>Name</td><td>{{ $step2['father_name'] ?? '' }}</td><td>{{ $step2['mother_name'] ?? '' }}</td></tr>
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
    
    <div class="land-section">
        <label><input type="checkbox" disabled> If Purpose is Land Matter fill up the following:</label>
        <p>Homestead/Free Patent No. <span class="underline">{{ $step2['homestead_no'] ?? '' }}</span> Lot No. <span class="underline">{{ $step2['lot_no'] ?? '' }}</span></p>
        <p>Date of Issuance <span class="underline">{{ $step2['issuance_date'] ?? '' }}</span> Area <span class="underline">{{ $step2['area'] ?? '' }}</span></p>
        <p>Location <span class="underline" style="min-width:300px">{{ $step2['location'] ?? '' }}</span></p>
    </div>
    
    <h3>IV. Applicant Pledge</h3>
    <div class="pledge">
        <p>I, {{ $step2['applicant_name'] ?? $application->user->first_name ?? '' }}, do solemnly swear that all data given in the above information are true and correct to the best of my knowledge and based on authentic records.</p>
        <p>I understand that any false information is enough to cause the denial of my application and could subject me to CRIMINAL and/or ADMINISTRATIVE prosecution.</p>
    </div>
</div>

<div class="form-box">
    <div class="title-form"><h2>GENEALOGY FORM</h2></div>
    <h3>IV. Genealogy - Father's Side</h3>

    <table>
        <thead>
            <tr>
                <th>Relation</th>
                <th>Full Name</th>
                <th>Place of Origin</th>
                <th>IP Group</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Applicant</td>
                <td>{{ ($step3['applicant_first_name'] ?? '') . ' ' . ($step3['applicant_last_name'] ?? '') }}</td>
                <td>{{ $step3['applicant_origin'] ?? '' }}</td>
                <td>{{ $step3['applicant_ipgroup'] ?? '' }}</td>
            </tr>
            <tr>
                <td>Father</td>
                <td>{{ ($step3['father_first_name'] ?? '') . ' ' . ($step3['father_last_name'] ?? '') }}</td>
                <td>{{ $step3['father_origin'] ?? '' }}</td>
                <td>{{ $step3['father_ipgroup'] ?? '' }}</td>
            </tr>
            <tr>
                <td>Grandfather (Father's Side)</td>
                <td>{{ ($step3['paternal_grandfather_first_name'] ?? '') . ' ' . ($step3['paternal_grandfather_last_name'] ?? '') }}</td>
                <td>{{ $step3['paternal_grandfather_origin'] ?? '' }}</td>
                <td>{{ $step3['paternal_grandfather_ipgroup'] ?? '' }}</td>
            </tr>
            <tr>
                <td>Grandmother (Father's Side)</td>
                <td>{{ ($step3['paternal_grandmother_first_name'] ?? '') . ' ' . ($step3['paternal_grandmother_last_name'] ?? '') }}</td>
                <td>{{ $step3['paternal_grandmother_origin'] ?? '' }}</td>
                <td>{{ $step3['paternal_grandmother_ipgroup'] ?? '' }}</td>
            </tr>
            <tr>
                <td>Great Grandfather (Grandfather's Father)</td>
                <td>{{ ($step3['great_grandfather_grandfather_first_name'] ?? '') . ' ' . ($step3['great_grandfather_grandfather_last_name'] ?? '') }}</td>
                <td>{{ $step3['great_grandfather_grandfather_origin'] ?? '' }}</td>
                <td>{{ $step3['great_grandfather_grandfather_ipgroup'] ?? '' }}</td>
            </tr>
            <tr>
                <td>Great Grandmother (Grandfather's Mother)</td>
                <td>{{ ($step3['great_grandmother_grandfather_first_name'] ?? '') . ' ' . ($step3['great_grandmother_grandfather_last_name'] ?? '') }}</td>
                <td>{{ $step3['great_grandmother_grandfather_origin'] ?? '' }}</td>
                <td>{{ $step3['great_grandmother_grandfather_ipgroup'] ?? '' }}</td>
            </tr>
            <tr>
                <td>Great Grandfather (Grandmother's Father)</td>
                <td>{{ ($step3['great_grandfather_grandmother_first_name'] ?? '') . ' ' . ($step3['great_grandfather_grandmother_last_name'] ?? '') }}</td>
                <td>{{ $step3['great_grandfather_grandmother_origin'] ?? '' }}</td>
                <td>{{ $step3['great_grandfather_grandmother_ipgroup'] ?? '' }}</td>
            </tr>
            <tr>
                <td>Great Grandmother (Grandmother's Mother)</td>
                <td>{{ ($step3['great_grandmother_grandmother_first_name'] ?? '') . ' ' . ($step3['great_grandmother_grandmother_last_name'] ?? '') }}</td>
                <td>{{ $step3['great_grandmother_grandmother_origin'] ?? '' }}</td>
                <td>{{ $step3['great_grandmother_grandmother_ipgroup'] ?? '' }}</td>
            </tr>
        </tbody>
    </table>
    
    <h3>V. Genealogy - Mother's Side</h3>
    <table>
        <thead>
            <tr>
                <th>Relation</th>
                <th>Full Name</th>
                <th>Place of Origin</th>
                <th>IP Group</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Mother</td>
                <td>{{ ($step4['mother_first_name'] ?? '') . ' ' . ($step4['mother_last_name'] ?? '') }}</td>
                <td>{{ $step4['mother_origin'] ?? '' }}</td>
                <td>{{ $step4['mother_ipgroup'] ?? '' }}</td>
            </tr>
            <tr>
                <td>Grandfather (Mother's Side)</td>
                <td>{{ ($step4['maternal_grandfather_first_name'] ?? '') . ' ' . ($step4['maternal_grandfather_last_name'] ?? '') }}</td>
                <td>{{ $step4['maternal_grandfather_origin'] ?? '' }}</td>
                <td>{{ $step4['maternal_grandfather_ipgroup'] ?? '' }}</td>
            </tr>
            <tr>
                <td>Grandmother (Mother's Side)</td>
                <td>{{ ($step4['maternal_grandmother_first_name'] ?? '') . ' ' . ($step4['maternal_grandmother_last_name'] ?? '') }}</td>
                <td>{{ $step4['maternal_grandmother_origin'] ?? '' }}</td>
                <td>{{ $step4['maternal_grandmother_ipgroup'] ?? '' }}</td>
            </tr>
            <tr>
                <td>Great Grandfather (Grandfather's Father)</td>
                <td>{{ ($step4['great_grandfather_grandfather_mother_first_name'] ?? '') . ' ' . ($step4['great_grandfather_grandfather_mother_last_name'] ?? '') }}</td>
                <td>{{ $step4['great_grandfather_grandfather_mother_origin'] ?? '' }}</td>
                <td>{{ $step4['great_grandfather_grandfather_mother_ipgroup'] ?? '' }}</td>
            </tr>
            <tr>
                <td>Great Grandmother (Grandfather's Mother)</td>
                <td>{{ ($step4['great_grandmother_grandfather_mother_first_name'] ?? '') . ' ' . ($step4['great_grandmother_grandfather_mother_last_name'] ?? '') }}</td>
                <td>{{ $step4['great_grandmother_grandfather_mother_origin'] ?? '' }}</td>
                <td>{{ $step4['great_grandmother_grandfather_mother_ipgroup'] ?? '' }}</td>
            </tr>
            <tr>
                <td>Great Grandfather (Grandmother's Father)</td>
                <td>{{ ($step4['great_grandfather_grandmother_mother_first_name'] ?? '') . ' ' . ($step4['great_grandfather_grandmother_mother_last_name'] ?? '') }}</td>
                <td>{{ $step4['great_grandfather_grandmother_mother_origin'] ?? '' }}</td>
                <td>{{ $step4['great_grandfather_grandmother_mother_ipgroup'] ?? '' }}</td>
            </tr>
            <tr>
                <td>Great Grandmother (Grandmother's Mother)</td>
                <td>{{ ($step4['great_grandmother_grandmother_mother_first_name'] ?? '') . ' ' . ($step4['great_grandmother_grandmother_mother_last_name'] ?? '') }}</td>
                <td>{{ $step4['great_grandmother_grandmother_mother_origin'] ?? '' }}</td>
                <td>{{ $step4['great_grandmother_grandmother_mother_ipgroup'] ?? '' }}</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- STYLED DOCUMENTS SECTION --}}
<div class="documents-container">
    <div class="documents-header">
        <h3><i class="fas fa-file-upload"></i> Uploaded Documents</h3>
    </div>

    <div class="documents-list">
        {{-- Applicant Photo --}}
        <div class="doc-item">
            <div class="doc-header">
                <div class="doc-icon">
                    <i class="fas fa-camera"></i>
                </div>
                <div class="doc-info">
                    <span class="doc-label">Applicant Photo</span>
                    <span class="doc-status">
                        @if(!empty($application->applicant_picture))
                            Uploaded
                        @else
                            Not uploaded
                        @endif
                    </span>
                </div>
            </div>
            <div class="doc-actions">
                @if(!empty($application->applicant_picture))
                    <a href="{{ asset('storage/'.$application->applicant_picture) }}" target="_blank" class="view-btn">
                        <i class="fas fa-eye"></i> View Photo
                    </a>
                @else
                    <span class="no-document">No photo uploaded</span>
                @endif
            </div>
        </div>

           {{-- Birth Certificate --}}
                <div class="doc-item mb-3">
                    <span class="doc-label fw-bold">Birth Certificate:</span>
                   @if($ipAccount && $ipAccount->document_path)
                            <a href="{{ asset('storage/' . $ipAccount->document_path) }}" target="_blank"class="view-btn btn btn-outline-primary btn-sm ms-2">
                                View
                            </a>
                        @else
                            <p>No birth certificate uploaded yet.</p>
                        @endif                                   
                </div>
                            

                {{-- Signature removed — no longer required in step 5 --}}

                {{-- Tribal Certificate --}}
                <div class="doc-item mb-3">
                    <span class="doc-label fw-bold">Certificate of Tribal Chieftain:</span>
                    @if(!empty($application->tribal_certificate))
                        <a href="{{ asset('storage/'.$application->tribal_certificate) }}" target="_blank" class="view-btn btn btn-outline-primary btn-sm ms-2">View</a>
                    @else
                        <span class="text-muted ms-2">No certificate uploaded</span>
                    @endif
                </div>
                {{-- Genealogy Form --}}
                <div class="doc-item mb-3">
                    <span class="doc-label fw-bold">Genealogy Form:</span>
                    @if(!empty($application->genealogy_form))
                        <a href="{{ asset('storage/'.$application->genealogy_form) }}" target="_blank" class="view-btn btn btn-outline-primary btn-sm ms-2">View</a>
                    @else
                        <span class="text-muted ms-2">No genealogy form uploaded</span>
                    @endif
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    ← Back
                </a>
                <form action="{{ route('applicant.coc.submit', $application->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </form>
            </div>

            </div>
        </div>
    </div>
</div>

@endsection
