@extends('layouts.applicant')

@section('title', __('COC Form'))
@section('page-title', __('NCIP COC Form 1'))

@section('content')
@include('applicant.coc.progress-circle', ['currentStep' => 1])
<div class="container-fluid px-2 px-md-4 py-3 py-md-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-11">
            <div class="form-card">
                <div class="card-header">
                    <h2 class="card-title">{{ __('NCIP COC Form 1') }}</h2>
                </div>

                <div class="card-body">
                    <form id="step1Form" action="{{ route('applicant.coc.step1.store') }}" method="POST">
                        @csrf

                        {{-- Region Info --}}
                        <div class="form-section">
                            <h4 class="section-title">{{ __('Region Information') }}</h4>

                            <div class="form-group">
                                <label class="form-label required" for="provinceSearch">{{ __('Province') }}</label>
                                <div class="searchable-select">
                                    <input type="text" 
                                           id="provinceSearch" 
                                           class="form-control search-input" 
                                           placeholder="{{ __('Search province') }}" 
                                           autocomplete="address-level1"
                                           required
                                           value="{{ old('province_name', session('coc_step1.province_name') ?? '') }}">
                                    <i class="fas fa-chevron-down dropdown-icon"></i>
                                    <input type="hidden" name="province" id="province" required value="{{ old('province', session('coc_step1.province') ?? '') }}" aria-hidden="true">
                                    <input type="hidden" name="province_name" id="province_name" required value="{{ old('province_name', session('coc_step1.province_name') ?? '') }}" aria-hidden="true">
                                    <ul id="provinceList" class="dropdown-list" role="listbox" aria-label="Province options"></ul>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label required" for="municipalitySearch">{{ __('Municipality') }}</label>
                                <div class="searchable-select">
                                    <input type="text" 
                                           id="municipalitySearch" 
                                           class="form-control search-input" 
                                           placeholder="{{ __('Search municipality') }}" 
                                           autocomplete="address-level2"
                                           required
                                           value="{{ old('municipality_name', session('coc_step1.municipality_name') ?? '') }}">
                                    <i class="fas fa-chevron-down dropdown-icon"></i>
                                    <input type="hidden" name="municipality" id="municipality" required value="{{ old('municipality', session('coc_step1.municipality') ?? '') }}" aria-hidden="true">
                                    <input type="hidden" name="municipality_name" id="municipality_name" required value="{{ old('municipality_name', session('coc_step1.municipality_name') ?? '') }}" aria-hidden="true">
                                    <ul id="municipalityList" class="dropdown-list" role="listbox" aria-label="Municipality options"></ul>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label required" for="barangaySearch">{{ __('Barangay') }}</label>
                                <div class="searchable-select">
                                    <input type="text" 
                                           id="barangaySearch" 
                                           class="form-control search-input" 
                                           placeholder="{{ __('Search barangay') }}" 
                                           autocomplete="address-level3"
                                           required
                                           value="{{ old('barangay_name', session('coc_step1.barangay_name') ?? '') }}">
                                    <i class="fas fa-chevron-down dropdown-icon"></i>
                                    <input type="hidden" name="barangay" id="barangay" required value="{{ old('barangay', session('coc_step1.barangay') ?? '') }}" aria-hidden="true">
                                    <input type="hidden" name="barangay_name" id="barangay_name" required value="{{ old('barangay_name', session('coc_step1.barangay_name') ?? '') }}" aria-hidden="true">
                                    <ul id="barangayList" class="dropdown-list" role="listbox" aria-label="Barangay options"></ul>
                                </div>
                            </div>
                        </div>

                        {{-- Purpose --}}
                        <div class="form-section">
                            {{-- <h4 class="section-title">Purpose</h4> --}}
                              <legend class="form-label">{{ __('Purpose: (Check only one box)') }}</legend>
                            @php
                                $purposes = [
                                    'Scholarship (SCH)','Local Employment (LE)','Land Matter (LM)','Civil Service Commission (CSC)',
                                    'IPMR (IPMR)','Cert. of Tribal Marriage (CTM)','Travel Abroad (TA)','NAPOLCOM Requirement (PNP)',
                                    'BJMP: Age Waiver (AW)','BuCor: Age Waiver (AW)','BFP: Age Waiver (AW)','AFP: Age Waiver (AW)'
                                ];
                                $oldPurpose = session('coc_step1.purpose', []);
                            @endphp

                            <fieldset>
                                <legend class="visually-hidden">{{ __('Select purposes') }}</legend>
                                <div class="checkbox-grid">
                                    @foreach ($purposes as $key => $purpose)
                                        <label class="checkbox-item">
                                            <input type="checkbox" 
                                                   name="purpose[]" 
                                                   value="{{ $purpose }}" 
                                                   id="purpose{{ $key }}"
                                                   autocomplete="off"
                                                   {{ is_array($oldPurpose) && in_array($purpose, $oldPurpose) ? 'checked' : '' }}>
                                            <span>{{ $purpose }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </fieldset>

                            <div class="form-group mt-3">
                                <label class="form-label" for="purpose_others">{{ __('Others (specify)') }}</label>
                                <input type="text" 
                                       id="purpose_others"
                                       name="purpose_others" 
                                       class="form-control" 
                                       placeholder="{{ __('Type if not listed above') }}"
                                       autocomplete="off"
                                       value="{{ session('coc_step1.purpose_others') ?? '' }}">
                            </div>
                        </div>

                        {{-- Personal Information --}}
                        <div class="form-section">
                            <h4 class="section-title">{{ __('Personal Information') }}</h4>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label required" for="first_name">{{ __('First Name') }}</label>
                                        <input type="text" 
                                               id="first_name"
                                               name="first_name" 
                                               class="form-control" 
                                               autocomplete="given-name"
                                               required
                                               value="{{ old('first_name', $user->first_name ?? session('coc_step1.first_name', '')) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label required" for="last_name">{{ __('Last Name') }}</label>
                                        <input type="text" 
                                               id="last_name"
                                               name="last_name" 
                                               class="form-control" 
                                               autocomplete="family-name"
                                               required
                                               value="{{ old('last_name', $user->last_name ?? session('coc_step1.last_name', '')) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label required" for="sex">{{ __('Sex') }}</label>
                                        <select name="sex" id="sex" class="form-control" autocomplete="sex" required>
                                            <option value="">{{ __('Select') }}</option>
                                            <option value="Male" {{ old('sex', session('coc_step1.sex', '')) == 'Male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                            <option value="Female" {{ old('sex', session('coc_step1.sex', '')) == 'Female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label required" for="civil_status">{{ __('Civil Status') }}</label>
                                        <select name="civil_status" id="civil_status" class="form-control" autocomplete="off" required>
                                            <option value="">{{ __('Select') }}</option>
                                            <option value="Single" {{ old('civil_status', session('coc_step1.civil_status', '')) == 'Single' ? 'selected' : '' }}>{{ __('Single') }}</option>
                                            <option value="Married" {{ old('civil_status', session('coc_step1.civil_status', '')) == 'Married' ? 'selected' : '' }}>{{ __('Married') }}</option>
                                            <option value="Widowed" {{ old('civil_status', session('coc_step1.civil_status', '')) == 'Widowed' ? 'selected' : '' }}>{{ __('Widowed') }}</option>
                                            <option value="Separated" {{ old('civil_status', session('coc_step1.civil_status', '')) == 'Separated' ? 'selected' : '' }}>{{ __('Separated') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- // will be change -->

                            <div class="form-group">
                                <label class="form-label required">{{ __('Place of Origin') }}</label>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="searchable-select">
                                            <input type="text"
                                                id="originProvinceSearch"
                                                class="form-control search-input"
                                                placeholder="{{ __('Search province') }}"
                                                autocomplete="off"
                                                required
                                                value="{{ old('origin_province_name', session('coc_step1.origin_province_name') ?? '') }}">
                                            <i class="fas fa-chevron-down dropdown-icon"></i>
                                            <input type="hidden" name="origin_province" id="origin_province" required value="{{ old('origin_province', session('coc_step1.origin_province') ?? '') }}">
                                            <input type="hidden" name="origin_province_name" id="origin_province_name" required value="{{ old('origin_province_name', session('coc_step1.origin_province_name') ?? '') }}">
                                            <ul id="originProvinceList" class="dropdown-list" role="listbox" aria-label="Origin province options"></ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="searchable-select">
                                            <input type="text"
                                                id="originMunicipalitySearch"
                                                class="form-control search-input"
                                                placeholder="{{ __('Search municipality') }}"
                                                autocomplete="off"
                                                required
                                                value="{{ old('origin_municipality_name', session('coc_step1.origin_municipality_name') ?? '') }}">
                                            <i class="fas fa-chevron-down dropdown-icon"></i>
                                            <input type="hidden" name="origin_municipality" id="origin_municipality" required value="{{ old('origin_municipality', session('coc_step1.origin_municipality') ?? '') }}">
                                            <input type="hidden" name="origin_municipality_name" id="origin_municipality_name" required value="{{ old('origin_municipality_name', session('coc_step1.origin_municipality_name') ?? '') }}">
                                            <ul id="originMunicipalityList" class="dropdown-list" role="listbox" aria-label="Origin municipality options"></ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="searchable-select">
                                            <input type="text"
                                                id="originBarangaySearch"
                                                class="form-control search-input"
                                                placeholder="{{ __('Search barangay') }}"
                                                autocomplete="off"
                                                required
                                                value="{{ old('origin_barangay_name', session('coc_step1.origin_barangay_name') ?? '') }}">
                                            <i class="fas fa-chevron-down dropdown-icon"></i>
                                            <input type="hidden" name="origin_barangay" id="origin_barangay" required value="{{ old('origin_barangay', session('coc_step1.origin_barangay') ?? '') }}">
                                            <input type="hidden" name="origin_barangay_name" id="origin_barangay_name" required value="{{ old('origin_barangay_name', session('coc_step1.origin_barangay_name') ?? '') }}">
                                            <ul id="originBarangayList" class="dropdown-list" role="listbox" aria-label="Origin barangay options"></ul>
                                        </div>
                                    </div>
                                </div>

                                {{-- Combined value actually submitted to the backend, keeps validation/storage unchanged --}}
                                <input type="hidden" name="place_origin" id="place_origin" value="{{ old('place_origin', session('coc_step1.place_origin', '')) }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="date_of_birth">{{ __('Date of Birth') }}</label>
                                        <input type="date" 
                                               id="date_of_birth"
                                               name="date_of_birth" 
                                               class="form-control"
                                               autocomplete="bday"
                                               value="{{ old('date_of_birth', session('coc_step1.date_of_birth', '')) }}">
                                    </div>
                                </div>
                               <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="ip_group">{{ __('IP Group') }}</label>
                                    <select name="ip_group" id="ip_group" class="form-control" autocomplete="off">
                                        <option value="">{{ __('Select') }}</option>
                                        @php
                                            $ipGroups = \App\Models\Tribe::active()->orderBy('name')->pluck('name')->toArray();
                                            $selectedIpGroup = old('ip_group', session('coc_step1.ip_group', ''));
                                        @endphp
                                        @foreach($ipGroups as $group)
                                            <option value="{{ $group }}" {{ $selectedIpGroup == $group ? 'selected' : '' }}>
                                                {{ $group }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            </div>
                        </div>

                        {{-- Spouse Information --}}
                
                        <div class="form-section">
                            <p class="spouse-note">{{ __('If married, provide the name of your spouse. If not married, indicate N/A.') }}</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="spouse_first_name">{{ __('First Name') }}</label>
                                        <input type="text" 
                                               name="spouse_first_name" 
                                               id="spouse_first_name"
                                               class="form-control"
                                               placeholder="{{ __('First name') }}"
                                               autocomplete="off"
                                               value="{{ old('spouse_first_name', $user->spouse_first_name ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="spouse_last_name">{{ __('Last Name') }}</label>
                                        <input type="text" 
                                               name="spouse_last_name" 
                                               id="spouse_last_name"
                                               class="form-control"
                                               placeholder="{{ __('Last name') }}"
                                               autocomplete="off"
                                               value="{{ old('spouse_last_name', $user->spouse_last_name ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- Submit --}}
                        <div class="form-actions">
                            <button type="submit" class="btn-submit">
                                <span class="btn-text">{{ __('Next Step') }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Simple Clean Design */
.form-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
    margin-top:30px;
}

.card-header {
    background: #f8f9fa;
    color: white;
    padding: 1.25rem;
    text-align: center;
}

.card-title {
    margin: 0;
    font-size: clamp(1.1rem, 3.5vw, 1.4rem);
    font-weight: 600;
}

.card-body {
    padding: clamp(1.25rem, 3vw, 2rem);
}

/* Form Sections */
.form-section {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.form-section:last-of-type {
    border-bottom: none;
}

.section-title {
    color: #333;
    font-size: clamp(1rem, 2.8vw, 1.15rem);
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #28a745;
}

.helper-text {
    color: #6c757d;
    font-size: clamp(0.8rem, 2vw, 0.875rem);
    margin-bottom: 1rem;
    font-style: italic;
}

/* Form Groups */
.form-group {
    margin-bottom: 1.25rem;
}

.form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.4rem;
    display: block;
    font-size: clamp(0.85rem, 2.2vw, 0.9rem);
}

.form-label.required::after {
    content: " *";
    color: #dc3545;
}

.visually-hidden {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0,0,0,0);
    white-space: nowrap;
    border: 0;
}

.form-control {
    width: 100%;
    padding: 0.65rem 0.85rem;
    font-size: clamp(0.875rem, 2.3vw, 0.95rem);
    border: 1px solid #ced4da;
    border-radius: 6px;
    transition: border-color 0.2s;
    min-height: 44px;
}

.form-control:focus {
    border-color: #222;
    outline: none;

}

.form-control:disabled {
    background-color: #f5f5f5;
    color: #999;
    cursor: not-allowed;
}

.form-control::placeholder {
    color: #adb5bd;
}

/* Searchable Select */
/* .searchable-select {
    position: relative;
}

.search-input {
    padding-right: 2.5rem;
} */

.searchable-select{
    position: relative;
    width:100%;
}

.search-input{
    width:100%;
    padding-right:2.5rem;
}

.form-group .row.g-3 {
    --bs-gutter-x: 1rem;
    --bs-gutter-y: 1rem;
}

.searchable-select {
    width: 100%;
}

.search-input {
    width: 100%;
}

@media (max-width: 768px) {
    .form-group .col-md-4 {
        margin-bottom: .75rem;
    }
}

.dropdown-icon {
    position: absolute;
    right: 0.85rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    pointer-events: none;
    font-size: 0.8rem;
    transition: transform 0.2s;
}

.searchable-select:focus-within .dropdown-icon {
    transform: translateY(-50%) rotate(180deg);
}

.dropdown-list {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    max-height: clamp(180px, 40vh, 250px);
    overflow-y: auto;
    border: 1px solid #28a745;
    border-radius: 6px;
    background: white;
    z-index: 1000;
    list-style: none;
    padding: 0;
    margin: 0.25rem 0 0 0;
    display: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.dropdown-list li {
    padding: 0.65rem 0.85rem;
    cursor: pointer;
    border-bottom: 1px solid #f1f1f1;
    font-size: clamp(0.8rem, 2.1vw, 0.9rem);
    transition: background-color 0.15s;
}

.dropdown-list li:hover,
.dropdown-list li.highlighted {
       background: #3e7b27;
    color: white;
}

.dropdown-list li:last-child {
    border-bottom: none;
}

/* Checkbox Grid */
.checkbox-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.6rem;
}

.checkbox-item {
    display: flex;
    align-items: center;
    padding: 0.6rem 0.75rem;
    background: #f8f9fa;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.15s;
    margin: 0;
}

.checkbox-item:hover {
    background: #e9ecef;
}

.checkbox-item input[type="checkbox"] {
    margin-right: 0.65rem;
    width: 1.1rem;
    height: 1.1rem;
    accent-color: #28a745;
    cursor: pointer;
}

.checkbox-item span {
    font-size: clamp(0.8rem, 2.1vw, 0.875rem);
    color: #495057;
}

/* Submit Button */
.form-actions {
    padding-top: 1.5rem;
    margin-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.btn-submit {
    width: 100%;
    padding: 0.85rem 1.5rem;
    font-size: clamp(0.95rem, 2.5vw, 1.05rem);
    font-weight: 600;
    border: none;
    border-radius: 6px;
    background: #3e7b27 ;
    color: white;
    cursor: pointer;
    transition: background-color 0.2s;
    
}

.btn-submit:hover:not(:disabled) {
    background: #245524;
}

.btn-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.btn-submit.loading .btn-text {
    display: none;
}

.btn-submit.loading .btn-loading {
    display: inline-block;
}

/* Responsive */
@media (min-width: 576px) {
    .checkbox-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 575px) {
    .form-control {
        font-size: 16px; /* Prevents iOS zoom */
    }
    
    select.form-control {
        font-size: 16px;
    }
}

@media (max-width: 400px) {
    .card-body {
        padding: 1rem;
    }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    * {
        transition: none !important;
    }
}

.form-control:focus-visible,
.btn-submit:focus-visible {
    outline-offset: 2px;
}
</style>

<script>

document.addEventListener("DOMContentLoaded", async () => {
    const form = document.getElementById("step1Form");
    const submitBtn = form.querySelector(".btn-submit");
    const civilStatusSelect = document.getElementById("civil_status");
    const spouseFirstName = document.getElementById("spouse_first_name");
    const spouseLastName = document.getElementById("spouse_last_name");

    // Handle spouse fields based on civil status
    function toggleSpouseFields() {
        const status = civilStatusSelect.value;
        const isNotMarried = ['Single', 'Widowed', 'Separated'].includes(status);
        
        if (isNotMarried) {
            spouseFirstName.value = 'N/A';
            spouseLastName.value = 'N/A';
            spouseFirstName.disabled = true;
            spouseLastName.disabled = true;
        } else {
            if (spouseFirstName.value === 'N/A') spouseFirstName.value = '';
            if (spouseLastName.value === 'N/A') spouseLastName.value = '';
            spouseFirstName.disabled = false;
            spouseLastName.disabled = false;
        }
    }

    // Initialize on load
    toggleSpouseFields();
    civilStatusSelect.addEventListener('change', toggleSpouseFields);

    // Load location data
    try {
        const [provincesRes, municipalitiesRes, barangaysRes] = await Promise.all([
            fetch('{{ asset("data/provinces.json") }}'),
            fetch('{{ asset("data/mun.json") }}'),
            fetch('{{ asset("data/brgy.json") }}')
        ]);
        
        if (!provincesRes.ok || !municipalitiesRes.ok || !barangaysRes.ok) {
            throw new Error('Failed to fetch location data');
        }
        
        const provinces = (await provincesRes.json()).RECORDS;
        const municipalities = (await municipalitiesRes.json()).RECORDS;
        const barangays = (await barangaysRes.json()).RECORDS;

        function setupSearch(inputId, listId, hiddenId, hiddenNameId, dataset, filterKey, labelKey, parentFilterKey = null, parentInputId = null) {
            const input = document.getElementById(inputId);
            const list = document.getElementById(listId);
            const hidden = document.getElementById(hiddenId);
            const hiddenName = document.getElementById(hiddenNameId);
            let debounceTimer;

            input.addEventListener("input", () => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    const query = input.value.toLowerCase().trim();
                    let filtered = dataset;

                    if (parentFilterKey && parentInputId) {
                        const parentVal = document.getElementById(parentInputId).value;
                        if (parentVal) {
                            filtered = filtered.filter(item => item[parentFilterKey] === parentVal);
                        }
                    }

                    if (query) {
                        filtered = filtered.filter(item => 
                            item[labelKey].toLowerCase().includes(query)
                        ).slice(0, 50);
                    } else {
                        filtered = filtered.slice(0, 50);
                    }

                    if (input.value !== hiddenName.value) {
                        hidden.value = "";
                        hiddenName.value = "";
                    }

                    renderDropdown(filtered);
                }, 300);
            });

            input.addEventListener("focus", () => {
                if (input.value && !hidden.value) {
                    input.dispatchEvent(new Event('input'));
                }
            });

            input.addEventListener("blur", () => {
                setTimeout(() => {
                    list.style.display = "none";
                }, 200);
            });

            input.addEventListener('keydown', function(e) {
                if (list.style.display === 'none') return;
                
                const items = Array.from(list.querySelectorAll('li'));
                let currentIndex = items.findIndex(item => item.classList.contains('highlighted'));

                switch(e.key) {
                    case 'ArrowDown':
                        e.preventDefault();
                        currentIndex = currentIndex < items.length - 1 ? currentIndex + 1 : 0;
                        highlightItem(items, currentIndex);
                        break;
                    case 'ArrowUp':
                        e.preventDefault();
                        currentIndex = currentIndex > 0 ? currentIndex - 1 : items.length - 1;
                        highlightItem(items, currentIndex);
                        break;
                    case 'Enter':
                        e.preventDefault();
                        if (currentIndex >= 0 && items[currentIndex]) {
                            items[currentIndex].click();
                        }
                        break;
                    case 'Escape':
                        list.style.display = 'none';
                        break;
                }
            });

            function renderDropdown(items) {
                list.innerHTML = "";
                
                if (items.length === 0) {
                    const li = document.createElement("li");
                    li.textContent = "{{ __('No results found') }}";
                    li.style.color = "#6c757d";
                    li.style.fontStyle = "italic";
                    li.setAttribute('role', 'option');
                    list.appendChild(li);
                } else {
                    items.forEach(item => {
                        const li = document.createElement("li");
                        li.textContent = item[labelKey];
                        li.setAttribute('data-value', item[filterKey]);
                        li.setAttribute('role', 'option');
                        
                        li.addEventListener('mousedown', (e) => {
                            e.preventDefault();

                            input.value = item[labelKey];
                            hidden.value = item[filterKey];
                            hiddenName.value = item[labelKey];
                            list.style.display = "none";
                            
                            input.dispatchEvent(new Event('change'));
                            clearDependentDropdowns(inputId);
                        });
                        
                        list.appendChild(li);
                    });
                }

                list.style.display = items.length ? "block" : "none";
            }

            function highlightItem(items, index) {
                items.forEach(item => item.classList.remove('highlighted'));
                if (items[index]) {
                    items[index].classList.add('highlighted');
                    items[index].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                }
            }
        }

        function clearDependentDropdowns(parentInputId) {
            const dependencyMap = {
                'provinceSearch': ['municipalitySearch', 'barangaySearch'],
                'municipalitySearch': ['barangaySearch'],
                'originProvinceSearch': ['originMunicipalitySearch', 'originBarangaySearch'],
                'originMunicipalitySearch': ['originBarangaySearch']
            };

            if (dependencyMap[parentInputId]) {
                dependencyMap[parentInputId].forEach(id => {
                    const input = document.getElementById(id);
                    const hidden = document.getElementById(id.replace('Search', ''));
                    const hiddenName = document.getElementById(id.replace('Search', '_name'));
                    
                    if (input) {
                        input.value = '';
                        if (hidden) hidden.value = '';
                        if (hiddenName) hiddenName.value = '';
                    }
                });
            }
        }

        setupSearch("provinceSearch", "provinceList", "province", "province_name", provinces, "provCode", "provDesc");
        setupSearch("municipalitySearch", "municipalityList", "municipality", "municipality_name", municipalities, "citymunCode", "citymunDesc", "provCode", "province");
        setupSearch("barangaySearch", "barangayList", "barangay", "barangay_name", barangays, "brgyCode", "brgyDesc", "citymunCode", "municipality");

        setupSearch("originProvinceSearch", "originProvinceList", "origin_province", "origin_province_name", provinces, "provCode", "provDesc");
        setupSearch("originMunicipalitySearch", "originMunicipalityList", "origin_municipality", "origin_municipality_name", municipalities, "citymunCode", "citymunDesc", "provCode", "origin_province");
        setupSearch("originBarangaySearch", "originBarangayList", "origin_barangay", "origin_barangay_name", barangays, "brgyCode", "brgyDesc", "citymunCode", "origin_municipality");

        function updatePlaceOrigin() {
            const barangay = document.getElementById('origin_barangay_name').value;
            const municipality = document.getElementById('origin_municipality_name').value;
            const province = document.getElementById('origin_province_name').value;

            const parts = [barangay, municipality, province].filter(p => p && p.trim().length > 0);
            document.getElementById('place_origin').value = parts.join(', ');
        }

        ['originBarangaySearch', 'originMunicipalitySearch', 'originProvinceSearch'].forEach(id => {
            document.getElementById(id).addEventListener('change', updatePlaceOrigin);
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.searchable-select')) {
                document.querySelectorAll('.dropdown-list').forEach(list => {
                    list.style.display = 'none';
                });
            }
        });

        form.addEventListener("submit", function(e) {
            const province = document.getElementById("province").value;
            const municipality = document.getElementById("municipality").value;
            const barangay = document.getElementById("barangay").value;

            const originProvince = document.getElementById("origin_province").value;
            const originMunicipality = document.getElementById("origin_municipality").value;
            const originBarangay = document.getElementById("origin_barangay").value;

            if (!province || !municipality || !barangay) {
                e.preventDefault();
                alert("{{ __('Please select Province, Municipality, and Barangay from the dropdown lists.') }}");
                return;
            }

            if (!originProvince || !originMunicipality || !originBarangay) {
                e.preventDefault();
                alert("{{ __('Please select Place of Origin (Province, Municipality, Barangay) from the dropdown lists.') }}");
                return;
            }

            updatePlaceOrigin();

            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        });

    } catch (error) {
        console.error('Error loading location data:', error);
        alert('{{ __('Error loading location data. Please refresh the page.') }}');
    }

    if ('ontouchstart' in window) {
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('touchstart', function() {
                this.focus();
            }, { passive: true });
        });
    }

    let isSubmitting = false;
    form.addEventListener('submit', function(e) {
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }
        isSubmitting = true;
        setTimeout(() => { isSubmitting = false; }, 3000);
    });

    window.addEventListener('pageshow', function(e) {
        if (e.persisted || (window.performance && window.performance.navigation.type === 2)) {
            submitBtn.classList.remove('loading');
            submitBtn.disabled = false;
            isSubmitting = false;
        }
    });
});

    document.addEventListener("DOMContentLoaded", function () {
    const purposeCheckboxes = document.querySelectorAll("input[name='purpose[]']");
    const purposeOthers = document.getElementById("purpose_others");

    // limit checkboxes to 1 only
    purposeCheckboxes.forEach(cb => {
        cb.addEventListener("change", function () {
            if (this.checked) {
                purposeCheckboxes.forEach(other => {
                    if (other !== this) {
                        other.checked = false;
                    }
                });
                purposeOthers.value = ""; 
            }
        });
    });

    if (purposeOthers) {
        purposeOthers.addEventListener("input", function () {
            if (this.value.trim() !== "") {
                purposeCheckboxes.forEach(cb => cb.checked = false);
            }
        });
    }
});
</script>
@endsection
