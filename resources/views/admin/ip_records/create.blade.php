@extends('layouts.admin')

@section('title', 'Add New Record Indigenous People')
<link rel="stylesheet" href="{{ asset('css/adminIPrecords.css') }}">

@section('content')
<div class="form-containerIP">
    <h2 class="form-title">Add New Record Indigenous People</h2>
    <p class="form-subtitle">Add a new Indigenous People (IP) record. Please ensure all info is accurate. Records cannot be edited after submission.</p>

    <form action="{{ route('ip_records.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

       <h4 class="ip-records">Personal Information</h4>
        <div class="form-grid">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" placeholder="Enter first name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" placeholder="Enter last name" required>
            </div>
            <div class="form-group">
                <label for="sex">Sex</label>
                <select name="sex" id="sex" required>
                    <option disabled selected>Select Sex</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ip_group">IP Group</label>
                <input type="text" name="ip_group" placeholder="e.g. Dumagat, Aeta" required>
            </div>
            <div class="form-group">
                <label for="birth_date">Date of Birth</label>
                <input type="date" name="birth_date" required>
            </div>

            <div class="form-group">
                <label for="origin_province">Origin Province</label>
                <select name="origin_province" id="origin_province" required>
                    <option disabled selected>Select Province</option>
                </select>
            </div>
            <div class="form-group">
                <label for="origin_municipality">Origin Municipality</label>
                <select name="origin_municipality" id="origin_municipality" required>
                    <option disabled selected>Select Municipality</option>
                </select>
            </div>
            <div class="form-group">
                <label for="origin_barangay">Origin Barangay</label>
                <select name="origin_barangay" id="origin_barangay" required>
                    <option disabled selected>Select Barangay</option>
                </select>
            </div>
        </div>

        <h4 class="ip-records">Present Address</h4>
        <div class="form-grid">
            <div class="form-group">
                <label for="province">Province</label>
                <input type="text" name="province" value="Nueva Ecija" readonly>
            </div>
            <div class="form-group">
                <label for="municipality">Municipality</label>
                <select name="municipality" id="present_municipality" required>
                    <option disabled selected>Select Municipality</option>
                </select>
            </div>
            <div class="form-group">
                <label for="barangay">Barangay</label>
                <select name="barangay" id="present_barangay" required>
                    <option disabled selected>Select Barangay</option>
                </select>
            </div>

            <div class="form-group">
                <label for="census_date">Date of Census</label>
                <input type="date" name="census_date" required>
            </div>
            <div class="form-group">
                <label for="civil_status">Civil Status</label>
                <input type="text" name="civil_status" placeholder="e.g. Single, Married" required>
            </div>
            <div class="form-group">
                <label for="religion">Religion</label>
                <input type="text" name="religion" placeholder="Enter religion" required>
            </div>
            <div class="form-group">
                <label for="ncip_number">NCIP Number</label>
                <input type="text" name="ncip_number" placeholder="Enter NCIP tracking number" required>
            </div>
            <div class="form-group">
                <label for="occupation">Occupation</label>
                <input type="text" name="occupation" placeholder="Enter current occupation" required>
            </div>
            <div class="form-group">
                <label for="income">Monthly Income</label>
                <input type="text" name="income" placeholder="e.g. 10000">
            </div>
            <div class="form-group">
                <label for="pwd">PWD (if applicable)</label>
                <input type="text" name="pwd" placeholder="Enter PWD ID or 'None'">
            </div>
            <div class="form-group">
                <label for="educational_level">Educational Level</label>
                <select name="educational_level" required>
                    <option disabled selected>Select Educational Level</option>
                    <option value="Elementary">Elementary</option>
                    <option value="High School">High School</option>
                    <option value="College">College</option>
                </select>
            </div>
            <div class="form-group">
                <label for="degree">Degree (if any)</label>
                <input type="text" name="degree" placeholder="e.g. BSIT, BEED">
            </div>
            <div class="form-group full-width">
                <label for="image">Upload Image</label>
                <input type="file" name="image">
            </div>
        </div>

        <div class="form-buttons">
            <button type="submit" class="buttonIp btn-saveIP">Save</button>
            <a href="{{ route('ip_records.index') }}" class="btn btn-cancelIp">Cancel</a>
        </div>
    </form>
</div>
{{-- JS Address loading remains unchanged --}}
<script>
const provinceSelect = document.getElementById('origin_province');
const originMunicipalitySelect = document.getElementById('origin_municipality');
const originBarangaySelect = document.getElementById('origin_barangay');
const presentMunicipalitySelect = document.getElementById('present_municipality');
const presentBarangaySelect = document.getElementById('present_barangay');

let municipalities = [];
let barangays = [];

async function loadAddressData() {
    const provinces = (await (await fetch('/data/provinces.json')).json()).RECORDS;
    municipalities = (await (await fetch('/data/mun.json')).json()).RECORDS;
    barangays = (await (await fetch('/data/brgy.json')).json()).RECORDS;

    // Sort provinces alphabetically
    provinces.sort((a, b) => a.provDesc.localeCompare(b.provDesc));

    provinceSelect.innerHTML = '<option disabled selected>Select Province</option>';
    provinces.forEach(p => {
        provinceSelect.innerHTML += `<option value="${p.provDesc}">${p.provDesc}</option>`;
    });

    provinceSelect.addEventListener('change', function () {
        const selectedProv = this.value;
        const prov = provinces.find(p => p.provDesc === selectedProv);
        originMunicipalitySelect.innerHTML = '<option disabled selected>Select Municipality</option>';
        originBarangaySelect.innerHTML = '<option disabled selected>Select Barangay</option>';

        const munFiltered = municipalities.filter(m => m.provCode === prov.provCode);
        // Sort municipalities alphabetically
        munFiltered.sort((a, b) => a.citymunDesc.localeCompare(b.citymunDesc));
        
        munFiltered.forEach(m => {
            originMunicipalitySelect.innerHTML += `<option value="${m.citymunDesc}">${m.citymunDesc}</option>`;
        });
    });

    originMunicipalitySelect.addEventListener('change', function () {
        const selectedMun = this.value;
        const mun = municipalities.find(m => m.citymunDesc === selectedMun);
        originBarangaySelect.innerHTML = '<option disabled selected>Select Barangay</option>';

        const brgyFiltered = barangays.filter(b => b.citymunCode === mun.citymunCode);
        // Sort barangays alphabetically
        brgyFiltered.sort((a, b) => a.brgyDesc.localeCompare(b.brgyDesc));
        
        brgyFiltered.forEach(b => {
            originBarangaySelect.innerHTML += `<option value="${b.brgyDesc}">${b.brgyDesc}</option>`;
        });
    });

    // Present Address (Nueva Ecija)
    const nuevaEcija = provinces.find(p => p.provDesc.toLowerCase() === 'nueva ecija');
    const neMunicipalities = municipalities.filter(m => m.provCode === nuevaEcija.provCode);
    
    // Sort Nueva Ecija municipalities alphabetically
    neMunicipalities.sort((a, b) => a.citymunDesc.localeCompare(b.citymunDesc));

    presentMunicipalitySelect.innerHTML = '<option disabled selected>Select Municipality</option>';
    neMunicipalities.forEach(m => {
        presentMunicipalitySelect.innerHTML += `<option value="${m.citymunDesc}">${m.citymunDesc}</option>`;
    });

    presentMunicipalitySelect.addEventListener('change', function () {
        const selectedMun = this.value;
        const mun = municipalities.find(m => m.citymunDesc === selectedMun);
        presentBarangaySelect.innerHTML = '<option disabled selected>Select Barangay</option>';

        const brgyFiltered = barangays.filter(b => b.citymunCode === mun.citymunCode);
        // Sort barangays alphabetically
        brgyFiltered.sort((a, b) => a.brgyDesc.localeCompare(b.brgyDesc));
        
        brgyFiltered.forEach(b => {
            presentBarangaySelect.innerHTML += `<option value="${b.brgyDesc}">${b.brgyDesc}</option>`;
        });
    });
}

loadAddressData();</script>
@endsection
