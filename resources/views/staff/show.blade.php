@extends('layouts.staff')

@section('title', 'Application Details')

@section('content')
<div class="container-fluid py-4" style="background-color: #fff; min-height: 100vh;">
    <div class="container bg-white shadow rounded p-4">
        <!-- ✅ Ginawang d-flex para kontrolado alignment -->
        <div class="row d-flex">
            
            <!-- Left Column: Tabs for application details -->
            <div class="col-md-9">
                <!-- Tabs Navigation -->
                <ul class="nav nav-pills mb-4 custom-tabs" id="applicationTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="index-tab" data-bs-toggle="tab" data-bs-target="#indexForm" type="button" role="tab">Index Form</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="genealogy-tab" data-bs-toggle="tab" data-bs-target="#genealogyForm" type="button" role="tab">Genealogy Form</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab">Documents</button>
                    </li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content p-3 border rounded shadow-sm">
                    <div class="tab-pane fade show active" id="indexForm" role="tabpanel">
                        @include('staff.applications.index_form')
                    </div>
                    <div class="tab-pane fade" id="genealogyForm" role="tabpanel">
                        @include('staff.applications.genealogy_form')
                    </div>
                    <div class="tab-pane fade" id="documents" role="tabpanel">
                        @include('staff.applications.documents')
                    </div>
                </div>
            </div>

            <!-- Right Column: Review Decision panel -->
            <div class="col-md-3 d-flex flex-column align-items-start">
                <div class="review-panel sticky-sidebar w-100">
                    @if($application->coc_status === 'Approved')
                        <div class="card shadow-sm border-success p-3 w-100" style="max-width: 350px;">
                            <h5 class="fw-bold text-success mb-3">
                                <i class="fas fa-circle-check me-1"></i> Final Approval Complete
                            </h5>
                            <p class="mb-2">This application has already been approved by the administrator.</p>
                            <p class="text-muted small mb-0">It is available to staff for viewing only. No further forwarding or review decision is required.</p>
                        </div>
                    @else
                        @include('staff.applications.review_decision')
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom Tab Design */
    .custom-tabs .nav-link {
        background: #f1f1f1;
        border-radius: 10px;
        margin: 0 5px;
        color: #333;
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 10px 18px;
    }
    .custom-tabs .nav-link:hover {
        background: #e2e6ea;
    }
    .custom-tabs .nav-link.active {
        background: #0d6efd;
        color: #fff;
        box-shadow: 0px 3px 8px rgba(0,0,0,0.2);
    }

    .review-panel {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
    }

    /* ✅ Sticky Sidebar */
    .sticky-sidebar {
        position: sticky;
        top: 20px;
        align-self: flex-start; 
    }
</style>
@endpush
