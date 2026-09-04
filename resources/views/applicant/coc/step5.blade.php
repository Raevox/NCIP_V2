@extends('layouts.applicant')

@section('title', __('COC Form - Step 5'))
@section('page-title', __('Step 5: Upload Documents'))

@section('content')
    @include('applicant.coc.progress-circle', ['currentStep' => 5])
    <div class="container-fluid px-2 px-md-4 py-3 py-md-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-11">
                <div class="upload-card">
                    <div class="card-header">
                        <h2 class="card-title">{{ __('Upload Required Documents') }}</h2>
                        <p class="card-subtitle">{{ __('Please upload all required documents to proceed') }}</p>
                    </div>

                    <div class="card-body">
                        @php
                            $isReturned = $application->status === 'Returned';
                            $uploadDocuments = [
                                'applicant_picture' => ['label' => 'Applicant Picture', 'icon' => 'fa-user-circle', 'accept' => 'image/*', 'hint' => 'JPG, PNG, JPEG (Max 5MB)'],
                                'birth_certificate' => ['label' => 'Birth Certificate', 'icon' => 'fa-file-medical', 'accept' => '.pdf,.jpg,.jpeg,.png', 'hint' => 'PDF, JPG, PNG, JPEG (Max 10MB)'],
                                'tribal_certificate' => ['label' => 'Tribal Certificate', 'icon' => 'fa-certificate', 'accept' => '.pdf,.jpg,.jpeg,.png', 'hint' => 'PDF, JPG, PNG, JPEG (Max 10MB)'],
                                'genealogy_form' => ['label' => 'Completed Genealogy Form', 'icon' => 'fa-file-alt', 'accept' => '.pdf,.jpg,.jpeg,.png', 'hint' => 'PDF, JPG, PNG, JPEG (Max 10MB)'],
                            ];
                            $visibleDocuments = $isReturned
                                ? array_intersect_key($uploadDocuments, array_flip($returnedDocuments))
                                : array_diff_key($uploadDocuments, ['birth_certificate' => true]);
                        @endphp

                        @if($isReturned)
                            <div class="alert alert-warning mb-4">
                                <strong>{{ __('Replace only the returned document(s).') }}</strong>
                                {{ __('Your accepted files will remain unchanged.') }}
                            </div>
                        @endif

                        <form id="uploadForm" action="{{ route('applicant.coc.step5.store', $application->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @foreach($visibleDocuments as $field => $document)
                                <div class="upload-section">
                                    <label class="upload-label required" for="{{ $field }}">
                                        <i class="fas {{ $document['icon'] }}"></i>
                                        {{ __($document['label']) }}
                                    </label>
                                    @if($isReturned && !empty($documentRemarks[$field]))
                                        <div class="alert alert-danger py-2 mb-2">
                                            <strong>{{ __('Staff remarks:') }}</strong> {{ $documentRemarks[$field] }}
                                        </div>
                                    @endif
                                    <div class="upload-wrapper">
                                        <input type="file" name="{{ $field }}" id="{{ $field }}"
                                            class="upload-input" required accept="{{ $document['accept'] }}">
                                        <div class="upload-placeholder">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <span class="upload-text">{{ __('Choose file or drag here') }}</span>
                                            <span class="upload-hint">{{ $document['hint'] }}</span>
                                        </div>
                                        <div class="file-info d-none"></div>
                                    </div>
                                    @error($field)
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endforeach

                            {{-- Important Notice --}}
                            @if(!$isReturned || array_key_exists('genealogy_form', $visibleDocuments))
                            <div class="notice-box">
                                <div class="notice-header">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>{{ __('Important Notice') }}</strong>
                                </div>
                                <p class="notice-text">
                                    {{ __('Please download the Genealogy Form from Step 4, print it, and have it attested by') }}
                                    <strong>{{ __('Council of Elders / IP Leader / Punong Barangay') }}</strong>
                                    {{ __('with') }} <strong>{{ __('SIGNATURE OVER PRINTED NAME') }}</strong>. {{ __('Only completed and signed forms can be uploaded here.') }}
                                </p>
                            </div>
                            @endif

                            {{-- Action Buttons --}}
                            <div class="action-buttons">
                                <a href="{{ $isReturned ? route('applicant.dashboard') : route('applicant.coc.step4') }}" class="btn-secondary">
                                    <i class="fas fa-arrow-left"></i>
                                    {{ __('Back') }}
                                </a>

                                @if(
                                    $application->status === 'Returned' && 
                                    $application->documents_status === 'returned' &&
                                    empty($application->index_status) &&
                                    empty($application->genealogy_status)
                                )
                                    <button type="submit" class="btn-primary">
                                        <i class="fas fa-paper-plane"></i>
                                        {{ __('Resubmit Application') }}
                                    </button>
                                @else
                                    <button type="submit" class="btn-primary">
                                        {{ __('Next Step') }}
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
/* Base Styles */
* {
    box-sizing: border-box;
}

.upload-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
    color: #222;
    margin-top: 20px;
    width: 100%;
}

.card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e0e0e0;
    color: #222;
    padding: 1rem;
    text-align: center;
}

.card-title {
    margin: 0 0 0.5rem 0;
    font-size: 1.25rem;
    font-weight: 600;
    color: #222;
    word-wrap: break-word;
}

.card-subtitle {
    margin: 0;
    font-size: 0.875rem;
    opacity: 0.9;
    word-wrap: break-word;
}

.card-body {
    padding: 1rem;
    width: 100%;
}

/* Upload Section */
.upload-section {
    margin-bottom: 1.5rem;
    width: 100%;
}

.upload-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.75rem;
    font-size: 0.9375rem;
    flex-wrap: wrap;
}

.upload-label i {
    color: #3e7b27;
    font-size: 1rem;
    flex-shrink: 0;
}

.upload-label.required::after {
    content: " *";
    color: #dc3545;
    margin-left: 0.25rem;
}

.upload-wrapper {
    position: relative;
    border: 2px dashed #cbd5e0;
    border-radius: 8px;
    background: #f8f9fa;
    transition: all 0.3s ease;
    min-height: 110px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
}

.upload-wrapper:hover {
    background: #245524;
    background: #f1f8f4;
}

.upload-wrapper.has-file {
    border-color: #28a745;
    border-style: solid;
    background: #f1f8f4;
}

.upload-input {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.upload-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    text-align: center;
    width: 100%;
    max-width: 100%;
    border-radius: 12px;
    background: #f9fafb;
    transition: border-color 0.3s, background 0.3s;
    cursor: pointer;
}

/* Hover effect for better UX */
.upload-placeholder:hover {
    border-color: #936d4c; /* matches palette */
    background: #fff;
}

.upload-placeholder i {
    font-size: clamp(1.5rem, 5vw, 2.5rem); /* scales with screen */
    color: #a0aec0;
    margin-bottom: 0.75rem;
}

.upload-text {
    display: block;
    font-size: clamp(0.8125rem, 2.5vw, 0.9375rem); /* responsive font */
    color: #4a5568;
    font-weight: 500;
    margin-bottom: 0.25rem;
    word-wrap: break-word;
}

.upload-hint {
    display: block;
    font-size: clamp(0.75rem, 2vw, 0.8125rem); /* responsive font */
    color: #718096;
    word-wrap: break-word;
}

/* Smallest screens (≤360px, like iPhone SE) */
@media (max-width: 360px) {
    .upload-placeholder {
        padding: 0.75rem;
    }
    .upload-placeholder i {
        margin-bottom: 0.5rem;
    }
}

/* Tablets (≥768px) - adjust layout */
@media (min-width: 768px) {
    .upload-placeholder {
        flex-direction: row;
        text-align: left;
        justify-content: flex-start;
        gap: 1rem;
        padding: 1.5rem;
    }
    .upload-placeholder i {
        margin-bottom: 0;
    }
}

/* Large screens (≥1200px) */
@media (min-width: 1200px) {
    .upload-placeholder {
        max-width: 480px;
        margin: 0 auto;
    }
}

.file-info {
    padding: 0.875rem;
    width: 100%;
}

/* File preview container */
.file-preview {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    margin-top: 0.75rem;
    gap: 0.75rem;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    font-family: 'Poppins', sans-serif;
    word-wrap: break-word;
    overflow-wrap: anywhere;
}

/* File details section */
.file-details {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex: 1;
    min-width: 0;
    flex: 1;
    min-width: 0;
}

.file-icon {
    font-size: 1.25rem;
    color: #4a5568;
    flex-shrink: 0;
}

.file-text {
    flex: 1;
    min-width: 0;
}

/* Filename wraps instead of overflowing */
.file-name {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #2d3748;
    white-space: normal; 
    word-break: break-word;
    overflow-wrap: anywhere;
    max-width: 100%;
}
/* Mobile-specific adjustments */
@media (max-width: 480px) {
    .file-preview {
        flex-direction: column;
        align-items: flex-start;
        padding: 0.75rem;
        gap: 0.5rem;
    }

    .file-details {
        width: 100%;
    }

    .file-remove {
        align-self: flex-end;
        margin-top: 0.25rem;
        width: 28px;
        height: 28px;
    }

    .file-remove i {
        font-size: 0.75rem;
    }
}
.file-size {
    display: inline-block;
    font-size: 0.75rem;
    color: #718096;
    background: #edf2f7;
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
    margin-top: 0.25rem;
}

/* Remove (X) button */
.file-remove {
    background: #f56565;
    border: none;
    color: #fff;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.2s;
    flex-shrink: 0;
}

.file-remove:hover {
    background: #c53030;
}

.file-remove i {
    font-size: 0.875rem;
}

/* --- Mobile adjustments --- */
@media (max-width: 400px) {
    .file-preview {
        padding: 0.5rem 0.75rem;
        gap: 0.5rem;
    }

    .file-icon {
        font-size: 1rem;
    }

    .file-name {
        font-size: 0.8125rem;
    }

    .file-size {
        font-size: 0.6875rem;
    }

    .file-remove {
        width: 26px;
        height: 26px;
        font-size: 0.75rem;
    }

    .file-remove i {
        font-size: 0.75rem;
    }
}


.file-details {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex: 1;
    min-width: 0;
}

.file-icon {
    font-size: 1.75rem;
    color: #28a745;
    flex-shrink: 0;
}

.file-text {
    flex: 1;
    min-width: 0;
    overflow: hidden;
}

.file-name {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #2d3748;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 100%;
}

.file-size {
    display: inline-block;
    font-size: 0.75rem;
    color: #718096;
    padding: 0.15rem 0.5rem;
    background: #e2e8f0;
    border-radius: 4px;
    margin-top: 0.25rem;
    white-space: nowrap;
}

.file-remove {
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.2s;
    flex-shrink: 0;
}

.file-remove:hover {
    background: #c82333;
}

.file-remove i {
    font-size: 0.8125rem;
}

.error-message {
    display: block;
    color: #dc3545;
    font-size: 0.8125rem;
    margin-top: 0.5rem;
    word-wrap: break-word;
}

/* Notice Box */
.notice-box {
    background: #fff3cd;
    border: 1px solid #ffc107;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    width: 100%;
}

.notice-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #856404;
    margin-bottom: 0.75rem;
    font-size: 0.9375rem;
    flex-wrap: wrap;
}

.notice-header i {
    font-size: 1rem;
    flex-shrink: 0;
}

.notice-text {
    color: #856404;
    font-size: 0.875rem;
    line-height: 1.6;
    margin: 0;
    word-wrap: break-word;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.75rem;
    padding-top: 1.25rem;
    border-top: 1px solid #e2e8f0;
    flex-wrap: wrap;
    width: 100%;
}

.btn-secondary,
.btn-primary {
    flex: 1;
    min-width: 130px;
    padding: 0.875rem 1.25rem;
    font-size: 0.9375rem;
    font-weight: 600;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    text-decoration: none;
    min-height: 48px;
    white-space: nowrap;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.btn-primary {
    background: #3e7b27;
    color: white;
}

.btn-primary:hover:not(:disabled) {
    background: #245524;
}

.btn-primary:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

/* Drag and Drop States */
.upload-wrapper.dragging {
    border-color: #28a745;
    background: #e8f5e9;
}

.upload-wrapper.dragging .upload-placeholder i {
    color: #28a745;
    transform: scale(1.1);
}

/* Loading State */
.btn-primary.loading {
    position: relative;
    color: transparent;
}

.btn-primary.loading::after {
    content: "";
    position: absolute;
    width: 20px;
    height: 20px;
    border: 3px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spinner 0.6s linear infinite;
}

@keyframes spinner {
    to { transform: rotate(360deg); }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    * {
        transition: none !important;
    }
}

.upload-input:focus + .upload-placeholder {
    outline: 2px solid #007bff;
    outline-offset: 2px;
}

/* ===========================
   RESPONSIVE BREAKPOINTS
   =========================== */

/* Extra Small Devices (Portrait Phones, less than 576px) */
@media (max-width: 575.98px) {
    .card-header {
        padding: 0.875rem;
    }
    
    .card-title {
        font-size: 1.125rem;
    }
    
    .card-subtitle {
        font-size: 0.8125rem;
    }
    
    .card-body {
        padding: 0.875rem;
    }
    
    .upload-section {
        margin-bottom: 1.25rem;
    }
    
    .upload-label {
        font-size: 0.875rem;
    }
    
    .upload-wrapper {
        min-height: 100px;
    }
    
    .upload-placeholder i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    
    .upload-text {
        font-size: 0.875rem;
    }
    
    .upload-hint {
        font-size: 0.75rem;
    }
    
    .file-info {
        padding: 0.75rem;
    }
    
    .file-preview {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.625rem;
        padding: 0.75rem;
    }
    
    .file-details {
        width: 100%;
        gap: 0.625rem;
    }
    
    .file-icon {
        font-size: 1.5rem;
    }
    
    .file-name {
        font-size: 0.8125rem;
    }
    
    .file-size {
        font-size: 0.6875rem;
    }
    
    .file-remove {
        align-self: flex-end;
        width: 32px;
        height: 32px;
    }
    
    .notice-box {
        padding: 0.875rem;
        margin-bottom: 1.25rem;
    }
    
    .notice-header {
        font-size: 0.875rem;
    }
    
    .notice-text {
        font-size: 0.8125rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.625rem;
        padding-top: 1rem;
    }
    
    .btn-secondary,
    .btn-primary {
        width: 100%;
        min-width: 100%;
        padding: 0.875rem 1rem;
        font-size: 0.875rem;
        min-height: 50px;
    }
}

/* Small Devices (Landscape Phones, 576px to 767px) */
@media (min-width: 576px) and (max-width: 767.98px) {
    .card-header {
        padding: 1rem;
    }
    
    .card-title {
        font-size: 1.25rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .upload-wrapper {
        min-height: 105px;
    }
    
    .upload-placeholder i {
        font-size: 2.25rem;
    }
    
    .action-buttons {
        flex-direction: row;
    }
    
    .btn-secondary,
    .btn-primary {
        min-width: 140px;
    }
}

/* Medium Devices (Tablets, 768px to 991px) */
@media (min-width: 768px) and (max-width: 991.98px) {
    .card-header {
        padding: 1.25rem;
    }
    
    .card-title {
        font-size: 1.375rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .upload-section {
        margin-bottom: 1.75rem;
    }
    
    .upload-wrapper {
        min-height: 115px;
    }
    
    .upload-placeholder i {
        font-size: 2.5rem;
    }
    
    .file-icon {
        font-size: 1.875rem;
    }
    
    .notice-box {
        padding: 1.125rem;
    }
}

/* Large Devices (Desktops, 992px and up) */
@media (min-width: 992px) {
    .card-header {
        padding: 1.5rem;
    }
    
    .card-title {
        font-size: 1.5rem;
    }
    
    .card-subtitle {
        font-size: 0.9375rem;
    }
    
    .card-body {
        padding: 2rem;
    }
    
    .upload-section {
        margin-bottom: 2rem;
    }
    
    .upload-wrapper {
        min-height: 120px;
    }
    
    .upload-placeholder i {
        font-size: 3rem;
    }
    
    .upload-text {
        font-size: 1rem;
    }
    
    .upload-hint {
        font-size: 0.875rem;
    }
    
    .file-info {
        padding: 1rem;
    }
    
    .file-preview {
        padding: 1rem;
    }
    
    .file-icon {
        font-size: 2rem;
    }
    
    .file-name {
        font-size: 0.9375rem;
    }
    
    .file-size {
        font-size: 0.8125rem;
    }
    
    .notice-box {
        padding: 1.25rem;
        margin-bottom: 2rem;
    }
    
    .notice-header {
        font-size: 1rem;
    }
    
    .notice-text {
        font-size: 0.9375rem;
    }
    
    .action-buttons {
        gap: 1rem;
        padding-top: 1.5rem;
    }
    
    .btn-secondary,
    .btn-primary {
        padding: 0.875rem 1.5rem;
        font-size: 1rem;
        min-width: 150px;
    }
}

/* Very Small Devices (Less than 360px) */
@media (max-width: 359.98px) {
    .card-title {
        font-size: 1rem;
    }
    
    .card-subtitle {
        font-size: 0.75rem;
    }
    
    .card-body {
        padding: 0.75rem;
    }
    
    .upload-label {
        font-size: 0.8125rem;
    }
    
    .upload-wrapper {
        min-height: 90px;
    }
    
    .upload-placeholder i {
        font-size: 1.75rem;
    }
    
    .upload-text {
        font-size: 0.8125rem;
    }
    
    .upload-hint {
        font-size: 0.6875rem;
    }
    
    .file-name {
        font-size: 0.75rem;
    }
    
    .notice-text {
        font-size: 0.75rem;
    }
    
    .btn-secondary,
    .btn-primary {
        font-size: 0.8125rem;
        padding: 0.75rem 0.875rem;
        min-height: 46px;
    }
}

/* Landscape Orientation for Mobile */
@media (max-width: 767.98px) and (orientation: landscape) {
    .upload-wrapper {
        min-height: 90px;
    }
    
    .upload-placeholder {
        padding: 0.75rem;
    }
    
    .upload-placeholder i {
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
    }
    
    .card-body {
        padding: 0.875rem;
    }
}

/* High DPI Screens */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .upload-wrapper {
        border-width: 1.5px;
    }
}

/* Touch-friendly improvements for touchscreen devices */
@media (hover: none) and (pointer: coarse) {
    .upload-wrapper {
        min-height: 120px;
    }
    
    .btn-secondary,
    .btn-primary {
        min-height: 52px;
        padding: 1rem 1.25rem;
    }
    
    .file-remove {
        width: 36px;
        height: 36px;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInputs = document.querySelectorAll('.upload-input');
    const form = document.getElementById('uploadForm');
    
    fileInputs.forEach(input => {
        const wrapper = input.closest('.upload-wrapper');
        const placeholder = wrapper.querySelector('.upload-placeholder');
        const fileInfo = wrapper.querySelector('.file-info');
        
        // File selection
        input.addEventListener('change', function(e) {
            handleFileSelect(this, wrapper, placeholder, fileInfo);
        });
        
        // Drag and drop
        wrapper.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.add('dragging');
        });
        
        wrapper.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.remove('dragging');
        });
        
        wrapper.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.remove('dragging');
            
            if (e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                handleFileSelect(input, wrapper, placeholder, fileInfo);
            }
        });
    });
    
    function handleFileSelect(input, wrapper, placeholder, fileInfo) {
        if (input.files.length === 0) return;
        
        const file = input.files[0];
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        const fileName = file.name;
        const fileType = file.type;
        
        wrapper.classList.add('has-file');
        placeholder.classList.add('d-none');
        fileInfo.classList.remove('d-none');
        
        const icon = getFileIcon(fileType);
        
        fileInfo.innerHTML = `
            <div class="file-preview">
                <div class="file-details">
                    <i class="${icon} file-icon"></i>
                    <div class="file-text">
                        <span class="file-name" title="${fileName}">${fileName}</span>
                        <span class="file-size">${fileSize} MB</span>
                    </div>
                </div>
                <button type="button" class="file-remove" onclick="removeFile(this, '${input.id}')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
    }
    
    function getFileIcon(fileType) {
        if (fileType.startsWith('image/')) return 'fas fa-file-image';
        if (fileType === 'application/pdf') return 'fas fa-file-pdf';
        return 'fas fa-file';
    }
    
    // Global function to remove file
    window.removeFile = function(button, inputId) {
        const input = document.getElementById(inputId);
        const wrapper = input.closest('.upload-wrapper');
        const placeholder = wrapper.querySelector('.upload-placeholder');
        const fileInfo = wrapper.querySelector('.file-info');
        
        input.value = '';
        wrapper.classList.remove('has-file');
        placeholder.classList.remove('d-none');
        fileInfo.classList.add('d-none');
        fileInfo.innerHTML = '';
    };
    
    // Form submission
    form.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('.btn-primary');
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
    });
    
    // Touch-friendly on mobile
    if ('ontouchstart' in window) {
        document.querySelectorAll('.upload-wrapper').forEach(wrapper => {
            wrapper.style.minHeight = '120px';
        });
    }
    
    // Handle browser back button
    window.addEventListener('pageshow', function(e) {
        if (e.persisted) {
            const submitBtn = form.querySelector('.btn-primary');
            submitBtn.classList.remove('loading');
            submitBtn.disabled = false;
        }
    });
});
</script>
@endpush
