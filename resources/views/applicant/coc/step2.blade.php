@extends('layouts.applicant')

@section('title', __('COC Form'))
@section('page-title', __('NCIP COC Form 2'))

@section('content')
    @include('applicant.coc.progress-circle', ['currentStep' => 2])
    <div class="container-fluid px-2 px-md-4 py-3 py-md-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-11">
                <div class="form-container">
                    <div class="form-header">
                        <h2 class="form-title">{{ __('NATIONAL COMMISSION ON INDIGENOUS PEOPLES') }}</h2>
                        <p class="form-subtitle">
                            <strong>{{ __('Direction:') }}</strong> {{ __('The information below will be used to fill out Certificate of Confirmation.') }}<br>
                            {{ __('Please fill out this form as completely and accurately as possible.') }}
                        </p>
                    </div>

                    <div class="form-content">
                        <form id="step2Form" action="{{ route('applicant.coc.step2.store') }}" method="POST">
                            @csrf
                            @php
                                $ipGroups = \App\Models\Tribe::active()->orderBy('name')->pluck('name')->toArray();
                                $applicantPledgeName = trim(
                                    ($step1['first_name'] ?? $user->first_name ?? '') . ' ' .
                                    ($step1['last_name'] ?? $user->last_name ?? '')
                                );
                            @endphp

                            {{-- Educational Background --}}
                            <div class="form-section">
                                <h4 class="section-title">{{ __('II. Educational Background') }}</h4>
                                
                                <div class="form-group">
                                    <label class="form-label" for="educational_attainment">{{ __('Highest Educational Attainment:') }}</label>
                                    <select name="educational_attainment" id="educational_attainment" class="form-control" required>
                                        <option value="">{{ __('-- Select Educational Attainment --') }}</option>
                                        <option value="Elementary" {{ old('educational_attainment', $step2['educational_attainment'] ?? '') == 'Elementary' ? 'selected' : '' }}>{{ __('Elementary') }}</option>
                                        <option value="High School" {{ old('educational_attainment', $step2['educational_attainment'] ?? '') == 'High School' ? 'selected' : '' }}>{{ __('High School') }}</option>
                                        <option value="College" {{ old('educational_attainment', $step2['educational_attainment'] ?? '') == 'College' ? 'selected' : '' }}>{{ __('College') }}</option>
                                        <option value="Post Graduate" {{ old('educational_attainment', $step2['educational_attainment'] ?? '') == 'Post Graduate' ? 'selected' : '' }}>{{ __('Post Graduate') }}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="degree_obtained">{{ __('Degree Obtained:') }}</label>
                                    <input type="text" 
                                           name="degree_obtained" 
                                           id="degree_obtained"
                                           class="form-control"
                                           placeholder="{{ __('Enter your degree (if any)') }}"
                                           autocomplete="off"
                                           value="{{ old('degree_obtained', $step2['degree_obtained'] ?? '') }}">
                                </div>
                            </div>

                            {{-- Parental Background --}}
                            <div class="form-section">
                                <h4 class="section-title">{{ __('III. Parental Background') }}</h4>
                                
                                <div class="parental-grid">
                                    {{-- Parents Section --}}
                                    <div class="parent-section">
                                        <h5 class="parent-title">{{ __('Father') }}</h5>
                                        
                                        <div class="form-group">
                                            <label class="form-label" for="father_first_name">{{ __("Father's First Name:") }}</label>
                                            <input type="text" 
                                                name="father_first_name" 
                                                id="father_first_name"
                                                class="form-control"
                                                placeholder="{{ __('Enter first name') }}"
                                                autocomplete="off"
                                                value="{{ old('father_first_name', $step2['father_first_name'] ?? '') }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="father_last_name">{{ __("Father's Last Name:") }}</label>
                                            <input type="text" 
                                                name="father_last_name" 
                                                id="father_last_name"
                                                class="form-control"
                                                placeholder="{{ __('Enter last name') }}"
                                                autocomplete="off"
                                                value="{{ old('father_last_name', $step2['father_last_name'] ?? '') }}" required>
                                        </div>
                                        

                                        <div class="form-group">
                                            <label class="form-label" for="father_ipgroup">{{ __('IP Group:') }}</label>
                                            <select name="father_ipgroup" id="father_ipgroup" class="form-control" required>
                                                <option value="">{{ __('Select IP Group') }}</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('father_ipgroup', $step2['father_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                       <x-origin-picker
                                        name="father"
                                        :label="__('Place of Origin:')"
                                        :old-value="old('father_origin', $step2['father_origin'] ?? '')"
                                        :required="true" />
                                    </div>

                                    <div class="parent-section">
                                        <h5 class="parent-title">{{ __('Mother (Maiden Name)') }}</h5>
                                        
                                        <div class="form-group">
                                            <label class="form-label" for="mother_first_name">{{ __("Mother's First Name:") }}</label>
                                            <input type="text" 
                                                name="mother_first_name" 
                                                id="mother_first_name"
                                                class="form-control"
                                                placeholder="{{ __('Enter first name (maiden)') }}"
                                                autocomplete="off"
                                                value="{{ old('mother_first_name', $step2['mother_first_name'] ?? '') }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="mother_last_name">{{ __("Mother's Last Name:") }}</label>
                                            <input type="text" 
                                                name="mother_last_name" 
                                                id="mother_last_name"
                                                class="form-control"
                                                placeholder="{{ __('Enter last name (maiden)') }}"
                                                autocomplete="off"
                                                value="{{ old('mother_last_name', $step2['mother_last_name'] ?? '') }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="mother_ipgroup">{{ __('IP Group:') }}</label>
                                            <select name="mother_ipgroup" id="mother_ipgroup" class="form-control" required>
                                                <option value="">{{ __('Select IP Group') }}</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('mother_ipgroup', $step2['mother_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <x-origin-picker
                                        name="mother"
                                        :label="__('Place of Origin:')"
                                        :old-value="old('mother_origin', $step2['mother_origin'] ?? '')"
                                        :required="true" />
                                    </div>

                                    {{-- Grandparents Header --}}
                                    <div class="grandparent-header">
                                        <h5 class="section-subtitle">{{ __('Grandparents') }}</h5>
                                    </div>

                                    {{-- Paternal Grandfather --}}
                                    <div class="parent-section">
                                        <h5 class="parent-title">{{ __('Paternal Grandfather') }}</h5>
                                        
                                        <div class="form-group">
                                            <label class="form-label" for="paternal_grandfather_first_name">{{ __('First Name:') }}</label>
                                            <input type="text" 
                                                   name="paternal_grandfather_first_name" 
                                                   id="paternal_grandfather_first_name"
                                                   class="form-control"
                                                   placeholder="{{ __('Enter first name') }}"
                                                   autocomplete="off"
                                                   value="{{ old('paternal_grandfather_first_name', $step2['paternal_grandfather_first_name'] ?? '') }}"required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="paternal_grandfather_last_name">{{ __('Last Name:') }}</label>
                                            <input type="text" 
                                                   name="paternal_grandfather_last_name" 
                                                   id="paternal_grandfather_last_name"
                                                   class="form-control"
                                                   placeholder="{{ __('Enter last name') }}"
                                                   autocomplete="off"
                                                   value="{{ old('paternal_grandfather_last_name', $step2['paternal_grandfather_last_name'] ?? '') }}"required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="paternal_grandfather_ipgroup">{{ __('IP Group:') }}</label>
                                            <select name="paternal_grandfather_ipgroup" id="paternal_grandfather_ipgroup" class="form-control" required>
                                                <option value="">{{ __('Select IP Group') }}</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('paternal_grandfather_ipgroup', $step2['paternal_grandfather_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <x-origin-picker
                                        name="paternal_grandfather"
                                        :label="__('Place of Origin:')"
                                        :old-value="old('paternal_grandfather_origin', $step2['paternal_grandfather_origin'] ?? '')"
                                        :required="true" />
                                    </div>

                                    {{-- Maternal Grandfather --}}
                                    <div class="parent-section">
                                        <h5 class="parent-title">{{ __('Maternal Grandfather') }}</h5>
                                        
                                        <div class="form-group">
                                            <label class="form-label" for="maternal_grandfather_first_name">{{ __('First Name:') }}</label>
                                            <input type="text" 
                                                   name="maternal_grandfather_first_name" 
                                                   id="maternal_grandfather_first_name"
                                                   class="form-control"
                                                   placeholder="{{ __('Enter first name') }}"
                                                   autocomplete="off"
                                                   value="{{ old('maternal_grandfather_first_name', $step2['maternal_grandfather_first_name'] ?? '') }}"required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="maternal_grandfather_last_name">{{ __('Last Name:') }}</label>
                                            <input type="text" 
                                                   name="maternal_grandfather_last_name" 
                                                   id="maternal_grandfather_last_name"
                                                   class="form-control"
                                                   placeholder="{{ __('Enter last name') }}"
                                                   autocomplete="off"
                                                   value="{{ old('maternal_grandfather_last_name', $step2['maternal_grandfather_last_name'] ?? '') }}"required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="maternal_grandfather_ipgroup">{{ __('IP Group:') }}</label>
                                            <select name="maternal_grandfather_ipgroup" id="maternal_grandfather_ipgroup" class="form-control" required>
                                                <option value="">{{ __('Select IP Group') }}</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('maternal_grandfather_ipgroup', $step2['maternal_grandfather_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <x-origin-picker
                                        name="maternal_grandfather"
                                        :label="__('Place of Origin:')"
                                        :old-value="old('maternal_grandfather_origin', $step2['maternal_grandfather_origin'] ?? '')"
                                        :required="true" />
                                    </div>

                                    {{-- Paternal Grandmother --}}
                                    <div class="parent-section">
                                        <h5 class="parent-title">{{ __('Paternal Grandmother') }}</h5>
                                        
                                        <div class="form-group">
                                            <label class="form-label" for="paternal_grandmother_first_name">{{ __('First Name:') }}</label>
                                            <input type="text" 
                                                   name="paternal_grandmother_first_name" 
                                                   id="paternal_grandmother_first_name"
                                                   class="form-control"
                                                   placeholder="{{ __('Enter first name') }}"
                                                   autocomplete="off"
                                                   value="{{ old('paternal_grandmother_first_name', $step2['paternal_grandmother_first_name'] ?? '') }}"required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="paternal_grandmother_last_name">{{ __('Last Name:') }}</label>
                                            <input type="text" 
                                                   name="paternal_grandmother_last_name" 
                                                   id="paternal_grandmother_last_name"
                                                   class="form-control"
                                                   placeholder="{{ __('Enter last name') }}"
                                                   autocomplete="off"
                                                   value="{{ old('paternal_grandmother_last_name', $step2['paternal_grandmother_last_name'] ?? '') }}"required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="paternal_grandmother_ipgroup">{{ __('IP Group:') }}</label>
                                            <select name="paternal_grandmother_ipgroup" id="paternal_grandmother_ipgroup" class="form-control" required>
                                                <option value="">{{ __('Select IP Group') }}</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('paternal_grandmother_ipgroup', $step2['paternal_grandmother_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <x-origin-picker
                                        name="paternal_grandmother"
                                        :label="__('Place of Origin:')"
                                        :old-value="old('paternal_grandmother_origin', $step2['paternal_grandmother_origin'] ?? '')"
                                        :required="true" />
                                    </div>

                                    {{-- Maternal Grandmother --}}
                                    <div class="parent-section">
                                        <h5 class="parent-title">{{ __('Maternal Grandmother') }}</h5>
                                        
                                        <div class="form-group">
                                            <label class="form-label" for="maternal_grandmother_first_name">{{ __('First Name:') }}</label>
                                            <input type="text" 
                                                   name="maternal_grandmother_first_name" 
                                                   id="maternal_grandmother_first_name"
                                                   class="form-control"
                                                   placeholder="{{ __('Enter first name') }}"
                                                   autocomplete="off"
                                                   value="{{ old('maternal_grandmother_first_name', $step2['maternal_grandmother_first_name'] ?? '') }}"required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="maternal_grandmother_last_name">{{ __('Last Name:') }}</label>
                                            <input type="text" 
                                                   name="maternal_grandmother_last_name" 
                                                   id="maternal_grandmother_last_name"
                                                   class="form-control"
                                                   placeholder="{{ __('Enter last name') }}"
                                                   autocomplete="off"
                                                   value="{{ old('maternal_grandmother_last_name', $step2['maternal_grandmother_last_name'] ?? '') }}"required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="maternal_grandmother_ipgroup">{{ __('IP Group:') }}</label>
                                            <select name="maternal_grandmother_ipgroup" id="maternal_grandmother_ipgroup" class="form-control" required>
                                                <option value="">{{ __('Select IP Group') }}</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('maternal_grandmother_ipgroup', $step2['maternal_grandmother_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <x-origin-picker
                                        name="maternal_grandmother"
                                        :label="__('Place of Origin:')"
                                        :old-value="old('maternal_grandmother_origin', $step2['maternal_grandmother_origin'] ?? '')"
                                        :required="true" />
                                    </div>
                                </div>
                            </div>

                            {{-- Land Matter Certification --}}
                            <div class="form-section">
                                <div class="checkbox-option">
                                    <input type="checkbox" 
                                           name="land_matter" 
                                           value="1" 
                                           id="landMatterCheck"
                                           {{ old('land_matter', $step2['land_matter'] ?? '') ? 'checked' : '' }}>
                                    <label for="landMatterCheck" class="checkbox-option-label">
                                        {{ __('If purpose of certification is land matter, fill up the following:') }}
                                    </label>
                                </div>

                                <div id="landMatterFields" class="land-matter-fields" style="{{ old('land_matter', $step2['land_matter'] ?? '') ? '' : 'display: none;' }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="homestead_no">{{ __('Homestead/Free Patent No.:') }}</label>
                                                <input type="text" 
                                                       name="homestead_no" 
                                                       id="homestead_no"
                                                       class="form-control land-matter-input"
                                                       placeholder="{{ __('Enter Homestead or Free Patent No.') }}"
                                                       autocomplete="off"
                                                       value="{{ old('homestead_no', $step2['homestead_no'] ?? '') }}"
                                                       {{ old('land_matter', $step2['land_matter'] ?? '') ? '' : 'disabled' }}>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="lot_no">{{ __('Lot No.:') }}</label>
                                                <input type="text" 
                                                       name="lot_no" 
                                                       id="lot_no"
                                                       class="form-control land-matter-input"
                                                       placeholder="{{ __('Enter Lot No.') }}"
                                                       autocomplete="off"
                                                       value="{{ old('lot_no', $step2['lot_no'] ?? '') }}"
                                                       {{ old('land_matter', $step2['land_matter'] ?? '') ? '' : 'disabled' }}>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="issuance_date">{{ __('Date of Issuance:') }}</label>
                                                <input type="text" 
                                                       name="issuance_date" 
                                                       id="issuance_date"
                                                       class="form-control land-matter-input"
                                                       placeholder="{{ __('Enter date of issuance') }}"
                                                       autocomplete="off"
                                                       value="{{ old('issuance_date', $step2['issuance_date'] ?? '') }}"
                                                       {{ old('land_matter', $step2['land_matter'] ?? '') ? '' : 'disabled' }}>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="area">{{ __('Area:') }}</label>
                                                <input type="text" 
                                                       name="area" 
                                                       id="area"
                                                       class="form-control land-matter-input"
                                                       placeholder="{{ __('Enter land area') }}"
                                                       autocomplete="off"
                                                       value="{{ old('area', $step2['area'] ?? '') }}"
                                                       {{ old('land_matter', $step2['land_matter'] ?? '') ? '' : 'disabled' }}>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="location">{{ __('Location:') }}</label>
                                                <input type="text" 
                                                       name="location" 
                                                       id="location"
                                                       class="form-control land-matter-input"
                                                       placeholder="{{ __('Enter land location') }}"
                                                       autocomplete="off"
                                                       value="{{ old('location', $step2['location'] ?? '') }}"
                                                       {{ old('land_matter', $step2['land_matter'] ?? '') ? '' : 'disabled' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
{{-- Applicant Pledge --}}
<div class="form-section">
    <h4 class="section-title">{{ __('IV. Applicant Pledge') }}</h4>
    <p class="pledge-text">
        {{ __('I') }} 
        <input type="text" 
               name="applicant_name" 
               id="applicant_name"
               class="pledge-input"
               placeholder="{{ __('Enter your name') }}"
               autocomplete="name"
               value="{{ old('applicant_name', $applicantPledgeName) }}"
               required> 
        {{ __('do solemnly swear that all data given in the above information are true and correct to the best of my knowledge and based on authentic records.') }} 
        {{ __('I understand that any false information is enough to cause the denial of my application and could subject me to CRIMINAL and/or ADMINISTRATIVE prosecution.') }}
    </p>
    <div class="form-group">
        <label class="form-label" for="date_accomplishment">{{ __('Date of Accomplishment:') }}</label>
        <input type="date" 
               name="date_accomplishment" 
               id="date_accomplishment"
               class="form-control"
               value="{{ old('date_accomplishment', $step2['date_accomplishment'] ?? '') }}"
               required> {{-- ✅ ADD REQUIRED --}}
    </div>
</div>
                            {{-- Form Actions --}}
                            <div class="form-actions">
                                <a href="{{ route('applicant.coc.step1') }}" class="btn btn-back">← {{ __('Back') }}</a>
                                
                                @if(
                                    $application->status === 'Returned' && 
                                    $application->index_status === 'returned' &&
                                    empty($application->genealogy_status) &&
                                    empty($application->documents_status)
                                )
                                    <button type="submit" class="btn btn-next">
                                        <span class="btn-text"><i class="fas fa-paper-plane"></i> {{ __('Resubmit Application') }}</span>
                                        <div class="btn-loading d-none">
                                            <i class="fas fa-spinner fa-spin"></i> {{ __('Processing...') }}
                                        </div>
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-next">
                                        <span class="btn-text">{{ __('Next Step') }} →</span>
                                        <div class="btn-loading d-none">
                                            <i class="fas fa-spinner fa-spin"></i> {{ __('Processing...') }}
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
        margin: 0 0 0.75rem 0;
        font-size: clamp(1.1rem, 4vw, 1.4rem);
        font-weight: 600;
        color: #333;
    }

    .form-subtitle {
        margin: 0;
        font-size: clamp(0.8rem, 2.3vw, 0.9rem);
        color: #555;
        line-height: 1.5;
    }

    .form-subtitle strong {
        color: #333;
    }

    .form-content {
        padding: 1rem;
    }

    .form-section {
        margin-bottom: 2rem;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 1.5rem;
    }

    .form-section:last-of-type {
        border-bottom: none;
        margin-bottom: 1rem;
    }

    .section-title {
        font-size: clamp(0.95rem, 3vw, 1.1rem);
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .section-subtitle {
        font-size: clamp(0.9rem, 2.8vw, 1rem);
        font-weight: 600;
        color: #333;
        margin: 0;
        padding: 0.75rem;
        background: #f8f9fa;
        border-radius: 4px;
        text-align: center;
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
        border-color: #222;
    }

    .form-control:disabled {
        background-color: #f8f9fa;
        cursor: not-allowed;
        opacity: 0.7;
    }

    .form-control::placeholder {
        color: #999;
        font-size: clamp(0.8rem, 2.3vw, 0.85rem);
    }

    /* Parental Grid Layout */
    .parental-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .parent-section {
        background: #ffffff;
        padding: 1rem;
        border-radius: 6px;
        border: 1px solid #e5e5e5;
    }

    .parent-title {
        font-size: clamp(0.9rem, 2.8vw, 1rem);
        font-weight: 600;
        color: #495057;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #dee2e6;
    }

    .grandparent-header {
        grid-column: 1 / -1;
        margin-top: 1rem;
    }

    /* Checkbox Option */
    .checkbox-option {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #f9f9f9;
        padding: 0.75rem 1rem;
        border-radius: 6px;
        margin-bottom: 1rem;
        transition: background 0.2s ease;
    }

    .checkbox-option:hover {
        background: #f0f0f0;
    }

    .checkbox-option input[type="checkbox"] {
        accent-color:#3e7b27;
        transform: scale(1.3);
        cursor: pointer;
    }

    .checkbox-option-label {
        font-size: clamp(0.85rem, 2.5vw, 0.9rem);
        font-weight: 500;
        color: #333;
        cursor: pointer;
        margin: 0;
    }

    .land-matter-fields {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 6px;
        border: 1px solid #e9ecef;
    }

    /* Pledge Section */
    .pledge-text {
        font-size: clamp(0.85rem, 2.5vw, 0.95rem);
        line-height: 1.8;
        color: #333;
        margin-bottom: 1rem;
    }

    .pledge-input {
        display: inline-block;
        min-width: 200px;
        padding: 0.25rem 0.5rem;
        border: none;
        border-bottom: 2px solid #007bff;
        background: transparent;
        font-size: clamp(0.85rem, 2.5vw, 0.95rem);
        font-weight: 500;
        color: #333;
        transition: border-color 0.2s;
    }

    .pledge-input:focus {
        outline: none;
        border-bottom-color: #0056b3;
        background: rgba(0, 123, 255, 0.05);
    }

    /* Form Actions */
    .form-actions {
        padding-top: 1rem;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
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

        .parental-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .grandparent-header {
            grid-column: 1 / -1;
        }
    }

    @media (min-width: 768px) {
        .form-content {
            padding: 2rem;
        }

        .form-section {
            margin-bottom: 2.5rem;
        }

        .parent-section {
            padding: 1.25rem;
        }
    }

    @media (min-width: 992px) {
        .btn-back {
            min-width: 120px;
        }

        .btn-next {
            min-width: 150px;
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

        .parent-section {
            padding: 0.75rem;
        }
    }

    @media (max-width: 575px) {
        .form-actions {
            flex-direction: column;
        }

        .btn-back,
        .btn-next {
            width: 100%;
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

    /* Loading spinner animation */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .fa-spin {
        animation: spin 1s linear infinite;
    }
    </style>

    {{-- JavaScript --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('step2Form');
        const submitBtn = form.querySelector('.btn-next');
        const landMatterCheck = document.getElementById('landMatterCheck');
        const landMatterFields = document.getElementById('landMatterFields');
        const landMatterInputs = document.querySelectorAll('.land-matter-input');
        const nameInputs = form.querySelectorAll('input[name$="_first_name"], input[name$="_last_name"], input[name="applicant_name"]');
        const namePattern = /^[A-Za-z]+(?:[ .-][A-Za-z]+)*$/;

        function validateNameField(input) {
            const value = input.value.trim();
            const message = !value
                ? 'This field is required.'
                : !namePattern.test(value)
                    ? 'Use letters, spaces, periods, or hyphens only. Numbers and other special characters are not allowed.'
                    : '';

            input.setCustomValidity(message);
            input.classList.toggle('is-invalid', Boolean(message));
            return !message;
        }

        nameInputs.forEach(input => {
            input.required = true;
            input.pattern = '[A-Za-z]+(?:[ .-][A-Za-z]+)*';
            input.title = 'Use letters, spaces, periods, or hyphens only.';
            input.addEventListener('input', () => validateNameField(input));
            input.addEventListener('blur', () => validateNameField(input));
        });

        // Toggle land matter fields
        function toggleLandMatterFields() {
            if (landMatterCheck.checked) {
                landMatterFields.style.display = 'block';
                landMatterInputs.forEach(input => {
                    input.disabled = false;
                });
            } else {
                landMatterFields.style.display = 'none';
                landMatterInputs.forEach(input => {
                    input.disabled = true;
                    input.value = '';
                });
            }
        }

        // Initial state
        toggleLandMatterFields();

        // Add event listener
        landMatterCheck.addEventListener('change', toggleLandMatterFields);

        // Form submission handling
        let isSubmitting = false;
        form.addEventListener('submit', function(e) {
            if (isSubmitting) {
                e.preventDefault();
                return false;
            }

            const invalidNameInput = [...nameInputs].find(input => !validateNameField(input));
            if (invalidNameInput) {
                e.preventDefault();
                invalidNameInput.focus();
                invalidNameInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                invalidNameInput.reportValidity();
                return false;
            }

            // Basic validation
            const educationalAttainment = document.getElementById('educational_attainment');
            if (!educationalAttainment.value) {
                e.preventDefault();
                educationalAttainment.focus();
                educationalAttainment.scrollIntoView({ behavior: 'smooth', block: 'center' });
                alert('{{ __("Please select your highest educational attainment.") }}');
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

        // Auto-resize pledge input based on content
        const pledgeInput = document.getElementById('applicant_name');
        if (pledgeInput) {
            pledgeInput.addEventListener('input', function() {
                const minWidth = 200;
                const contentWidth = (this.value.length + 2) * 8;
                this.style.minWidth = Math.max(minWidth, contentWidth) + 'px';
            });
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
    const dateInput = document.getElementById("date_accomplishment");
    const today = new Date().toISOString().split("T")[0];
    dateInput.setAttribute("min", today);

    dateInput.addEventListener("change", function () {
        if (this.value < today) {
            alert("{{ __('You cannot select a past date.') }}");
            this.value = "";
        }
    });
});


    </script>
@endsection
