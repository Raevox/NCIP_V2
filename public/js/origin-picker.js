document.addEventListener('DOMContentLoaded', async () => {
    const pickers = document.querySelectorAll('.origin-picker');
    if (pickers.length === 0) return;

    let provinces, municipalities, barangays;

    try {
        const [pRes, mRes, bRes] = await Promise.all([
            fetch('/data/provinces.json'),
            fetch('/data/mun.json'),
            fetch('/data/brgy.json')
        ]);
        provinces = (await pRes.json()).RECORDS;
        municipalities = (await mRes.json()).RECORDS;
        barangays = (await bRes.json()).RECORDS;
    } catch (error) {
        console.error('Error loading location data for origin pickers:', error);
        return;
    }

    pickers.forEach(picker => initOriginPicker(picker));

    function initOriginPicker(picker) {
        const provinceSearch = picker.querySelector('.origin-province-search');
        const provinceCode = picker.querySelector('.origin-province-code');
        const provinceName = picker.querySelector('.origin-province-name');
        const provinceList = picker.querySelector('.origin-province-list');

        const municipalitySearch = picker.querySelector('.origin-municipality-search');
        const municipalityCode = picker.querySelector('.origin-municipality-code');
        const municipalityName = picker.querySelector('.origin-municipality-name');
        const municipalityList = picker.querySelector('.origin-municipality-list');

        const barangaySearch = picker.querySelector('.origin-barangay-search');
        const barangayCode = picker.querySelector('.origin-barangay-code');
        const barangayName = picker.querySelector('.origin-barangay-name');
        const barangayList = picker.querySelector('.origin-barangay-list');

        const combinedInput = picker.querySelector('.origin-combined-value');

        // Pre-fill display fields if there's an existing combined value (editing/returning)
        const existing = combinedInput.value;
        if (existing) {
            const parts = existing.split(',').map(p => p.trim());
            if (parts[0]) { barangaySearch.value = parts[0]; barangayName.value = parts[0]; }
            if (parts[1]) { municipalitySearch.value = parts[1]; municipalityName.value = parts[1]; }
            if (parts[2]) { provinceSearch.value = parts[2]; provinceName.value = parts[2]; }
        }

        function updateCombined() {
            const parts = [barangayName.value, municipalityName.value, provinceName.value]
                .filter(p => p && p.trim().length > 0);
            combinedInput.value = parts.join(', ');
        }

        function setupSearch(input, list, codeInput, nameInput, dataset, filterKey, labelKey, parentCodeInput, parentDatasetKey) {
            let debounceTimer;

            input.addEventListener('input', () => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    const query = input.value.toLowerCase().trim();
                    let filtered = dataset;

                    if (parentCodeInput && parentDatasetKey) {
                        const parentVal = parentCodeInput.value;
                        filtered = parentVal
                            ? filtered.filter(item => item[parentDatasetKey] === parentVal)
                            : [];
                    }

                    filtered = query
                        ? filtered.filter(item => item[labelKey].toLowerCase().includes(query)).slice(0, 50)
                        : filtered.slice(0, 50);

                    if (input.value !== nameInput.value) {
                        codeInput.value = '';
                        nameInput.value = '';
                        updateCombined();
                    }

                    render(filtered);
                }, 300);
            });

            input.addEventListener('focus', () => {
                if (input.value && !codeInput.value) input.dispatchEvent(new Event('input'));
            });

            input.addEventListener('blur', () => {
                setTimeout(() => { list.style.display = 'none'; }, 200);
            });

            function render(items) {
                list.innerHTML = '';
                if (items.length === 0) {
                    const li = document.createElement('li');
                    li.textContent = 'No results found';
                    li.style.color = '#6c757d';
                    li.style.fontStyle = 'italic';
                    list.appendChild(li);
                } else {
                    items.forEach(item => {
                        const li = document.createElement('li');
                        li.textContent = item[labelKey];
                        li.addEventListener('click', () => {
                            input.value = item[labelKey];
                            codeInput.value = item[filterKey];
                            nameInput.value = item[labelKey];
                            list.style.display = 'none';
                            updateCombined();
                            clearDependents(input);
                        });
                        list.appendChild(li);
                    });
                }
                list.style.display = items.length ? 'block' : 'none';
            }
        }

        function clearDependents(changedInput) {
            if (changedInput === provinceSearch) {
                municipalitySearch.value = ''; municipalityCode.value = ''; municipalityName.value = '';
                barangaySearch.value = ''; barangayCode.value = ''; barangayName.value = '';
            } else if (changedInput === municipalitySearch) {
                barangaySearch.value = ''; barangayCode.value = ''; barangayName.value = '';
            }
            updateCombined();
        }

        setupSearch(provinceSearch, provinceList, provinceCode, provinceName, provinces, 'provCode', 'provDesc');
        setupSearch(municipalitySearch, municipalityList, municipalityCode, municipalityName, municipalities, 'citymunCode', 'citymunDesc', provinceCode, 'provCode');
        setupSearch(barangaySearch, barangayList, barangayCode, barangayName, barangays, 'brgyCode', 'brgyDesc', municipalityCode, 'citymunCode');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.searchable-select')) {
            document.querySelectorAll('.dropdown-list').forEach(list => list.style.display = 'none');
        }
    });

    // Validate required origin pickers before form submit
    document.querySelectorAll('form').forEach(form => {
        const requiredPickers = form.querySelectorAll('.origin-picker[data-required="true"]');
        if (requiredPickers.length === 0) return;

        form.addEventListener('submit', function(e) {
            for (const picker of requiredPickers) {
                const combined = picker.querySelector('.origin-combined-value');
                if (!combined.value.trim()) {
                    e.preventDefault();
                    const label = picker.querySelector('.form-label').textContent.trim();
                    alert(`Please complete the "${label}" field by selecting Province, Municipality, and Barangay.`);
                    picker.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return false;
                }
            }
        });
    });
});