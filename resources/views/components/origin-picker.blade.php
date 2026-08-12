@props([
    'name',              // field prefix, e.g. 'father', 'maternal_grandfather'
    'label' => __('Place of Origin'),
    'oldValue' => '',
    'required' => false,
])

<div class="form-group origin-picker" data-required="{{ $required ? 'true' : 'false' }}">
    <label class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    <div class="row g-2">
        <div class="col-md-4">
            <div class="searchable-select">
                <input type="text" class="form-control search-input origin-province-search" placeholder="{{ __('Search province') }}" autocomplete="off">
                <i class="fas fa-chevron-down dropdown-icon"></i>
                <input type="hidden" class="origin-province-code">
                <input type="hidden" class="origin-province-name">
                <ul class="dropdown-list origin-province-list" role="listbox"></ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="searchable-select">
                <input type="text" class="form-control search-input origin-municipality-search" placeholder="{{ __('Search municipality') }}" autocomplete="off">
                <i class="fas fa-chevron-down dropdown-icon"></i>
                <input type="hidden" class="origin-municipality-code">
                <input type="hidden" class="origin-municipality-name">
                <ul class="dropdown-list origin-municipality-list" role="listbox"></ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="searchable-select">
                <input type="text" class="form-control search-input origin-barangay-search" placeholder="{{ __('Search barangay') }}" autocomplete="off">
                <i class="fas fa-chevron-down dropdown-icon"></i>
                <input type="hidden" class="origin-barangay-code">
                <input type="hidden" class="origin-barangay-name">
                <ul class="dropdown-list origin-barangay-list" role="listbox"></ul>
            </div>
        </div>
    </div>
    <input type="hidden" name="{{ $name }}_origin" class="origin-combined-value" value="{{ $oldValue }}">
</div>