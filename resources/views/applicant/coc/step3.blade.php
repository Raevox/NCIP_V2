@extends('layouts.applicant')

@section('title', __('COC Form'))
@section('page-title', __('NCIP COC Form 3'))

@section('content')
    @include('applicant.coc.progress-circle', ['currentStep' => 3])
    <div class="container-fluid px-2 px-md-4 py-3 py-md-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-11">
                <div class="form-container">
                    <div class="form-header">
                        <h2 class="form-title">{{ __('NCIP COC FORM 3 (Genealogy)') }}</h2>
                        <p class="form-subtitle">
                            {{ __('Complete your family genealogy information') }}
                        </p>
                    </div>

                    <div class="form-content">
                        <form id="step3Form" action="{{ route('applicant.coc.step3.store', ['id' => $application->id]) }}" method="POST">
                            @csrf
                            @php
                                $ipGroups = \App\Models\Tribe::active()->orderBy('name')->pluck('name')->toArray();
                            @endphp

                            {{-- Applicant Information --}}
                            <div class="form-section">
                                <h4 class="section-title">{{ __('Full Name of Applicant') }}</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="applicant_first_name">{{ __('First Name') }}</label>
                                            <input type="text" 
                                                   name="applicant_first_name" 
                                                   id="applicant_first_name"
                                                   class="form-control" 
                                                   placeholder="{{ __('First name') }}"
                                                   autocomplete="given-name"
                                                   value="{{ old('applicant_first_name', $step3['applicant_first_name'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="applicant_last_name">{{ __('Last Name') }}</label>
                                            <input type="text" 
                                                   name="applicant_last_name" 
                                                   id="applicant_last_name"
                                                   class="form-control" 
                                                   placeholder="{{ __('Last name') }}"
                                                   autocomplete="family-name"
                                                   value="{{ old('applicant_last_name', $step3['applicant_last_name'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-origin-picker
                                        name="applicant"
                                        :label="__('Place of Origin:')"
                                        :old-value="old('applicant_origin', $step3['applicant_origin'] ?? '')"
                                        :required="false" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="applicant_ipgroup">{{ __('IP Group') }}</label>
                                            <select name="applicant_ipgroup" id="applicant_ipgroup" class="form-control">
                                                <option value="">{{ __('Select IP Group') }}</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('applicant_ipgroup', $step3['applicant_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Present Address --}}
                            <div class="form-section">
                                <h4 class="section-title">{{ __('Present Address') }}</h4>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label" for="province">{{ __('Province') }}</label>
                                            <select name="province"
                                                    id="province"
                                                    class="form-control"
                                                    data-selected="{{ old('province', $step3['province'] ?? '') }}"
                                                    autocomplete="address-level1"
                                                    required>
                                                <option value="" disabled selected>{{ __('Loading...') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label" for="municipality">{{ __('Municipality') }}</label>
                                            <select name="municipality"
                                                    id="municipality"
                                                    class="form-control"
                                                    data-selected="{{ old('municipality', $step3['municipality'] ?? '') }}"
                                                    autocomplete="address-level2"
                                                    required
                                                    disabled>
                                                <option value="" disabled selected>{{ __('Select Province first') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label" for="barangay">{{ __('Barangay') }}</label>
                                            <select name="barangay"
                                                    id="barangay"
                                                    class="form-control"
                                                    data-selected="{{ old('barangay', $step3['barangay'] ?? '') }}"
                                                    autocomplete="address-level3"
                                                    required
                                                    disabled>
                                                <option value="" disabled selected>{{ __('Select Municipality first') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Generation Marker - Parents --}}
                            <div class="generation-marker">
                                <span class="generation-label">{{ __('First Generation - Parents') }}</span>
                            </div>

                            {{-- Father --}}
                            <div class="form-section family-section">
                                <h4 class="family-title">{{ __('Father') }}</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="father_first_name">{{ __('First Name') }}</label>
                                            <input type="text" 
                                                   name="father_first_name" 
                                                   id="father_first_name"
                                                   class="form-control" 
                                                   placeholder="{{ __('Enter first name') }}"
                                                   autocomplete="off"
                                                   value="{{ old('father_first_name', $step3['father_first_name'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="father_last_name">{{ __('Last Name') }}</label>
                                            <input type="text" 
                                                   name="father_last_name" 
                                                   id="father_last_name"
                                                   class="form-control" 
                                                   placeholder="{{ __('Enter last name') }}"
                                                   autocomplete="off"
                                                   value="{{ old('father_last_name', $step3['father_last_name'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-origin-picker
                                        name="father"
                                        :label="__('Place of Origin:')"
                                        :old-value="old('father_origin', $step3['father_origin'] ?? '')"
                                        :required="false" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="father_ipgroup">{{ __('IP Group') }}</label>
                                            <select name="father_ipgroup" id="father_ipgroup" class="form-control">
                                                <option value="">{{ __('Select IP Group') }}</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('father_ipgroup', $step3['father_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Generation Marker - Grandparents --}}
                            <div class="generation-marker">
                                <span class="generation-label">{{ __('Second Generation - Grandparents (Father\'s Side)') }}</span>
                            </div>

                            {{-- Paternal Grandfather --}}
                            <div class="form-section family-section">
                                <h4 class="family-title">{{ __('Grandfather (Father\'s Side)') }}</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="paternal_grandfather_first_name">{{ __('First Name') }}</label>
                                            <input type="text" 
                                                   name="paternal_grandfather_first_name" 
                                                   id="paternal_grandfather_first_name"
                                                   class="form-control"
                                                   placeholder="Enter first name"
                                                   autocomplete="off"
                                                   value="{{ old('paternal_grandfather_first_name', $step3['paternal_grandfather_first_name'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="paternal_grandfather_last_name">{{ __('Last Name') }}</label>
                                            <input type="text" 
                                                   name="paternal_grandfather_last_name" 
                                                   id="paternal_grandfather_last_name"
                                                   class="form-control"
                                                   placeholder="Enter last name"
                                                   autocomplete="off"
                                                   value="{{ old('paternal_grandfather_last_name', $step3['paternal_grandfather_last_name'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-origin-picker
                                        name="paternal_grandfather"
                                        :label="__('Place of Origin:')"
                                        :old-value="old('paternal_grandfather_origin', $step3['paternal_grandfather_origin'] ?? '')"
                                        :required="false" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="paternal_grandfather_ipgroup">{{ __('IP Group') }}</label>
                                            <select name="paternal_grandfather_ipgroup" id="paternal_grandfather_ipgroup" class="form-control">
                                                <option value="">{{ __('Select IP Group') }}</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('paternal_grandfather_ipgroup', $step3['paternal_grandfather_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Paternal Grandmother --}}
                            <div class="form-section family-section">
                                <h4 class="family-title">{{ __('Grandmother (Father\'s Side)') }}</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="paternal_grandmother_first_name">{{ __('First Name') }}</label>
                                            <input type="text" 
                                                   name="paternal_grandmother_first_name" 
                                                   id="paternal_grandmother_first_name"
                                                   class="form-control"
                                                   placeholder="Enter first name"
                                                   autocomplete="off"
                                                   value="{{ old('paternal_grandmother_first_name', $step3['paternal_grandmother_first_name'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="paternal_grandmother_last_name">{{ __('Last Name') }}</label>
                                            <input type="text" 
                                                   name="paternal_grandmother_last_name" 
                                                   id="paternal_grandmother_last_name"
                                                   class="form-control"
                                                   placeholder="Enter last name"
                                                   autocomplete="off"
                                                   value="{{ old('paternal_grandmother_last_name', $step3['paternal_grandmother_last_name'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-origin-picker
                                        name="paternal_grandmother"
                                        :label="__('Place of Origin:')"
                                        :old-value="old('paternal_grandmother_origin', $step3['paternal_grandmother_origin'] ?? '')"
                                        :required="false" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="paternal_grandmother_ipgroup">{{ __('IP Group') }}</label>
                                            <select name="paternal_grandmother_ipgroup" id="paternal_grandmother_ipgroup" class="form-control">
                                                <option value="">{{ __('Select IP Group') }}</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('paternal_grandmother_ipgroup', $step3['paternal_grandmother_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Generation Marker - Great Grandparents --}}
                            <div class="generation-marker">
                                <span class="generation-label">{{ __('Third Generation - Great Grandparents (Grandfather\'s Side)') }}</span>
                            </div>

                            {{-- Great Grandfather (Grandfather's Father) --}}
                            <div class="form-section family-section">
                                <h4 class="family-title">{{ __('Great Grandfather (Grandfather\'s Father)') }}</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandfather_grandfather_first_name">{{ __('First Name') }}</label>
                                            <input type="text" 
                                                   name="great_grandfather_grandfather_first_name" 
                                                   id="great_grandfather_grandfather_first_name"
                                                   class="form-control" 
                                                   placeholder="Enter first name"
                                                   autocomplete="off"
                                                   value="{{ old('great_grandfather_grandfather_first_name', $step3['great_grandfather_grandfather_first_name'] ?? '') }}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandfather_grandfather_last_name">{{ __('Last Name') }}</label>
                                            <input type="text" 
                                                   name="great_grandfather_grandfather_last_name" 
                                                   id="great_grandfather_grandfather_last_name"
                                                   class="form-control" 
                                                   placeholder="Enter last name"
                                                   autocomplete="off"
                                                   value="{{ old('great_grandfather_grandfather_last_name', $step3['great_grandfather_grandfather_last_name'] ?? '') }}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-origin-picker
                                        name="great_grandfather_grandfather"
                                        :label="__('Place of Origin:')"
                                        :old-value="old('great_grandfather_grandfather_origin', $step3['great_grandfather_grandfather_origin'] ?? '')"
                                        :required="true" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandfather_grandfather_ipgroup">{{ __('IP Group') }}</label>
                                            <select name="great_grandfather_grandfather_ipgroup" id="great_grandfather_grandfather_ipgroup" class="form-control" required>
                                                <option value="">{{ __('Select IP Group') }}</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('great_grandfather_grandfather_ipgroup', $step3['great_grandfather_grandfather_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Great Grandmother (Grandfather's Mother) --}}
                            <div class="form-section family-section">
                                <h4 class="family-title">{{ __('Great Grandmother (Grandfather\'s Mother)') }}</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandmother_grandfather_first_name">{{ __('First Name') }}</label>
                                            <input type="text" 
                                                   name="great_grandmother_grandfather_first_name" 
                                                   id="great_grandmother_grandfather_first_name"
                                                   class="form-control" 
                                                   placeholder="Enter first name"
                                                   autocomplete="off"
                                                   value="{{ old('great_grandmother_grandfather_first_name', $step3['great_grandmother_grandfather_first_name'] ?? '') }}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandmother_grandfather_last_name">{{ __('Last Name') }}</label>
                                            <input type="text" 
                                                   name="great_grandmother_grandfather_last_name" 
                                                   id="great_grandmother_grandfather_last_name"
                                                   class="form-control" 
                                                   placeholder="Enter last name"
                                                   autocomplete="off"
                                                   value="{{ old('great_grandmother_grandfather_last_name', $step3['great_grandmother_grandfather_last_name'] ?? '') }}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-origin-picker
                                        name="great_grandmother_grandfather"
                                        :label="__('Place of Origin:')"
                                        :old-value="old('great_grandmother_grandfather_origin', $step3['great_grandmother_grandfather_origin'] ?? '')"
                                        :required="true" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandmother_grandfather_ipgroup">{{ __('IP Group') }}</label>
                                            <select name="great_grandmother_grandfather_ipgroup" id="great_grandmother_grandfather_ipgroup" class="form-control" required>
                                                <option value="">{{ __('Select IP Group') }}</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('great_grandmother_grandfather_ipgroup', $step3['great_grandmother_grandfather_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Generation Marker - Great Grandparents (Grandmother's Side) --}}
                            <div class="generation-marker">
                                <span class="generation-label">{{ __('Third Generation - Great Grandparents (Grandmother\'s Side)') }}</span>
                            </div>

                            {{-- Great Grandfather (Grandmother's Father) --}}
                            <div class="form-section family-section">
                                <h4 class="family-title">{{ __('Great Grandfather (Grandmother\'s Father)') }}</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandfather_grandmother_first_name">{{ __('First Name') }}</label>
                                            <input type="text" 
                                                   name="great_grandfather_grandmother_first_name" 
                                                   id="great_grandfather_grandmother_first_name"
                                                   class="form-control" 
                                                   placeholder="Enter first name"
                                                   autocomplete="off"
                                                   value="{{ old('great_grandfather_grandmother_first_name', $step3['great_grandfather_grandmother_first_name'] ?? '') }}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandfather_grandmother_last_name">{{ __('Last Name') }}</label>
                                            <input type="text" 
                                                   name="great_grandfather_grandmother_last_name" 
                                                   id="great_grandfather_grandmother_last_name"
                                                   class="form-control" 
                                                   placeholder="Enter last name"
                                                   autocomplete="off"
                                                   value="{{ old('great_grandfather_grandmother_last_name', $step3['great_grandfather_grandmother_last_name'] ?? '') }}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-origin-picker
                                        name="great_grandfather_grandmother"
                                        :label="__('Place of Origin:')"
                                        :old-value="old('great_grandfather_grandmother_origin', $step3['great_grandfather_grandmother_origin'] ?? '')"
                                        :required="true" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandfather_grandmother_ipgroup">{{ __('IP Group') }}</label>
                                            <select name="great_grandfather_grandmother_ipgroup" id="great_grandfather_grandmother_ipgroup" class="form-control" required>
                                                <option value="">{{ __('Select IP Group') }}</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('great_grandfather_grandmother_ipgroup', $step3['great_grandfather_grandmother_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Great Grandmother (Grandmother's Mother) --}}
                            <div class="form-section family-section">
                                <h4 class="family-title">{{ __('Great Grandmother (Grandmother\'s Mother)') }}</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandmother_grandmother_first_name">{{ __('First Name') }}</label>
                                            <input type="text" 
                                                   name="great_grandmother_grandmother_first_name" 
                                                   id="great_grandmother_grandmother_first_name"
                                                   class="form-control" 
                                                   placeholder="Enter first name"
                                                   autocomplete="off"
                                                   value="{{ old('great_grandmother_grandmother_first_name', $step3['great_grandmother_grandmother_first_name'] ?? '') }}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandmother_grandmother_last_name">{{ __('Last Name') }}</label>
                                            <input type="text" 
                                                   name="great_grandmother_grandmother_last_name" 
                                                   id="great_grandmother_grandmother_last_name"
                                                   class="form-control" 
                                                   placeholder="Enter last name"
                                                   autocomplete="off"
                                                   value="{{ old('great_grandmother_grandmother_last_name', $step3['great_grandmother_grandmother_last_name'] ?? '') }}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-origin-picker
                                        name="great_grandmother_grandmother"
                                        :label="__('Place of Origin:')"
                                        :old-value="old('great_grandmother_grandmother_origin', $step3['great_grandmother_grandmother_origin'] ?? '')"
                                        :required="true" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="great_grandmother_grandmother_ipgroup">{{ __('IP Group') }}</label>
                                            <select name="great_grandmother_grandmother_ipgroup" id="great_grandmother_grandmother_ipgroup" class="form-control" required>
                                                <option value="">{{ __('Select IP Group') }}</option>
                                                @foreach($ipGroups as $group)
                                                    <option value="{{ $group }}" {{ old('great_grandmother_grandmother_ipgroup', $step3['great_grandmother_grandmother_ipgroup'] ?? '') == $group ? 'selected' : '' }}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Form Actions --}}
                            <div class="form-actions">
                                <a href="{{ route('applicant.coc.step2') }}" class="btn btn-back">← {{ __('Back') }}</a>
                                <button type="submit" class="btn btn-next">
                                    <span class="btn-text">{{ __('Next Step') }} →</span>
                                    <div class="btn-loading d-none">
                                        <i class="fas fa-spinner fa-spin"></i> {{ __('Processing...') }}
                                    </div>
                                </button>
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

    .section-title {
        font-size: clamp(0.95rem, 3vw, 1.1rem);
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #3e7b27;
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
        background: #ffffff;
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
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .family-title {
        font-size: clamp(0.9rem, 2.8vw, 1rem);
        font-weight: 600;
        color: #495057;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #dee2e6;
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


    .form-control::placeholder {
        color: #999;
        font-size: clamp(0.8rem, 2.3vw, 0.85rem);
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

        .family-section {
            padding: 1.5rem;
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

        .family-section {
            padding: 0.75rem;
        }

        .generation-label {
            padding: 0.4rem 1rem;
            font-size: 0.75rem;
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

    .form-control:focus-visible,
    .btn:focus-visible {
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

    /* Scroll to top button (optional enhancement) */
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
        const form = document.getElementById('step3Form');
        const submitBtn = form.querySelector('.btn-next');
        const nameInputs = form.querySelectorAll('input[name$="_first_name"], input[name$="_last_name"]');
        const namePattern = /^[A-Za-z]+(?:[ .-][A-Za-z]+)*$/;

        const provinceSelect = document.getElementById('province');
        const municipalitySelect = document.getElementById('municipality');
        const barangaySelect = document.getElementById('barangay');

        function setAddressPlaceholder(select, message) {
            select.innerHTML = '';
            const option = document.createElement('option');
            option.value = '';
            option.textContent = message;
            option.disabled = true;
            option.selected = true;
            select.appendChild(option);
            select.disabled = true;
        }

        function populateAddressSelect(select, items, labelKey, codeKey, placeholder) {
            setAddressPlaceholder(select, placeholder);
            items.forEach(item => {
                const option = document.createElement('option');
                option.value = item[labelKey];
                option.textContent = item[labelKey];
                option.dataset.code = item[codeKey];
                select.appendChild(option);
            });
            select.disabled = false;
        }

        function selectAddressByName(select, name) {
            if (!name) return false;
            const normalized = name.trim().toLocaleLowerCase();
            const option = [...select.options].find(item =>
                item.value.trim().toLocaleLowerCase() === normalized
            );
            if (!option) return false;
            select.value = option.value;
            return true;
        }

        async function initializePresentAddress() {
            const savedProvince = provinceSelect.dataset.selected || '';
            const savedMunicipality = municipalitySelect.dataset.selected || '';
            const savedBarangay = barangaySelect.dataset.selected || '';

            try {
                const [provinceResponse, municipalityResponse, barangayResponse] = await Promise.all([
                    fetch('{{ asset("data/provinces.json") }}'),
                    fetch('{{ asset("data/mun.json") }}'),
                    fetch('{{ asset("data/brgy.json") }}'),
                ]);

                if (!provinceResponse.ok || !municipalityResponse.ok || !barangayResponse.ok) {
                    throw new Error('Failed to load address data.');
                }

                const provinces = (await provinceResponse.json()).RECORDS
                    .sort((a, b) => a.provDesc.localeCompare(b.provDesc));
                const municipalities = (await municipalityResponse.json()).RECORDS;
                const barangays = (await barangayResponse.json()).RECORDS;

                const loadMunicipalities = () => {
                    const provinceCode = provinceSelect.selectedOptions[0]?.dataset.code;
                    const matches = municipalities
                        .filter(item => item.provCode === provinceCode)
                        .sort((a, b) => a.citymunDesc.localeCompare(b.citymunDesc));
                    populateAddressSelect(municipalitySelect, matches, 'citymunDesc', 'citymunCode', '{{ __('Select Municipality') }}');
                    setAddressPlaceholder(barangaySelect, '{{ __('Select Municipality first') }}');
                };

                const loadBarangays = () => {
                    const municipalityCode = municipalitySelect.selectedOptions[0]?.dataset.code;
                    const matches = barangays
                        .filter(item => item.citymunCode === municipalityCode)
                        .sort((a, b) => a.brgyDesc.localeCompare(b.brgyDesc));
                    populateAddressSelect(barangaySelect, matches, 'brgyDesc', 'brgyCode', '{{ __('Select Barangay') }}');
                };

                populateAddressSelect(provinceSelect, provinces, 'provDesc', 'provCode', '{{ __('Select Province') }}');
                provinceSelect.addEventListener('change', loadMunicipalities);
                municipalitySelect.addEventListener('change', loadBarangays);

                if (selectAddressByName(provinceSelect, savedProvince)) {
                    loadMunicipalities();
                    if (selectAddressByName(municipalitySelect, savedMunicipality)) {
                        loadBarangays();
                        selectAddressByName(barangaySelect, savedBarangay);
                    }
                }
            } catch (error) {
                console.error('Present address dropdown error:', error);
                setAddressPlaceholder(provinceSelect, '{{ __('Unable to load addresses — please refresh') }}');
            }
        }

        initializePresentAddress();

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

        // Smooth scroll to generation markers when they come into view
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

        // Optional: Add scroll to top button for long form
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

        // Auto-save to sessionStorage (optional - helps prevent data loss)
        const autoSaveForm = () => {
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });
            sessionStorage.setItem('coc_step3_draft', JSON.stringify(data));
        };

        // Save form data every 30 seconds
        let autoSaveInterval = setInterval(autoSaveForm, 30000);

        // Clear interval on form submit
        form.addEventListener('submit', function() {
            clearInterval(autoSaveInterval);
            sessionStorage.removeItem('coc_step3_draft');
        });

        // Restore draft if available (only if form is empty)
        const restoreDraft = () => {
            const draft = sessionStorage.getItem('coc_step3_draft');
            if (draft) {
                try {
                    const data = JSON.parse(draft);
                    let hasData = false;
                    
                    // Check if form already has data
                    const inputs = form.querySelectorAll('input[type="text"]');
                    inputs.forEach(input => {
                        if (input.value.trim()) {
                            hasData = true;
                        }
                    });

                    // Only restore if form is empty
                    if (!hasData && confirm('A saved draft was found. Would you like to restore it?')) {
                        Object.keys(data).forEach(key => {
                            const input = form.querySelector(`[name="${key}"]`);
                            if (input) {
                                input.value = data[key];
                            }
                        });
                    }
                } catch (e) {
                    console.error('Error restoring draft:', e);
                }
            }
        };

        // Uncomment the line below if you want auto-restore functionality
        // restoreDraft();
    });
    </script>
@endsection
