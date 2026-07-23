@extends('layouts.admin')
@section('title', 'View IP Record Details')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/adminIPrecords.css') }}">

<div class="ip-record-show-container">
    <div class="ip-card">

        {{-- LEFT PANEL --}}
        <div class="ip-card-left">
            <img src="{{ $record->image ? asset('storage/' . $record->image) : asset('default-profile.png') }}" alt="Profile Image">
            <h2>{{ $record->first_name }} {{ $record->last_name }}</h2>
        </div>

        {{-- RIGHT PANEL --}}
        <div class="ip-card-right">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h3 style="font-size: 25px; font-weight: 700; color: #222;">IP Record Details</h3>
               <div class="action-buttons">
                <a href="{{ route('ip_records.index') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <form action="{{ route('ip_records.destroy', $record->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>

            </div>

            {{-- PERSONAL INFO --}}
            <h5 class="section-heading"><i class="fa fa-user-circle"></i> Personal Information</h5>
            <div class="info-row">
                <div class="info-box"><strong>Name:</strong> {{ $record->first_name }} {{ $record->last_name }}</div>
                <div class="info-box"><strong>Sex:</strong> {{ $record->sex }}</div>
                <div class="info-box"><strong>IP Group:</strong> {{ $record->ip_group }}</div>
                <div class="info-box"><strong>Birth Date:</strong> {{ \Carbon\Carbon::parse($record->birth_date)->format('F d, Y') }}</div>
                <div class="info-box"><strong>Date of Census:</strong> {{ \Carbon\Carbon::parse($record->census_date)->format('F d, Y') }}</div>
                <div class="info-box"><strong>Status:</strong> {{ $record->civil_status }}</div>
            </div>

            {{-- PRESENT ADDRESS --}}
            <h5 class="section-heading mt-4"><i class="fa fa-map-marker-alt"></i> Present Address</h5>
            <div class="info-row">
                <div class="info-box"><strong>Province:</strong> {{ $record->province }}</div>
                <div class="info-box"><strong>Municipality:</strong> {{ $record->municipality }}</div>
                <div class="info-box"><strong>Barangay:</strong> {{ $record->barangay }}</div>
            </div>

            {{-- PLACE OF ORIGIN --}}
            <h5 class="section-heading mt-4"><i class="fa fa-map-pin"></i> Place of Origin</h5>
            <div class="info-row">
                <div class="info-box"><strong>Province:</strong> {{ $record->origin_province ?? '-' }}</div>
                <div class="info-box"><strong>Municipality:</strong> {{ $record->origin_municipality ?? '-' }}</div>
                <div class="info-box"><strong>Barangay:</strong> {{ $record->origin_barangay ?? '-' }}</div>
            </div>

            {{-- OTHER DETAILS --}}
            <h5 class="section-heading mt-4"><i class="fa fa-info-circle"></i> Other Information</h5>
            <div class="info-row">
                <div class="info-box"><strong>Religion:</strong> {{ $record->religion }}</div>
                <div class="info-box"><strong>NCIP Number:</strong> {{ $record->ncip_number }}</div>
                <div class="info-box"><strong>Occupation:</strong> {{ $record->occupation }}</div>
                <div class="info-box"><strong>Income:</strong> {{ $record->income }}</div>
                <div class="info-box"><strong>Education:</strong> {{ $record->educational_level }}</div>
                <div class="info-box"><strong>Degree:</strong> {{ $record->degree ?? 'N/A' }}</div>
                <div class="info-box"><strong>PWD:</strong> {{ $record->pwd ?? 'No' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
