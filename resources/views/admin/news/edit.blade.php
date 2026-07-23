@extends('layouts.admin')

@section('title', 'Edit News')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root {
    --primary-green: #3E7B27;
    --primary-green-hover: #2f5f1e;
    --primary-green-light: #f0f7ed;
}

body {
    background: #f5f5f5;
}

.content-wrapper {
    display: flex;
    justify-content: center;   
    align-items: flex-start;      
    min-height: calc(100vh - 80px);
    padding: 20px;
    width: 100%;
}

.page-header {
    margin-bottom: 32px;
}

.page-header h2 {
    font-size: clamp(22px, 4vw, 28px);
    font-weight: 600;
    color: #222;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-card {
    background: white;
    border-radius: 12px;
    padding: clamp(20px, 4vw, 40px);
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    max-width: 900px;
    width: 100%;
    border: 1px solid #e5e5e5;
    margin: 0 auto;
}

.form-group {
    margin-bottom: 24px;
}

.form-label {
    font-size: clamp(14px, 2vw, 16px) !important;
    font-weight: 600;
    color: #222 !important;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.form-control {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e5e5;
    border-radius: 8px;
    font-size: clamp(13px, 2vw, 14px);
    transition: all 0.3s ease;
    font-family: 'Poppins', sans-serif;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(62, 123, 39, 0.1);
}

textarea.form-control {
    resize: vertical;
    min-height: 120px;
    line-height: 1.6;
}

.form-actions {
    display: flex;
    gap: 12px;
    padding-top: 20px;
    border-top: 2px solid #f0f0f0;
    margin-top: 32px;
    justify-content: flex-end;
    flex-wrap: wrap;
}

.btn-submit {
    padding: 12px 32px;
    border-radius: 8px;
    background: var(--primary-green);
    color: white;
    border: none;
    font-size: clamp(13px, 2vw, 14px);
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 120px;
}

.btn-submit:hover {
    background: var(--primary-green-hover);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(62, 123, 39, 0.2);
}

.btn-cancel {
    padding: 12px 32px;
    border-radius: 8px;
    background: #555;
    color: white;
    border: none;
    font-size: clamp(13px, 2vw, 14px);
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 120px;
}

.btn-cancel:hover {
    background: #222;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.file-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.file-input-label {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    background: var(--primary-green-light);
    color: var(--primary-green);
    border-radius: 8px;
    cursor: pointer;
    font-size: clamp(13px, 2vw, 14px);
    font-weight: 500;
    transition: all 0.2s ease;
    gap: 8px;
}

.file-input-label:hover {
    background: var(--primary-green);
    color: white;
}

input[type="file"] {
    display: none;
}

.file-name {
    color: #6c757d;
    font-size: clamp(12px, 2vw, 14px);
    word-break: break-word;
}

.current-image {
    margin-top: 12px;
    padding: 16px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e5e5e5;
    display: inline-block;
}

.current-image img {
    border-radius: 6px;
    border: 2px solid #e5e5e5;
    max-width: 100%;
    height: auto;
    display: block;
}

.current-image-label {
    display: block;
    font-size: clamp(12px, 2vw, 13px);
    color: #6c757d;
    margin-bottom: 8px;
    font-weight: 500;
}

/* Tablet */
@media (max-width: 768px) {
    .content-wrapper {
        padding: 15px;
    }

    .form-card {
        padding: 24px;
    }

    .page-header {
        margin-bottom: 24px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-actions {
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-submit,
    .btn-cancel {
        width: 100%;
        min-width: unset;
    }

    .file-input-wrapper {
        flex-direction: column;
        align-items: flex-start;
    }

    .file-input-label {
        width: 100%;
        justify-content: center;
    }

    .current-image {
        width: 100%;
    }

    .current-image img {
        width: 100%;
        max-width: 200px;
    }
}

/* Mobile */
@media (max-width: 480px) {
    .content-wrapper {
        padding: 10px;
    }

    .form-card {
        padding: 20px 16px;
        border-radius: 8px;
    }

    .page-header h2 {
        font-size: 20px;
    }

    .form-control {
        padding: 10px 12px;
        font-size: 14px;
    }

    .btn-submit,
    .btn-cancel {
        padding: 10px 20px;
        font-size: 14px;
    }
}

/* Desktop - ensure proper width */
@media (min-width: 1200px) {
    .form-card {
        max-width: 900px;
    }
}
</style>

<div class="content-wrapper">
    <div class="form-card">
        <div class="page-header">
            <h2>
                <i class="fas fa-edit" style="color: var(--primary-green);"></i>
                Edit Content
            </h2>
        </div>

        <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-heading" style="color: var(--primary-green);"></i>
                    Title
                </label>
                <input type="text" 
                       name="title" 
                       class="form-control" 
                       value="{{ old('title', $news->title) }}"
                       placeholder="Enter news title"
                       required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-image" style="color: var(--primary-green);"></i>
                    Image
                </label>
                
                @if($news->image)
                    <div class="current-image">
                        <span class="current-image-label">Current Image:</span>
                        <img src="{{ asset('storage/'.$news->image) }}" alt="News Image" width="150">
                    </div>
                @endif
                
                <div class="file-input-wrapper" style="margin-top: 12px;">
                    <label for="imageInput" class="file-input-label">
                        <i class="fas fa-upload"></i>
                        <span>Choose New Image</span>
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
                    <i class="fas fa-align-left" style="color: var(--primary-green);"></i>
                    Description
                </label>
                <textarea name="description" 
                          class="form-control"
                          placeholder="Enter news description"
                          rows="5">{{ old('description', $news->description) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-calendar" style="color: var(--primary-green);"></i>
                    Date
                </label>
                <input type="date" 
                       name="date" 
                       class="form-control" 
                       value="{{ old('date', $news->date) }}"
                       required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-toggle-on" style="color: var(--primary-green);"></i>
                    Status
                </label>
                <select name="status" class="form-control" required>
                    <option value="Draft" {{ $news->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Published" {{ $news->status == 'Published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Update</button>
                <a href="{{ route('admin.news.index') }}" class="btn-cancel">Cancel</a>
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
