@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Applicant</h1>

    <form action="{{ route('admin.applicants.update', $applicant->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium">Name</label>
            <input type="text" name="name" value="{{ old('name', $applicant->name) }}" class="w-full border p-2 rounded">
            @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $applicant->email) }}" class="w-full border p-2 rounded">
            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-medium">Status</label>
            <select name="status" class="w-full border p-2 rounded">
                <option value="pending" {{ $applicant->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ $applicant->status == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ $applicant->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            @error('status') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        <a href="{{ route('admin.applicants.accounts') }}" class="ml-2 text-gray-600">Cancel</a>
    </form>
</div>
@endsection
