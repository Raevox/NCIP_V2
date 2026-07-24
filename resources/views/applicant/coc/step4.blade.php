@extends('layouts.applicant')

@section('title', 'COC Form')
@section('page-title', 'NCIP COC Form 4')

@section('content')
    @include('applicant.coc.progress-circle', ['currentStep' => 4])
    <div class="container-fluid px-2 px-md-4 py-3 py-md-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-11">
                <div class="form-container">
                    <div class="form-header">
                        <h2 class="form-title">NCIP COC FORM 4 (Genealogy - Mother Side)</h2>
                        <p class="form-subtitle">
                            Complete your maternal family genealogy information
                        </p>
                    </div>

                    <div class="form-content">
                        <form id="step4Form" action="{{ route('applicant.coc.step4.store', ['id' => $step4['id'] ?? null]) }}" method="POST">
                            @csrf

                            @php
                                $ipGroups = [
                                    'Bag-o', 'Bontok', 'Kankanaey', 'Applai', 'Alta', 'Dumagat', 'Ibaloi',
                                    'Kalanguya', 'Gaddang', 'Aeta', 'Ilongot (Bugkalot)', 'Kalinga', 'Bajaw',
                                    'Ifugao', 'I-wak', 'Itawis', 'Tingian', 'Itneg', 'Ibanag', 'Sinai'
                                ];
                            @endphp

                            {{-- Generation Marker - Mother --}}
                            <div class="generation-marker">
                                <span class="generation-label">First Generation - Mother</span>
                            </div>

                            {{-- Applicant's Mother --}}
                            <div class="form-section family-section">
                                <h4 class="family-title">Applicant Mother</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="mother_first_name">First Name</label>
                                            <input type="text" 
                                                   name="mother_first_name" 
                                                   id="mother_first_name"
                                                   class="form-control" 
                                                   placeholder="First name"
                                                   autocomplete="off"
                                                   value="{{ old('mother_first_name', $step4['mother_first_name'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="mother_last_name">Last Name</label>
                                            <input type="text" 
                                                   name="mother_last_name" 
                                                   id="mother_last_name"
                                                   class="form-control" 
                                                   placeholder="Last name"
                                                   autocomplete="off"
                                                   value="{{ old('mother_last_name', $step4['mother_last_name'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-origin-picker
                                        name="mother"
                                        label="Place of Origin:"
                                        :old-value="old('mother_origin', $step4['mother_origin'] ?? '')"
                                        :required="false" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="mother_ipgroup">IP Group</label>
                                            <select name="mother_ipgroup" id="mother_ipgroup" class="form-control">
                                                <option value="">Select IP Group</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('mother_ipgroup', $step4['mother_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Generation Marker - Grandparents --}}
                            <div class="generation-marker">
                                <span class="generation-label">Second Generation - Grandparents (Mother's Side)</span>
                            </div>

                            {{-- Maternal Grandfather --}}
                            <div class="form-section family-section">
                                <h4 class="family-title">Grandfather (Mother's Side)</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="maternal_grandfather_first_name">First Name</label>
                                            <input type="text" 
                                                   name="maternal_grandfather_first_name" 
                                                   id="maternal_grandfather_first_name"
                                                   class="form-control"
                                                   placeholder="Enter first name"
                                                   autocomplete="off"
                                                   value="{{ old('maternal_grandfather_first_name', $step4['maternal_grandfather_first_name'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="maternal_grandfather_last_name">Last Name</label>
                                            <input type="text" 
                                                   name="maternal_grandfather_last_name" 
                                                   id="maternal_grandfather_last_name"
                                                   class="form-control"
                                                   placeholder="Enter last name"
                                                   autocomplete="off"
                                                   value="{{ old('maternal_grandfather_last_name', $step4['maternal_grandfather_last_name'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-origin-picker
                                        name="maternal_grandfather"
                                        label="Place of Origin:"
                                        :old-value="old('maternal_grandfather_origin', $step4['maternal_grandfather_origin'] ?? '')"
                                        :required="false" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="maternal_grandfather_ipgroup">IP Group</label>
                                            <select name="maternal_grandfather_ipgroup" id="maternal_grandfather_ipgroup" class="form-control">
                                                <option value="">Select IP Group</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('maternal_grandfather_ipgroup', $step4['maternal_grandfather_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Maternal Grandmother --}}
                            <div class="form-section family-section">
                                <h4 class="family-title">Grandmother (Mother's Side)</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="maternal_grandmother_first_name">First Name</label>
                                            <input type="text" 
                                                   name="maternal_grandmother_first_name" 
                                                   id="maternal_grandmother_first_name"
                                                   class="form-control"
                                                   placeholder="Enter first name"
                                                   autocomplete="off"
                                                   value="{{ old('maternal_grandmother_first_name', $step4['maternal_grandmother_first_name'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="maternal_grandmother_last_name">Last Name</label>
                                            <input type="text" 
                                                   name="maternal_grandmother_last_name" 
                                                   id="maternal_grandmother_last_name"
                                                   class="form-control"
                                                   placeholder="Enter last name"
                                                   autocomplete="off"
                                                   value="{{ old('maternal_grandmother_last_name', $step4['maternal_grandmother_last_name'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-origin-picker
                                        name="maternal_grandmother"
                                        label="Place of Origin:"
                                        :old-value="old('maternal_grandmother_origin', $step4['maternal_grandmother_origin'] ?? '')"
                                        :required="false" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="maternal_grandmother_ipgroup">IP Group</label>
                                            <select name="maternal_grandmother_ipgroup" id="maternal_grandmother_ipgroup" class="form-control">
                                                <option value="">Select IP Group</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('maternal_grandmother_ipgroup', $step4['maternal_grandmother_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Generation Marker - Great Grandparents --}}
                            <div class="generation-marker">
                                <span class="generation-label">Third Generation - Great Grandparents (Grandfather's Side)</span>
                            </div>

                            {{-- Great Grandfather (Grandfather's Father) --}}
                            <div class="form-section family-section">
                                <h4 class="family-title">Great Grandfather (Grandfather's Father)</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandfather_grandfather_mother_first_name">First Name</label>
                                            <input type="text" 
                                                   name="great_grandfather_grandfather_mother_first_name" 
                                                   id="great_grandfather_grandfather_mother_first_name"
                                                   class="form-control"
                                                   placeholder="Enter first name"
                                                   autocomplete="off"
                                                   value="{{ old('great_grandfather_grandfather_mother_first_name', $step4['great_grandfather_grandfather_mother_first_name'] ?? '') }}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandfather_grandfather_mother_last_name">Last Name</label>
                                            <input type="text" 
                                                   name="great_grandfather_grandfather_mother_last_name" 
                                                   id="great_grandfather_grandfather_mother_last_name"
                                                   class="form-control"
                                                   placeholder="Enter last name"
                                                   autocomplete="off"
                                                   value="{{ old('great_grandfather_grandfather_mother_last_name', $step4['great_grandfather_grandfather_mother_last_name'] ?? '') }}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-origin-picker
                                        name="great_grandfather_grandfather_mother"
                                        label="Place of Origin:"
                                        :old-value="old('great_grandfather_grandfather_mother_origin', $step4['great_grandfather_grandfather_mother_origin'] ?? '')"
                                        :required="true" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandfather_grandfather_mother_ipgroup">IP Group</label>
                                            <select name="great_grandfather_grandfather_mother_ipgroup" id="great_grandfather_grandfather_mother_ipgroup" class="form-control" required>
                                                <option value="">Select IP Group</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('great_grandfather_grandfather_mother_ipgroup', $step4['great_grandfather_grandfather_mother_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Great Grandmother (Grandfather's Mother) --}}
                            <div class="form-section family-section">
                                <h4 class="family-title">Great Grandmother (Grandfather's Mother)</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandmother_grandfather_mother_first_name">First Name</label>
                                            <input type="text" 
                                                   name="great_grandmother_grandfather_mother_first_name" 
                                                   id="great_grandmother_grandfather_mother_first_name"
                                                   class="form-control"
                                                   placeholder="Enter first name"
                                                   autocomplete="off"
                                                   value="{{ old('great_grandmother_grandfather_mother_first_name', $step4['great_grandmother_grandfather_mother_first_name'] ?? '') }}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandmother_grandfather_mother_last_name">Last Name</label>
                                            <input type="text" 
                                                   name="great_grandmother_grandfather_mother_last_name" 
                                                   id="great_grandmother_grandfather_mother_last_name"
                                                   class="form-control"
                                                   placeholder="Enter last name"
                                                   autocomplete="off"
                                                   value="{{ old('great_grandmother_grandfather_mother_last_name', $step4['great_grandmother_grandfather_mother_last_name'] ?? '') }}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-origin-picker
                                        name="great_grandmother_grandfather_mother"
                                        label="Place of Origin:"
                                        :old-value="old('great_grandmother_grandfather_mother_origin', $step4['great_grandmother_grandfather_mother_origin'] ?? '')"
                                        :required="true" />
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                            <label class="form-label" for="great_grandmother_grandfather_mother_ipgroup">IP Group</label>
                                            <select name="great_grandmother_grandfather_mother_ipgroup" id="great_grandmother_grandfather_mother_ipgroup" class="form-control" required>
                                                <option value="">Select IP Group</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('great_grandmother_grandfather_mother_ipgroup', $step4['great_grandmother_grandfather_mother_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Generation Marker - Great Grandparents (Grandmother's Side) --}}
                            <div class="generation-marker">
                                <span class="generation-label">Third Generation - Great Grandparents (Grandmother's Side)</span>
                            </div>

                            {{-- Great Grandfather (Grandmother's Father) --}}
                            <div class="form-section family-section">
                                <h4 class="family-title">Great Grandfather (Grandmother's Father)</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandfather_grandmother_mother_first_name">First Name</label>
                                            <input type="text" 
                                                   name="great_grandfather_grandmother_mother_first_name" 
                                                   id="great_grandfather_grandmother_mother_first_name"
                                                   class="form-control"
                                                   placeholder="Enter first name"
                                                   autocomplete="off"
                                                   value="{{ old('great_grandfather_grandmother_mother_first_name', $step4['great_grandfather_grandmother_mother_first_name'] ?? '') }}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandfather_grandmother_mother_last_name">Last Name</label>
                                            <input type="text" 
                                                   name="great_grandfather_grandmother_mother_last_name" 
                                                   id="great_grandfather_grandmother_mother_last_name"
                                                   class="form-control"
                                                   placeholder="Enter last name"
                                                   autocomplete="off"
                                                   value="{{ old('great_grandfather_grandmother_mother_last_name', $step4['great_grandfather_grandmother_mother_last_name'] ?? '') }}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-origin-picker
                                        name="great_grandfather_grandmother_mother"
                                        label="Place of Origin:"
                                        :old-value="old('great_grandfather_grandmother_mother_origin', $step4['great_grandfather_grandmother_mother_origin'] ?? '')"
                                        :required="true" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandfather_grandmother_mother_ipgroup">IP Group</label>
                                            <select name="great_grandfather_grandmother_mother_ipgroup" id="great_grandfather_grandmother_mother_ipgroup" class="form-control" required>
                                                <option value="">Select IP Group</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('great_grandfather_grandmother_mother_ipgroup', $step4['great_grandfather_grandmother_mother_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Great Grandmother (Grandmother's Mother) --}}
                            <div class="form-section family-section">
                                <h4 class="family-title">Great Grandmother (Grandmother's Mother)</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandmother_grandmother_mother_first_name">First Name</label>
                                            <input type="text" 
                                                   name="great_grandmother_grandmother_mother_first_name" 
                                                   id="great_grandmother_grandmother_mother_first_name"
                                                   class="form-control"
                                                   placeholder="Enter first name"
                                                   autocomplete="off"
                                                   value="{{ old('great_grandmother_grandmother_mother_first_name', $step4['great_grandmother_grandmother_mother_first_name'] ?? '') }}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandmother_grandmother_mother_last_name">Last Name</label>
                                            <input type="text" 
                                                   name="great_grandmother_grandmother_mother_last_name" 
                                                   id="great_grandmother_grandmother_mother_last_name"
                                                   class="form-control"
                                                   placeholder="Enter last name"
                                                   autocomplete="off"
                                                   value="{{ old('great_grandmother_grandmother_mother_last_name', $step4['great_grandmother_grandmother_mother_last_name'] ?? '') }}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-origin-picker
                                            name="great_grandmother_grandmother_mother"
                                            label="Place of Origin:"
                                            :old-value="old('great_grandmother_grandmother_mother_origin', $step4['great_grandmother_grandmother_mother_origin'] ?? '')"
                                            :required="true" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandmother_grandmother_mother_ipgroup">IP Group</label>
                                            <select name="great_grandmother_grandmother_mother_ipgroup" id="great_grandmother_grandmother_mother_ipgroup" class="form-control" required>
                                                <option value="">Select IP Group</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('great_grandmother_grandmother_mother_ipgroup', $step4['great_grandmother_grandmother_mother_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            {{-- Important Notice --}}
                            <div class="alert-box alert-warning">
                                <div class="alert-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="alert-content">
                                    <strong>Important:</strong> Please <span class="text-highlight">download and print</span> the Genealogy Form before proceeding to Step 5. You will need to upload the completed PDF in the next step.
                                </div>
                            </div>

                            {{-- Download Button --}}
                            <div class="download-section">
                                <a href="{{ asset('docs/COC-Genealogy-Form-Template-2025.pdf') }}" 
                                   class="btn btn-download" 
                                   download="COC-Genealogy-Form-Template-2025.pdf">
                                    <i class="fas fa-download"></i> Download Genealogy Form
                                </a>
                            </div>

                            {{-- Form Actions --}}
                            <div class="form-actions">
                                <a href="{{ route('applicant.coc.step3') }}" class="btn btn-back">← Back</a>

                                @if(
                                    $application->status === 'Returned' && 
                                    $application->genealogy_status === 'returned' &&
                                    empty($application->index_status) &&
                                    empty($application->documents_status)
                                )
                                    <button type="submit" class="btn btn-next btn-resubmit">
                                        <span class="btn-text"><i class="fas fa-paper-plane"></i> Resubmit Application</span>
                                        <div class="btn-loading d-none">
                                            <i class="fas fa-spinner fa-spin"></i> Processing...
                                        </div>
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-next">
                                        <span class="btn-text">Next Step →</span>
                                        <div class="btn-loading d-none">
                                            <i class="fas fa-spinner fa-spin"></i> Processing...
                                        </div>
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced Responsive CSS --}}
    <style>
    * {
        box-sizing: border-box;
    }

    .form-container {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        margin: 0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-top:30px;
    }

    .form-header {
        background: #f8f9fa;
        border-bottom: 1px solid #e0e0e0;
        padding: 1.5rem 1rem;
        text-align: center;
    }

    .form-title {
        margin: 0 0 0.5rem 0;
        font-size: clamp(1.1rem, 4vw, 1.4rem);
        font-weight: 600;
        color: #333;
    }

    .form-subtitle {
        margin: 0;
        font-size: clamp(0.85rem, 2.5vw, 0.95rem);
        color: #666;
        font-style: italic;
    }

    .form-content {
        padding: 1rem;
    }

    .form-section {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .form-section:last-of-type {
        border-bottom: none;
        margin-bottom: 1rem;
    }

    /* Generation Marker */
    .generation-marker {
        margin: 2rem 0 1.5rem 0;
        text-align: center;
        position: relative;
    }

    .generation-marker::before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
        height: 1px;
        background: #fff;
        z-index: 0;
    }

    .generation-label {
        position: relative;
        background: #fff;
        padding: 0.5rem 1.5rem;
        font-size: clamp(0.85rem, 2.5vw, 0.95rem);
        font-weight: 600;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid #3e7b27;
        border-radius: 20px;
        display: inline-block;
        z-index: 1;
    }

    /* Family Section Styling */
    .family-section {
        background: #ffffff;
        border: 1px solid #e5e5e5;
        border-radius: 8px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .family-title {
        font-size: clamp(0.9rem, 2.8vw, 1rem);
        font-weight: 600;
        color: #222;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #3e7b27;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-label {
        font-size: clamp(0.85rem, 2.5vw, 0.9rem);
        font-weight: 500;
        color: #555;
        margin-bottom: 0.25rem;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 0.5rem 0.75rem;
        font-size: clamp(0.85rem, 2.5vw, 0.9rem);
        border: 1px solid #ddd;
        border-radius: 4px;
        background: #fff;
        color: #333;
        min-height: 42px;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #e5e5e5;
  
    }

    .form-control::placeholder {
        color: #999;
        font-size: clamp(0.8rem, 2.3vw, 0.85rem);
    }

    /* Alert Box */
    .alert-box {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 1.25rem;
        border-radius: 8px;
        margin: 2rem 0 1.5rem 0;
    }

    .alert-warning {
        background: #fff3cd;
        border: 2px solid #ffc107;
        color: #856404;
    }

    .alert-icon {
        font-size: 1.5rem;
        color: #ffc107;
        flex-shrink: 0;
    }

    .alert-content {
        flex: 1;
        font-size: clamp(0.85rem, 2.5vw, 0.95rem);
        line-height: 1.6;
    }

    .alert-content strong {
        font-weight: 600;
        color: #664d03;
    }

    .text-highlight {
        text-decoration: underline;
        text-decoration-style: wavy;
        text-decoration-color: #ffc107;
        font-weight: 600;
    }

    /* Download Section */
    .download-section {
        text-align: center;
        margin: 2rem 0;
        padding: 1.5rem;
        background: #f8f9fa;
        border-radius: 8px;
        border: 2px dashed #28a745;
    }

    .btn-download {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: #3e7b27;
        color: white;
        padding: 0.875rem 2rem;
        font-size: clamp(0.95rem, 2.8vw, 1.05rem);
        font-weight: 600;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.3s ease;

    }

    .btn-download:hover {
        background: #245524;
        color: white;
        transform: translateY(-2px);
    }

    .btn-download i {
        font-size: 1.2rem;
    }

    /* Form Actions */
    .form-actions {
        padding-top: 1.5rem;
        border-top: 2px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        font-size: clamp(0.9rem, 2.8vw, 1rem);
        font-weight: 500;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
        min-height: 44px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-back {
        background: #6c757d;
        color: white;
        min-width: 100px;
    }

    .btn-back:hover {
        background: #5a6268;
        color: white;
    }

    .btn-next {
        background: #3e7b27;
        color: white;
        min-width: 120px;
    }

    .btn-next:hover {
        background: #245524;
    }

    .btn-resubmit {
        background: #007bff;
        min-width: 180px;
    }

    .btn-resubmit:hover {
        background: #0056b3;
    }

    .btn-next:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .btn-loading {
        display: none;
    }

    .btn-next.loading .btn-text {
        display: none;
    }

    .btn-next.loading .btn-loading {
        display: block;
    }

    /* Responsive Breakpoints */
    @media (min-width: 576px) {
        .form-content {
            padding: 1.5rem;
        }

        .family-section {
            padding: 1.5rem;
        }

        .alert-box {
            gap: 1.25rem;
        }
    }

    @media (min-width: 768px) {
        .form-content {
            padding: 2rem;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .family-section {
            padding: 1.75rem;
        }

        .generation-marker {
            margin: 2.5rem 0 2rem 0;
        }

        .alert-icon {
            font-size: 2rem;
        }
    }

    @media (min-width: 992px) {
        .btn-back {
            min-width: 120px;
        }

        .btn-next {
            min-width: 150px;
        }

        .btn-resubmit {
            min-width: 200px;
        }
    }

    @media (max-width: 360px) {
        .form-content {
            padding: 0.75rem;
        }

        .form-control {
            padding: 0.4rem 0.6rem;
            min-height: 38px;
        }

        .family-section {
            padding: 0.75rem;
        }

        .generation-label {
            padding: 0.4rem 1rem;
            font-size: 0.75rem;
        }

        .alert-box {
            flex-direction: column;
            padding: 0.875rem;
        }

        .btn-download {
            padding: 0.75rem 1.5rem;
        }
    }

    @media (max-width: 575px) {
        .form-actions {
            flex-direction: column;
        }

        .btn-back,
        .btn-next,
        .btn-resubmit {
            width: 100%;
        }

        .alert-box {
            gap: 0.75rem;
        }
    }

    /* Error states */
    .form-control.error {
        border-color: #dc3545;
        box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.25);
    }

    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: block;
    }

    /* Accessibility */
    @media (prefers-reduced-motion: reduce) {
        * {
            transition: none !important;
        }
    }

    .form-control:focus-visible,
    .btn:focus-visible,
    .btn-download:focus-visible {
        outline: 2px solid #222;
        outline-offset: 2px;
    }

    /* Loading spinner animation */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .fa-spin {
        animation: spin 1s linear infinite;
    }

    /* Scroll to top button */
    .scroll-indicator {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #3e7b27;
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        z-index: 1000;
        transition: all 0.3s;
    }

    .scroll-indicator:hover {
              background: #245524;
        transform: translateY(-3px);
    }

    .scroll-indicator.show {
        display: flex;
    }
    </style>

    {{-- JavaScript --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('step4Form');
        const submitBtn = form.querySelector('.btn-next');

        // Form submission handling
        let isSubmitting = false;
        form.addEventListener('submit', function(e) {
            if (isSubmitting) {
                e.preventDefault();
                return false;
            }

            isSubmitting = true;
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;

            // Reset after 3 seconds in case of issues
            setTimeout(() => {
                isSubmitting = false;
            }, 3000);
        });

        // Handle browser back/forward
        window.addEventListener('pageshow', function(e) {
            if (e.persisted || (window.performance && window.performance.navigation.type === 2)) {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
                isSubmitting = false;
            }
        });

        // Touch device optimization
        if ('ontouchstart' in window) {
            document.querySelectorAll('.form-control').forEach(input => {
                input.addEventListener('touchstart', function() {
                    this.focus();
                }, { passive: true });
            });
        }

        // Smooth scroll to generation markers
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '0';
                    entry.target.style.transform = 'translateY(20px)';
                    
                    setTimeout(() => {
                        entry.target.style.transition = 'all 0.5s ease';
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, 100);
                    
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe generation markers for animation
        document.querySelectorAll('.generation-marker').forEach(marker => {
            observer.observe(marker);
        });

        // Scroll to top button
        const scrollIndicator = document.createElement('div');
        scrollIndicator.className = 'scroll-indicator';
        scrollIndicator.innerHTML = '↑';
        scrollIndicator.setAttribute('aria-label', 'Scroll to top');
        scrollIndicator.setAttribute('role', 'button');
        scrollIndicator.setAttribute('tabindex', '0');
        document.body.appendChild(scrollIndicator);

        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollIndicator.classList.add('show');
            } else {
                scrollIndicator.classList.remove('show');
            }
        });

        scrollIndicator.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        scrollIndicator.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });

        // Download button tracking (optional analytics)
        const downloadBtn = document.querySelector('.btn-download');
        if (downloadBtn) {
            downloadBtn.addEventListener('click', function() {
                console.log('Genealogy form downloaded');
                // You can add analytics tracking here if needed
            });
        }

        // Highlight download section when scrolled to
        const downloadSection = document.querySelector('.download-section');
        if (downloadSection) {
            const downloadObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'pulse 2s ease-in-out';
                    }
                });
            }, { threshold: 0.5 });

            downloadObserver.observe(downloadSection);
        }

        // Auto-save to sessionStorage
        const autoSaveForm = () => {
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });
            sessionStorage.setItem('coc_step4_draft', JSON.stringify(data));
        };

        // Save form data every 30 seconds
        let autoSaveInterval = setInterval(autoSaveForm, 30000);

        // Clear interval on form submit
        form.addEventListener('submit', function() {
            clearInterval(autoSaveInterval);
            sessionStorage.removeItem('coc_step4_draft');
        });
    });

    // Pulse animation for download section
    const style = document.createElement('style');
    style.textContent = `
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.02);
            }
        }
    `;
    document.head.appendChild(style);
    </script>
@endsection
