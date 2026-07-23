@extends('layouts.admin')

@section('title', 'Add News')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root {
    --primary-green: #3E7B27;
    --primary-green-hover: #2f5f1e;
    --primary-green-light: #f0f7ed;
}
.main {
    display: flex;
    justify-content: center;   
    align-items: center;      
    min-height: 100vh;         
    background: #ffffff;     
    padding: 20px;
}

.page-header {
    margin-bottom: 32px;
}

.page-header h2 {
    font-size: 28px;
    font-weight: 600;
    color: #222;
    margin: 0;
}

.form-card {
    background: white;
    border-radius: 10px;
    padding: 32px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    max-width: 800px;
    width: 100%;
    border: 1px solid #e5e5e5;
    
}

.form-group {
    margin-bottom: 24px;
}

.form-label {
    font-size: 16px !important;
    font-weight: 600;
    color: #222 !important;
    margin-bottom: 8px;
    display: block;
}

.form-control {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e5e5;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(62, 123, 39, 0.1);
}

.form-control-file {
    padding: 10px 0;
}

textarea.form-control {
    resize: vertical;
    min-height: 120px;
}

.form-actions {
    display: flex;
    gap: 12px;
    padding-top: 16px;
    border-top: 2px solid #f0f0f0;
    margin-top: 32px;
    justify-content: flex-end;
}

.btn-submit {
    padding: 12px 32px;
    border-radius: 8px;
    background: var(--primary-green);
    color: white;
    border: none;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-submit:hover {
    background: var(--primary-green-hover);
}

.btn-cancel {
    padding: 12px 32px;
    border-radius: 8px;
    background: #555;
    color: white;
    border: none;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-block;
}

.btn-cancel:hover {
    background: #222;
    color: white;
}

.file-input-wrapper {
    position: relative;
}

.file-input-label {
    display: inline-block;
    padding: 10px 20px;
    background: var(--primary-green-light);
    color: var(--primary-green);
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.file-input-label:hover {
    background: var(--primary-green);
    color: white;
}

.file-input-label i {
    margin-right: 8px;
}

input[type="file"] {
    display: none;
}

.file-name {
    display: inline-block;
    margin-left: 12px;
    color: #6c757d;
    font-size: 14px;
}

@media (max-width: 768px) {
    .form-card {
        padding: 24px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn-submit,
    .btn-cancel {
        width: 100%;
    }
}
</style>

<div class="main">

    <div class="form-card">
        <div class="page-header">
            <h2><i class="fas fa-plus-circle me-2" style="color: var(--primary-green);"></i>Add New Content</h2>
        </div>
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-heading me-1" style="color: var(--primary-green);"></i>
                    Title
                </label>
                <input type="text" 
                       name="title" 
                       class="form-control" 
                       placeholder="Enter news title"
                       required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-image me-1" style="color: var(--primary-green);"></i>
                    Image
                </label>
                <div class="file-input-wrapper">
                    <label for="imageInput" class="file-input-label">
                        <i class="fas fa-upload"></i>Choose Image
                    </label>
                    <input type="file" 
                           name="image" 
                           id="imageInput"
                           accept="image/*"
                           onchange="displayFileName(this)">
                    <span class="file-name" id="fileName">No file chosen</span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-align-left me-1" style="color: var(--primary-green);"></i>
                    Description
                </label>
                <textarea name="description" 
                          class="form-control"
                          placeholder="Enter news description"
                          rows="5"></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-calendar me-1" style="color: var(--primary-green);"></i>
                    Date
                </label>
                <input type="date" 
                       name="date" 
                       class="form-control" 
                       required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-toggle-on me-1" style="color: var(--primary-green);"></i>
                    Status
                </label>
                <select name="status" class="form-control" required>
                    <option value="Draft">Draft</option>
                    <option value="Published">Published</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Save
                </button>
                <a href="{{ route('admin.news.index') }}" class="btn-cancel">Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function displayFileName(input) {
    const fileName = input.files[0]?.name || 'No file chosen';
    document.getElementById('fileName').textContent = fileName;
}
</script>

@endsection
