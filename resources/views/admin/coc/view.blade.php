@extends('layouts.admin')

@section('title', 'COC Certificate')

@section('content')
<div class="container mt-5">
    @if($coc->status == 'Approved')
        <div class="certificate">
            <h1>Certificate of Confirmation</h1>
            <p>This certifies that</p>
            <h2>{{ $coc->applicant->first_name }} {{ $coc->applicant->last_name }}</h2>
            <p>has been officially granted a Certificate of Confirmation.</p>
        </div>
    @else
        <div class="alert alert-warning text-center p-4">
            <h4>Notice</h4>
            <p>This COC application is <strong>{{ ucfirst($coc->status) }}</strong> and cannot be viewed as a certificate yet.</p>
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('admin.applicants.view', $coc->applicant_id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>
</div>
@endsection
