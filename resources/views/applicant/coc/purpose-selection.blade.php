@extends('layouts.applicant')

@section('title', 'Select Purpose')
@section('page-title', 'Select Purpose for New Application')

@section('content')
<div class="container-fluid px-2 px-md-4 py-3 py-md-4">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-11 col-md-10 col-lg-8 col-xl-7">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">New Application Using Previous Data</h2>
                    <p class="card-subtitle">Select your purpose for this application</p>
                </div>

                <div class="card-body">
                    <form action="{{ route('applicant.coc.save-purpose') }}" method="POST">
                        @csrf
                        <input type="hidden" name="application_id" value="{{ $application->id }}">
                        
                        <div class="purpose-box">
                            <label class="form-label required">Purpose: (Check only one box)</label>
                            <div class="purpose-grid">
                                <label class="purpose-option">
                                    <input type="checkbox" name="purpose[]" value="Scholarship (SCH)" class="purpose-checkbox">
                                    <span>Scholarship (SCH)</span>
                                </label>
                                <label class="purpose-option">
                                    <input type="checkbox" name="purpose[]" value="Local Employment (LE)" class="purpose-checkbox">
                                    <span>Local Employment (LE)</span>
                                </label>
                                <label class="purpose-option">
                                    <input type="checkbox" name="purpose[]" value="Land Matter (LM)" class="purpose-checkbox">
                                    <span>Land Matter (LM)</span>
                                </label>
                                <label class="purpose-option">
                                    <input type="checkbox" name="purpose[]" value="Civil Service Commission (CSC)" class="purpose-checkbox">
                                    <span>Civil Service Commission (CSC)</span>
                                </label>
                                <label class="purpose-option">
                                    <input type="checkbox" name="purpose[]" value="IPMR (IPMR)" class="purpose-checkbox">
                                    <span>IPMR (IPMR)</span>
                                </label>
                                <label class="purpose-option">
                                    <input type="checkbox" name="purpose[]" value="Cert. of Tribal Marriage (CTM)" class="purpose-checkbox">
                                    <span>Cert. of Tribal Marriage (CTM)</span>
                                </label>
                                <label class="purpose-option">
                                    <input type="checkbox" name="purpose[]" value="Travel Abroad (TA)" class="purpose-checkbox">
                                    <span>Travel Abroad (TA)</span>
                                </label>
                                <label class="purpose-option">
                                    <input type="checkbox" name="purpose[]" value="NAPOLCOM Requirement (PNP)" class="purpose-checkbox">
                                    <span>NAPOLCOM Requirement (PNP)</span>
                                </label>
                                <label class="purpose-option">
                                    <input type="checkbox" name="purpose[]" value="BJMP: Age Waiver (AW)" class="purpose-checkbox">
                                    <span>BJMP: Age Waiver (AW)</span>
                                </label>
                                <label class="purpose-option">
                                    <input type="checkbox" name="purpose[]" value="BuCor: Age Waiver (AW)" class="purpose-checkbox">
                                    <span>BuCor: Age Waiver (AW)</span>
                                </label>
                                <label class="purpose-option">
                                    <input type="checkbox" name="purpose[]" value="BFP: Age Waiver (AW)" class="purpose-checkbox">
                                    <span>BFP: Age Waiver (AW)</span>
                                </label>
                                <label class="purpose-option">
                                    <input type="checkbox" name="purpose[]" value="AFP: Age Waiver (AW)" class="purpose-checkbox">
                                    <span>AFP: Age Waiver (AW)</span>
                                </label>
                            </div>

                            <div class="others-section">
                                <label class="form-label">Others (specify)</label>
                                <input type="text" name="purpose_others" id="purpose_others" class="form-control" placeholder="Type if not listed above">
                            </div>
                        </div>

                        <div class="notice-box mt-4">
                            <div class="notice-header">
                                <i class="fas fa-info-circle"></i>
                                <strong>Information</strong>
                            </div>
                            <p class="notice-text">
                                Your previous application data will be used, and you'll only need to:
                                <ul>
                                    <li>Select a new purpose for this application</li>
                                    <li>Upload required documents in the next step</li>
                                </ul>
                                All other information will be copied from your last approved application.
                            </p>
                        </div>

                        <div class="action-buttons">
                            <a href="{{ route('applicant.dashboard') }}" class="btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn-primary">
                                Proceed to Documents
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
    margin-top:15px;
}

.card-header {
    background: #f8f9fa;
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.card-title {
    margin: 0 0 0.5rem 0;
    font-size: 1.25rem;
    font-weight: 600;
    color: #333;
}

.card-subtitle {
    margin: 0;
    font-size: 0.95rem;
    color: #6c757d;
}

.card-body {
    padding: 1.5rem;
}

.purpose-box {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1.5rem;
}

.form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.75rem;
    display: block;
    font-size: 0.95rem;
}

.form-label.required::after {
    content: " *";
    color: #e53e3e;
}

.purpose-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
    margin-top: 1rem;
}

.purpose-option {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.95rem;
    color: #4a5568;
    cursor: pointer;
    padding: 0.5rem;
    background: #f8f9fa;
    border-radius: 6px;
    transition: background 0.2s;
    margin: 0;
}

.purpose-option:hover {
    background: #e9ecef;
}

.purpose-checkbox {
    width: 20px;
    height: 20px;
    border-radius: 4px;
    border: 2px solid #cbd5e0;
    accent-color: #3e7b27;
    cursor: pointer;
    flex-shrink: 0;
}

.purpose-option span {
    user-select: none;
}

.others-section {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}

.form-control {
    width: 100%;
    padding: 0.5rem 0.75rem;
    font-size: 0.95rem;
    border: 1px solid #ced4da;
    border-radius: 6px;
    transition: border-color 0.2s;
}

.form-control:focus {
    border-color: #3e7b27;
    outline: none;
    box-shadow: 0 0 0 3px rgba(62, 123, 39, 0.1);
}

.form-control::placeholder {
    color: #adb5bd;
}

.notice-box {
    background: #fff3cd;
    border: 1px solid #ffc107;
    border-radius: 8px;
    padding: 1rem;
    margin-top:10px;
}

.notice-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #856404;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.notice-text {
    color: #856404;
    font-size: 0.9rem;
    margin-left: 10px;
    line-height: 1.5;
}

.notice-text ul {
    margin-top: 0.5rem;
    margin-bottom: 0;
    padding-left: 1.5rem !important;
}

.notice-text ul {
    margin-top: 0.5rem;
    margin-bottom: 0;
    padding-left: 2.5rem !important;
}

.action-buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 1.5rem;
    gap: 1rem;
}

.btn-secondary,
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
    font-size: 0.95rem;
}

.btn-secondary {
    background: #718096;
    color: white;
}

.btn-primary {
    background: #3e7b27;
    color: white;
}

.btn-secondary:hover {
    background: #4a5568;
    color: white;
    text-decoration: none;
}

.btn-primary:hover {
    background: #2d5a1f;
}

@media (max-width: 768px) {
    .purpose-grid {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-secondary,
    .btn-primary {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 575px) {
    .card-body {
        padding: 1rem;
    }
    
    .purpose-box {
        padding: 1rem;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const purposeCheckboxes = document.querySelectorAll("input[name='purpose[]']");
    const purposeOthers = document.getElementById("purpose_others");

    // Limit checkboxes to 1 only
    purposeCheckboxes.forEach(cb => {
        cb.addEventListener("change", function() {
            if (this.checked) {
                purposeCheckboxes.forEach(other => {
                    if (other !== this) {
                        other.checked = false;
                    }
                });
                // Clear "Others" field when a checkbox is selected
                if (purposeOthers) {
                    purposeOthers.value = "";
                }
            }
        });
    });

    // If user types in "Others", uncheck all checkboxes
    if (purposeOthers) {
        purposeOthers.addEventListener("input", function() {
            if (this.value.trim() !== "") {
                purposeCheckboxes.forEach(cb => cb.checked = false);
            }
        });
    }
});
</script>
@endpush
@endsection