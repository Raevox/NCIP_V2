@props([
    'name',              // field prefix, e.g. 'father', 'maternal_grandfather'
    'label' => __('Place of Origin'),
    'oldValue' => '',
    'required' => false,
])

<div class="form-group origin-picker" data-required="{{ $required ? 'true' : 'false' }}" data-name="{{ $name }}">
    <label class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    <div class="row g-2">
        <div class="col-md-4">
            <select class="form-control origin-province-select">
                <option value="" disabled selected>{{ __('Loading...') }}</option>
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-control origin-municipality-select" disabled>
                <option value="" disabled selected>{{ __('Select Province first') }}</option>
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-control origin-barangay-select" disabled>
                <option value="" disabled selected>{{ __('Select Municipality first') }}</option>
            </select>
        </div>
    </div>
    <input type="hidden" name="{{ $name }}_origin" class="origin-combined-value" value="{{ $oldValue }}">
</div>

@once
<script>
document.addEventListener('DOMContentLoaded', async () => {
    let provinces = [], municipalities = [], barangays = [];

    try {
        const [pRes, mRes, bRes] = await Promise.all([
            fetch('{{ asset("data/provinces.json") }}'),
            fetch('{{ asset("data/mun.json") }}'),
            fetch('{{ asset("data/brgy.json") }}'),
        ]);

        if (!pRes.ok || !mRes.ok || !bRes.ok) {
            throw new Error('Failed to fetch location data');
        }

        provinces = (await pRes.json()).RECORDS.sort((a, b) => a.provDesc.localeCompare(b.provDesc));
        municipalities = (await mRes.json()).RECORDS;
        barangays = (await bRes.json()).RECORDS;
    } catch (err) {
        console.error('Error loading location data for origin pickers:', err);
        document.querySelectorAll('.origin-province-select').forEach(sel => {
            sel.innerHTML = '<option value="" disabled selected>{{ __("Error loading — please refresh") }}</option>';
        });
        return;
    }

    function populate(sel, items, valueKey, labelKey, placeholder) {
        sel.innerHTML = `<option value="" disabled selected>${placeholder}</option>`;
        items.forEach(item => {
            const o = document.createElement('option');
            o.value = item[valueKey];
            o.textContent = item[labelKey];
            sel.appendChild(o);
        });
        sel.disabled = false;
    }

    function setLoading(sel, msg) {
        sel.innerHTML = `<option value="" disabled selected>${msg}</option>`;
        sel.disabled = true;
    }

    function findByLabel(items, labelKey, label) {
        const normalizedLabel = label.trim().toLocaleLowerCase();

        return items.find(item => item[labelKey].trim().toLocaleLowerCase() === normalizedLabel);
    }

    document.querySelectorAll('.origin-picker').forEach(picker => {
        const provSel = picker.querySelector('.origin-province-select');
        const munSel  = picker.querySelector('.origin-municipality-select');
        const brgySel = picker.querySelector('.origin-barangay-select');
        const combined = picker.querySelector('.origin-combined-value');

        populate(provSel, provinces, 'provCode', 'provDesc', '{{ __("Select Province") }}');

        function updateCombined() {
            const brgyText = brgySel.value ? brgySel.options[brgySel.selectedIndex].text : '';
            const munText  = munSel.value  ? munSel.options[munSel.selectedIndex].text   : '';
            const provText = provSel.value ? provSel.options[provSel.selectedIndex].text : '';
            const parts = [brgyText, munText, provText].filter(p => p && p.trim().length > 0);
            combined.value = parts.join(', ');
        }

        function populateMunicipalities(provinceCode) {
            const list = municipalities
                .filter(m => m.provCode === provinceCode)
                .sort((a, b) => a.citymunDesc.localeCompare(b.citymunDesc));
            populate(munSel, list, 'citymunCode', 'citymunDesc', '{{ __("Select Municipality") }}');

            return list;
        }

        function populateBarangays(municipalityCode) {
            const list = barangays
                .filter(b => b.citymunCode === municipalityCode)
                .sort((a, b) => a.brgyDesc.localeCompare(b.brgyDesc));
            populate(brgySel, list, 'brgyCode', 'brgyDesc', '{{ __("Select Barangay") }}');

            return list;
        }

        provSel.addEventListener('change', function () {
            setLoading(munSel, '{{ __("Loading...") }}');
            setLoading(brgySel, '{{ __("Select Municipality first") }}');

            populateMunicipalities(this.value);

            updateCombined();
        });

        munSel.addEventListener('change', function () {
            setLoading(brgySel, '{{ __("Loading...") }}');

            populateBarangays(this.value);

            updateCombined();
        });

        brgySel.addEventListener('change', updateCombined);

        // Existing values are stored as "Barangay, Municipality, Province".
        // Rebuild the dependent selections after the location data is available.
        const savedParts = combined.value.split(',').map(part => part.trim()).filter(Boolean);
        if (savedParts.length >= 3) {
            const [barangayName, municipalityName, provinceName] = savedParts.slice(-3);
            const province = findByLabel(provinces, 'provDesc', provinceName);

            if (province) {
                provSel.value = province.provCode;
                const municipalityList = populateMunicipalities(province.provCode);
                const municipality = findByLabel(municipalityList, 'citymunDesc', municipalityName);

                if (municipality) {
                    munSel.value = municipality.citymunCode;
                    const barangayList = populateBarangays(municipality.citymunCode);
                    const barangay = findByLabel(barangayList, 'brgyDesc', barangayName);

                    if (barangay) {
                        brgySel.value = barangay.brgyCode;
                    }
                }
            }
        }
    });
});
</script>
@endonce
