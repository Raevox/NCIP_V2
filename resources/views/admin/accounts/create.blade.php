@extends('layouts.admin')

@section('title', 'Add New Employee Account')

@section('content')
<style>
    /* Container */
    .form-containerAddAcc {
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
        font-weight: 600 !important;
        margin-bottom: 0.4rem;
        color: #222 !important;
        font-size: 13px !important;
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

    /* Buttons */
     /* Buttons */
    .form-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 2rem;
    }

    .button {
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
        .form-containerAddAcc {
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
        .form-buttons .buttonIp {
            width: 100%;
        }
    }
</style>

<div class="form-containerAddAcc">
    <h4 class="form-title">Add New Employee Account</h4>
    <p class="form-subtitle">Fill up the form to create a new staff account.</p>

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

    <!-- Form -->
    <form action="{{ route('admin.accounts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-grid">
            <!-- First Name -->
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" 
                    placeholder="Enter firstname"   value="{{ old('first_name') }}" required>
            </div>

            <!-- Last Name -->
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" 
                    placeholder="Enter lastname"   value="{{ old('last_name') }}" required>
            </div>

            <!-- Profile Picture -->
            <div class="form-group">
                <label>Profile Picture</label>
                <input type="file" name="profile_picture">
            </div>

            <!-- Role -->
            <div class="form-group">
                <label>Role</label>
                <select name="role">
                    <option value="staff" selected>Staff</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <!-- Phone -->
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="contact" 
                    placeholder="Enter Phone number"   value="{{ old('contact') }}">
            </div>

            <!-- Email -->
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" 
                    placeholder="example@gmail.com"   value="{{ old('email') }}" required>
            </div>

            <!-- Address -->
            <div class="form-group full-width">
                <label>Address</label>
                <input type="text" name="address" 
                    placeholder="Enter Address"   value="{{ old('address') }}">
            </div>

            <!-- Password -->
            <div class="form-group">
                <label>Password</label>
                <input type="password" placeholder="Enter password" name="password" required>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="active" selected>Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <!-- Buttons -->
        <div class="form-buttons">
            <a href="{{ route('admin.accounts.index') }}" class="button btn-cancel">Cancel</a>
            <button type="submit" class="button btn-save">Save</button>
        </div>
    </form>
</div>
@endsection
