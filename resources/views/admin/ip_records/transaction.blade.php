@if($record->coc_status == 'Approved')
<div class="alert alert-success mt-3">
    <div class="row">
        <div class="col-md-12">
            <h5><i class="fas fa-check-circle"></i> COC Successfully Issued!</h5>
            <p class="mb-3">The Certificate of Confirmation has been approved and is ready for printing.</p>

            <!-- PDF Preview -->
            <div class="pdf-preview-container">
                <iframe src="{{ route('ip_records.form_certificate', $record->id) }}" 
                        style="width:100%; height:700px; border: 1px solid #ddd; border-radius: 5px;" 
                        frameborder="0" 
                        id="cocFrame"></iframe>
            </div>

            <!-- Buttons -->
            <div class="mt-3 d-flex gap-2">
                <button class="btn btn-success" onclick="printCertificate()">
                    <i class="fas fa-print"></i> Print COC
                </button>
                <a href="{{ route('ip_records.form_certificate', $record->id) }}?download=1" 
                   class="btn btn-primary">
                    <i class="fas fa-download"></i> Download COC
                </a>
                <button class="btn btn-info" onclick="refreshPreview()">
                    <i class="fas fa-sync"></i> Refresh Preview
                </button>
            </div>

            <!-- COC Details -->
            <div class="mt-3">
                <small class="text-muted">
                    <strong>COC Number:</strong> COC-R03-NUE-{{ date('m-y', strtotime($record->created_at)) }}-{{ str_pad($record->id, 4, '0', STR_PAD_LEFT) }}<br>
                    <strong>Issued Date:</strong> {{ date('F j, Y', strtotime($record->created_at)) }}<br>
                    <strong>IP Group:</strong> {{ strtoupper($record->ip_group) }}<br>
                    <strong>Applicant:</strong> {{ strtoupper($record->first_name . ' ' . $record->last_name) }}
                </small>
            </div>
        </div>
    </div>
</div>

<script>
function printCertificate() {
    const iframe = document.getElementById('cocFrame');
    iframe.contentWindow.focus();
    iframe.contentWindow.print();
}

function refreshPreview() {
    const iframe = document.getElementById('cocFrame');
    iframe.src = iframe.src;
}

// Auto-refresh preview when page loads
document.addEventListener('DOMContentLoaded', function() {
    const iframe = document.getElementById('cocFrame');
    iframe.onload = function() {
        console.log('COC Preview loaded successfully');
    };
});
</script>

<style>
.pdf-preview-container {
    background: #f8f9fa;
    padding: 10px;
    border-radius: 5px;
    margin: 10px 0;
}

.gap-2 > * {
    margin-right: 10px;
}
</style>
@endif