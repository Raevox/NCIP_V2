@if($application && $application->status === 'Returned')
@php
    // Open the first step that staff actually returned for correction.
    $step = $application->getNextReturnedStep();
@endphp

<style>
.returned-notice-wrapper {
    margin-top: 24px;
}

.status-card {
    background-color: #fff3f3;
    border-left: 4px solid #dc3545;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.notice-header {
    font-weight: 700;
    color: #dc3545;
    font-size: 18px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.remarks-section {
    margin-bottom: 16px;
}

.remarks-section strong {
    color: #333;
    font-size: 14px;
    display: block;
    margin-bottom: 8px;
}

.remarks-section p {
    margin: 0;
    margin-left: 16px;
    color: #555;
    font-size: 14px;
    line-height: 1.6;
}

.notice-body {
    color: #6c757d;
    font-size: 13px;
    margin-bottom: 20px;
    line-height: 1.5;
}

.btn-resubmit {
    background: #dc3545;
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.2s ease;
    display: inline-block;
    text-decoration: none;
    text-align: center;
}

.btn-resubmit:hover {
    background: #bb2d3b;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    text-decoration: none;
}

@media (max-width: 768px) {
    .status-card {
        padding: 20px;
    }
    
    .notice-header {
        font-size: 16px;
    }
}
</style>

<div class="returned-notice-wrapper">
    <div class="status-card">
        <div class="notice-header">
            <span>⚠️</span>
            <span>Document / Form Resubmission Required</span>
        </div>
        
        @if($application->index_status === 'returned' && $application->index_remarks)
            <div class="remarks-section">
                <strong>Index Form Remarks:</strong>
                <p>{{ $application->index_remarks }}</p>
            </div>
        @endif
        
        @if($application->genealogy_status === 'returned' && $application->genealogy_remarks)
            <div class="remarks-section">
                <strong>Genealogy Form Remarks:</strong>
                <p>{{ $application->genealogy_remarks }}</p>
            </div>
        @endif
        
        @if($application->documents_status === 'returned' && $application->documents_remarks)
            <div class="remarks-section">
                <strong>Documents Remarks:</strong>
                <p>{{ $application->documents_remarks }}</p>
            </div>
        @endif
        
        <div class="notice-body">
            Please review the remarks above, update the necessary information or documents, and resubmit your application.
        </div>
        
        @if($step)
        <div class="resubmit-container">
            <a href="{{ route('applicant.coc.resubmit.step', ['step' => $step, 'application' => $application->id]) }}" 
               class="btn-resubmit">
                Resubmit
            </a>
        </div>
        @endif
    </div>
</div>
@endif
