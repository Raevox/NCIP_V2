@extends('layouts.admin')

@section('title', 'Edit Employee Account')

@section('content')
<style>
    /* Container */
    .form-containerEditAcc {
        max-width: 950px;
        margin: 2rem auto;
        background: #fff;
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        font-family: 'Poppins', sans-serif;
        border: 1px solid #e5e5e5;
    }

    .form-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #222;
        margin-bottom: .25rem;
        text-align: center;
    }

    .form-subtitle {
        text-align: center;
        font-size: 0.95rem;
        color: #555;
        margin-bottom: 1.5rem;
    }

    /* Grid Layout */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.2rem 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: span 2;
    }

    label {
        font-size: 15px !important;
        font-weight: 500;
        margin-bottom: 0.4rem;
        color: #222 !important;
    }

    /* Inputs */
    .form-group input,
    .form-group select {
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.2s ease-in-out;
        background: #fff;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #222;
        outline: none;
    }

    /* Profile Picture */
    .profile-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 2px solid #3e7b27;
        object-fit: cover;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    /* Buttons */
    .form-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 2rem;
    }

    .buttonEdit {
        padding: 10px 18px;
        border-radius: 6px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: background 0.2s ease-in-out;
        font-size: 14px;
    }

    .btn-cancel {
        background: #555;
        color: #fff;
        text-decoration: none;
    }

    .btn-cancel:hover {
        background: #222;
        color: #fff;
    }

    .btn-save {
        background: #3e7b27;
        color: #fff;
    }

    .btn-save:hover {
        background: #276219;
    }

    /* Responsive Fix */
    @media (max-width: 600px) {
        .form-containerEditAcc {
            padding: 1.2rem;
        }
        .form-title {
            font-size: 1.3rem;
        }
        .form-group.full-width {
            grid-column: span 1;
        }
        .form-buttons {
            flex-direction: column;
        }
        .form-buttons .button {
            width: 100%;
        }
    }
</style>

<div class="form-containerEditAcc">
    <h4 class="form-title">Edit Employee Account</h4>
    <p class="form-subtitle">Update the account information for <strong>{{ $account->name }}</strong>.</p>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Current Profile Picture -->
    @if($account->profile_picture)
        <div class="text-center mb-4">
            <img src="{{ asset('storage/' . $account->profile_picture) }}" 
                 alt="Profile Picture" 
                 class="profile-preview">
            <p class="text-muted mt-2">Current Profile Picture</p>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('admin.accounts.update', $account->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <!-- First Name -->
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" 
                       value="{{ old('first_name', $account->first_name) }}" required>
            </div>

            <!-- Last Name -->
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" 
                       value="{{ old('last_name', $account->last_name) }}" required>
            </div>

            <!-- Profile Picture -->
            <div class="form-group full-width">
                <label>Profile Picture</label>
                <input type="file" name="profile_picture">
                <small class="text-muted">Leave empty to keep current picture</small>
            </div>

            <!-- Role -->
            <div class="form-group">
                <label>Role</label>
                <select name="role">
                    <option value="staff" {{ $account->role == 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="admin" {{ $account->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <!-- Phone -->
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="contact" 
                       value="{{ old('contact', $account->contact) }}">
            </div>

            <!-- Email -->
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" 
                       value="{{ old('email', $account->email) }}" required>
            </div>

            <!-- Address -->
            <div class="form-group full-width">
                <label>Address</label>
                <input type="text" name="address" 
                       value="{{ old('address', $account->address) }}">
            </div>

            <!-- Status -->
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="active" {{ $account->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $account->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Password Note -->
            <div class="form-group">
                <label>Password</label>
                <input type="text" value="********" disabled>
                <small class="text-muted">Password cannot be changed here. Use password reset feature.</small>
            </div>
        </div>

        <!-- Buttons -->
        <div class="form-buttons">
            <a href="{{ route('admin.accounts.index') }}" class="buttonEdit btn-cancel">Cancel</a>
            <button type="submit" class="buttonEdit btn-save">Update Account</button>
        </div>
    </form>
</div>
@endsection
