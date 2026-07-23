@extends('layouts.applicant')

@section('title', 'Track Application Status')

@section('content')
<div class="container mt-4">
    @include('applicant.components.progress_bar', ['application' => $application])
    <div class="track-status-container mt-4">
        <div class="status-card">
            <h2 class="card-title">Track Application Status</h2>
            <div class="info-grid">
                <p><span>Name:</span> {{ Auth::user()->full_name }}</p>
                <p><span>Date of Application:</span> {{ $application->created_at ? $application->created_at->format('F d, Y') : 'N/A' }}</p>
                <p>
                    <span>Current Handler:</span> 
                    @if($application)
                        @if(in_array($application->coc_status, ['Returned', 'Under Review']))
                            Staff
                        @elseif(in_array($application->coc_status, ['Approved', 'Admin Approval']))
                            Admin
                        @else
                            N/A
                        @endif
                    @else
                        N/A
                    @endif
                </p>

                <p>
                    <span class="status-label 
                        @if($application)
                            @if(in_array($application->coc_status, ['Admin Approval', 'Approved'])) status-approved
                            @elseif($application->coc_status === 'Returned') status-returned
                            @else status-review
                            @endif
                        @else status-submitted
                        @endif">    
                        {{ $application->coc_status ?? 'No application submitted' }}
                    </span>


                </p>
            </div>
        </div>
        @if($application && $application->status === 'Returned')
            @include('applicant.components.returned_notice', ['application' => $application])
        @endif

    </div>
</div>
@endsection

@section('styles')
<style>
.status-card {
    background-color: #ffffff;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem 2rem;
}

.status-label.status-approved {
    background-color: #16a34a;
    color: #fff;
}

.status-label.status-review {
    background-color: #facc15;
    color: #333;
}

.status-label.status-submitted {
    background-color: #3b82f6;
    color: #fff;
}
@media (max-width: 600px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
