<div class="card shadow-sm p-3" style="width: 100%; max-width: 350px;">
    <h5 class="fw-bold mb-3">Review Decision</h5>

    <form id="reviewForm" action="{{ route('staff.review.decision', $application->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Index Form --}}
        <div class="mb-3 text-start">
            <label class="form-label fw-bold d-block">Index Form</label>
            <div class="form-check text-success">
                <input class="form-check-input" type="radio" name="index_status" value="approved"
                    id="index_approved"
                    {{ $application->index_status === 'approved' ? 'checked' : '' }}
                    onchange="toggleRemarks('index', false)">
                <label class="form-check-label fw-bold" for="index_approved">Approved</label>
            </div>
            <div class="form-check text-danger">
                <input class="form-check-input" type="radio" name="index_status" value="returned"
                    id="index_returned"
                    {{ $application->index_status === 'returned' ? 'checked' : '' }}
                    onchange="toggleRemarks('index', true)">
                <label class="form-check-label fw-bold" for="index_returned">Return for Correction</label>
            </div>
            <textarea name="index_remarks" id="index_remarks" rows="2" class="form-control mt-2"
                placeholder="Remarks if returned..."
                style="{{ $application->index_status === 'returned' ? '' : 'display:none;' }}">{{ $application->index_remarks }}</textarea>
        </div>

        {{-- Genealogy Form --}}
        <div class="mb-3 text-start">
            <label class="form-label fw-bold d-block">Genealogy Form</label>
            <div class="form-check text-success">
                <input class="form-check-input" type="radio" name="genealogy_status" value="approved"
                    id="genealogy_approved"
                    {{ $application->genealogy_status === 'approved' ? 'checked' : '' }}
                    onchange="toggleRemarks('genealogy', false)">
                <label class="form-check-label fw-bold" for="genealogy_approved">Approved</label>
            </div>
            <div class="form-check text-danger">
                <input class="form-check-input" type="radio" name="genealogy_status" value="returned"
                    id="genealogy_returned"
                    {{ $application->genealogy_status === 'returned' ? 'checked' : '' }}
                    onchange="toggleRemarks('genealogy', true)">
                <label class="form-check-label fw-bold" for="genealogy_returned">Return for Correction</label>
            </div>
            <textarea name="genealogy_remarks" id="genealogy_remarks" rows="2" class="form-control mt-2"
                placeholder="Remarks if returned..."
                style="{{ $application->genealogy_status === 'returned' ? '' : 'display:none;' }}">{{ $application->genealogy_remarks }}</textarea>
        </div>

        {{-- Individual uploaded documents --}}
        @php
            $reviewDocuments = [
                'applicant_picture' => 'Applicant Photo',
                'birth_certificate' => 'Birth Certificate',
                'tribal_certificate' => 'Tribal Certificate',
                'genealogy_form' => 'Genealogy Form Upload',
            ];
        @endphp
        @foreach($reviewDocuments as $documentKey => $documentLabel)
            @php
                $statusField = $documentKey . '_status';
                $remarksField = $documentKey . '_remarks';
            @endphp
            <div class="mb-3 text-start">
                <label class="form-label fw-bold d-block">{{ $documentLabel }}</label>
                <div class="form-check text-success">
                    <input class="form-check-input document-status" type="radio" required
                        name="{{ $statusField }}" value="approved" id="{{ $documentKey }}_approved"
                        {{ $application->{$statusField} === 'approved' ? 'checked' : '' }}
                        onchange="toggleRemarks('{{ $documentKey }}', false)">
                    <label class="form-check-label fw-bold" for="{{ $documentKey }}_approved">Approved</label>
                </div>
                <div class="form-check text-danger">
                    <input class="form-check-input document-status" type="radio" required
                        name="{{ $statusField }}" value="returned" id="{{ $documentKey }}_returned"
                        {{ $application->{$statusField} === 'returned' ? 'checked' : '' }}
                        onchange="toggleRemarks('{{ $documentKey }}', true)">
                    <label class="form-check-label fw-bold" for="{{ $documentKey }}_returned">Return for Correction</label>
                </div>
                <textarea name="{{ $remarksField }}" id="{{ $documentKey }}_remarks" rows="2"
                    class="form-control mt-2" placeholder="Remarks if returned..."
                    style="{{ $application->{$statusField} === 'returned' ? '' : 'display:none;' }}">{{ $application->{$remarksField} }}</textarea>
            </div>
        @endforeach

        {{-- Classification --}}
        <div class="p-2 border rounded bg-light text-start mb-3">
            <label class="form-label fw-bold">Application Classification</label>
            <small class="d-block text-muted mb-2">
                All sections must be Approved to forward this application
            </small>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="classification[]" value="national"
                    id="class_national"
                    {{ is_array($application->classification) && in_array('national', $application->classification) ? 'checked' : '' }}>
                <label class="form-check-label" for="class_national">
                    National Purpose (Forward to Regional Admin)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="classification[]" value="local"
                    id="class_local"
                    {{ is_array($application->classification) && in_array('local', $application->classification) ? 'checked' : '' }}>
                <label class="form-check-label" for="class_local">
                    Local Purpose (Forward to Provincial Admin)
                </label>
            </div>
        </div>

        {{-- Dynamic Submit Button --}}
        <button type="button" id="decisionBtn" class="btn w-100 mb-2" onclick="submitForm()"></button>
        <a href="{{ route('staff.review.show', $application->id) }}" class="btn btn-secondary w-100">Cancel</a>
    </form>
</div>

{{-- Success/Return Modal --}}
<div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" id="modalHeader">
                <h5 class="modal-title" id="resultModalLabel"></h5>
                <button type="button" class="btn-close" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div id="modalIcon" class="mb-3"></div>
                <p id="modalMessage" class="mb-0"></p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn" id="modalOkBtn">OK</button>
            </div>
        </div>
    </div>
</div>

{{-- Loading Modal --}}
<div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mb-0">Processing your decision...</p>
            </div>
        </div>
    </div>
</div>

{{-- JS to toggle remarks & dynamic button --}}
<script>
    const decisionBtn = document.getElementById('decisionBtn');
    const classificationCheckboxes = document.querySelectorAll('input[name="classification[]"]');
    const reviewForm = document.getElementById('reviewForm');

    function updateButton() {
        const indexStatus = document.querySelector('input[name="index_status"]:checked')?.value;
        const genealogyStatus = document.querySelector('input[name="genealogy_status"]:checked')?.value;
        const documentStatuses = Array.from(document.querySelectorAll('.document-status:checked')).map(input => input.value);
        const allDocumentsApproved = documentStatuses.length === 4 && documentStatuses.every(status => status === 'approved');
        const allApproved = indexStatus === 'approved' && genealogyStatus === 'approved' && allDocumentsApproved;

        // Update submit button
        if (allApproved) {
            decisionBtn.textContent = 'Forward Application';
            decisionBtn.className = 'btn btn-success w-100 mb-2';
        } else {
            decisionBtn.textContent = 'Return to Applicant';
            decisionBtn.className = 'btn btn-danger w-100 mb-2';
        }

        // Enable/disable classification checkboxes
        classificationCheckboxes.forEach(cb => {
            cb.disabled = !allApproved;
        });
    }

    function toggleRemarks(section, show) {
        const textarea = document.getElementById(section + '_remarks');
        if (textarea) textarea.style.display = show ? 'block' : 'none';
        updateButton(); // update button and classification every toggle
    }
function submitForm() {
    // Check if all sections are approved
    const indexStatus = document.querySelector('input[name="index_status"]:checked')?.value;
    const genealogyStatus = document.querySelector('input[name="genealogy_status"]:checked')?.value;
    const documentStatuses = Array.from(document.querySelectorAll('.document-status:checked')).map(input => input.value);
    const allDocumentsApproved = documentStatuses.length === 4 && documentStatuses.every(status => status === 'approved');
    const allApproved = indexStatus === 'approved' && genealogyStatus === 'approved' && allDocumentsApproved;

    if (!reviewForm.reportValidity()) {
        return;
    }

    // Validate classification if all approved
    if (allApproved) {
        const classificationCheckboxes = document.querySelectorAll('input[name="classification[]"]');
        const checkedClassifications = Array.from(classificationCheckboxes).filter(cb => cb.checked);
        if (checkedClassifications.length === 0) {
            alert('Please select at least one Application Classification (National or Local Purpose).');
            return; // Stop submission
        }
    }

    // Get the CSRF token
    const token = document.querySelector('input[name="_token"]').value;
    
    // Show loading modal
    const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
    loadingModal.show();

    // Create URL with parameters to force JSON response
    const url = reviewForm.action + '?ajax=1&json=1';

    // Get form data
    const formData = new FormData(reviewForm);

    console.log('Submitting to:', url);
    console.log('CSRF Token:', token);

    // Submit form via AJAX with timeout
    const timeoutId = setTimeout(() => {
        console.error('Request timed out after 10 seconds');
        loadingModal.hide();
        showResultModal(false, 'Request timed out. Please try again.', 'error');
    }, 10000);

    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        clearTimeout(timeoutId);
        console.log('Response received:', response.status, response.statusText);

        return response.text(); // Get as text first
    })
    .then(text => {
        console.log('Raw response:', text);
        loadingModal.hide();
        
        try {
            const data = JSON.parse(text);
            console.log('Parsed JSON:', data);
            showResultModal(data.success, data.message, data.type);
        } catch (e) {
            console.error('JSON parse failed:', e);
            // If it's HTML (redirect), it means the operation succeeded but returned a redirect
            if (text.includes('<html') || text.includes('<!DOCTYPE')) {
                showResultModal(true, 'Operation completed successfully!', 'approved');
            } else {
                showResultModal(false, 'Unexpected response format', 'error');
            }
        }
    })
    .catch(error => {
        clearTimeout(timeoutId);
        console.error('Fetch error:', error);
        loadingModal.hide();
        showResultModal(false, 'Network error: ' + error.message, 'error');
    });
}


    function showResultModal(success, message, type) {
        console.log('showResultModal called:', { success, message, type });
        
        // Hide loading modal first
        const loadingModalEl = document.getElementById('loadingModal');
        const loadingModal = bootstrap.Modal.getInstance(loadingModalEl);
        if (loadingModal) {
            loadingModal.dispose();
        }
        loadingModalEl.style.display = 'none';
        unlockPageScrolling();

        const modal = document.getElementById('resultModal');
        const modalHeader = document.getElementById('modalHeader');
        const modalTitle = document.getElementById('resultModalLabel');
        const modalIcon = document.getElementById('modalIcon');
        const modalMessage = document.getElementById('modalMessage');
        const modalOkBtn = document.getElementById('modalOkBtn');

        if (success) {
            if (type === 'approved' || type === 'forwarded') {
                // Success - Application Approved/Forwarded
                modalHeader.className = 'modal-header bg-success text-white';
                modalTitle.textContent = 'Application Forwarded';
                modalIcon.innerHTML = '<i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>';
                modalOkBtn.className = 'btn btn-success';
            } else {
                // Success - Application Returned
                modalHeader.className = 'modal-header bg-warning text-white';
                modalTitle.textContent = 'Application Returned';
                modalIcon.innerHTML = '<i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>';
                modalOkBtn.className = 'btn btn-warning';
            }
        } else {
            // Error
            modalHeader.className = 'modal-header bg-danger text-white';
            modalTitle.textContent = 'Error';
            modalIcon.innerHTML = '<i class="fas fa-times-circle text-danger" style="font-size: 3rem;"></i>';
            modalOkBtn.className = 'btn btn-danger';
        }

        modalMessage.textContent = message;

        // Add click event listener to OK button and close button
        modalOkBtn.onclick = function() {
            closeResultModal(success);
        };

        // Add click event to close button (X)
        const closeBtn = modal.querySelector('.btn-close');
        if (closeBtn) {
            closeBtn.onclick = function() {
                closeResultModal(success);
            };
        }

        // Add click event to backdrop with lighter opacity
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        backdrop.setAttribute('id', 'resultModalBackdrop');
        backdrop.style.opacity = '0.3'; // Lighter backdrop
        backdrop.onclick = function() {
            closeResultModal(success);
        };

        // Force show the modal
        setTimeout(() => {
            try {
                modal.classList.add('show');
                modal.style.display = 'block';
                modal.style.zIndex = '9999'; // Make sure it's on top
                document.body.classList.add('modal-open');
                
                // Add backdrop manually with lighter opacity
                document.body.appendChild(backdrop);
                
                console.log('Modal forced to show with click handlers');
            } catch (error) {
                console.error('Error showing modal:', error);
                // Fallback: simple alert
                alert(message + '\n\nClick OK to continue.');
                closeResultModal(success);
            }
        }, 100);
    }

    function closeResultModal(success) {
        // Clean up modal manually
        const modal = document.getElementById('resultModal');

        if (modal) {
            modal.classList.remove('show');
            modal.style.display = 'none';
        }
        unlockPageScrolling();

        // Keep the current form and entered values available when a decision fails.
        if (success) {
            window.location.href = "{{ route('staff.review') }}";
        }
    }

    function unlockPageScrolling() {
        // Bootstrap adds these while a modal is open. Clear all of them because
        // the loading and result modals are closed manually in this view.
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');
    }

    // Initial load
    updateButton();

    // Attach change event to all radios
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', updateButton);
    });

    // Handle browser back button and prevent form resubmission
    if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
        window.location.reload();
    }
</script>

{{-- Add Font Awesome for icons if not already included --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
