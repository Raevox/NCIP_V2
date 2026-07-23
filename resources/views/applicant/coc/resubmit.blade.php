@extends('layouts.applicant')

@section('content')
<form action="{{ route('applicant.coc.resubmit.post', $application->id) }}" method="POST">

    @csrf

    {{-- Only show the returned steps --}}
    @if($returnedStep === 1)
        @include('applicant.coc.step1', ['data' => $application->step1])
        @include('applicant.coc.step2', ['data' => $application->step2])
    @elseif($returnedStep === 3)
        @include('applicant.coc.step3', ['data' => $application->step3])
        @include('applicant.coc.step4', ['data' => $application->step4])
    @elseif($returnedStep === 5)
        @include('applicant.coc.step5', ['data' => $application->step5])
    @endif

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection
