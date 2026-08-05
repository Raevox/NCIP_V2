@extends('layouts.admin')

@section('title', 'Add News')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --green-500: #2E7D46;
    --green-400: #52a033;
    --green-100: #e8f5e2;
    --green-50:  #f4fbf0;
    --sand-100: #f7f5f0;
    --sand-200: #ede9e0;
    --text-dark: #1a1f16;
    --text-mid:  #4a5245;
    --text-soft: #8a9485;
    --white: #ffffff;
    --shadow-sm: 0 1px 4px rgba(30,60,20,0.07);
    --radius-sm: 8px;
    --radius-md: 14px;
}
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Poppins', sans-serif; color: var(--text-dark); margin: 10px; }

.page-header {
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.page-header h2 {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 10px;
    letter-spacing: -0.3px;
}
.header-icon {
    width: 38px; height: 38px;
    background: var(--green-500);
    color: #fff;
    border-radius: var(--radius-sm);
    display: grid;
    place-items: center;
    font-size: 16px;
    flex-shrink: 0;
}
.back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--text-soft);
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 16px;
    transition: color 0.18s;
}
.back-link:hover { color: var(--green-500); }

.form-card {
    background: var(--white);
    border-radius: var(--radius-md);
    border: 1px solid var(--sand-200);
    box-shadow: var(--shadow-sm);
    padding: 30px 32px;
    max-width: 680px;
}

.form-label {
    font-size: 13.5px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 6px;
    display: block;
}
.form-label .req { color: #dc2626; margin-left: 2px; }

.form-control {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid var(--sand-200);
    border-radius: var(--radius-sm);
    font-family: 'Poppins', sans-serif;
    font-size: 13.5px;
    color: var(--text-dark);
    background: var(--sand-100);
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
}
.form-control:focus {
    border-color: var(--green-400);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(62,123,39,0.10);
}

/* ── Styled Dropdown Select ───────── */
.form-select {
    width: 100%;
    padding: 10px 40px 10px 14px;
    border: 1.5px solid var(--sand-200);
    border-radius: var(--radius-sm);
    font-family: 'Poppins', sans-serif;
    font-size: 13.5px;
    color: var(--text-dark);
    background-color: var(--white);
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238a9485' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    cursor: pointer;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
    box-shadow: var(--shadow-sm);
}
.form-select:focus {
    border-color: var(--green-400);
    box-shadow: 0 0 0 3px rgba(62,123,39,0.10);
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%232E7D46' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
}
textarea.form-control { resize: vertical; min-height: 110px; }
.is-invalid { border-color: #dc2626 !important; }
.invalid-feedback { font-size: 12px; color: #dc2626; margin-top: 4px; }

.form-group { margin-bottom: 20px; }

/* ── Image Upload ─────────────────── */
.photo-upload-area {
    border: 2px dashed var(--sand-200);
    border-radius: var(--radius-sm);
    padding: 24px 20px;
    text-align: center;
    background: var(--sand-100);
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
    position: relative;
}
.photo-upload-area:hover,
.photo-upload-area.drag-over {
    border-color: var(--green-400);
    background: var(--green-50);
}
.photo-upload-area input[type="file"] {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}
.photo-upload-icon { font-size: 32px; color: var(--text-soft); margin-bottom: 8px; }
.photo-upload-text { font-size: 13px; color: var(--text-soft); }
.photo-upload-text strong { color: var(--green-500); }
.photo-hint { font-size: 11.5px; color: var(--text-soft); margin-top: 4px; }

.photo-preview-wrap {
    display: none;
    position: relative;
    margin-top: 12px;
}
.photo-preview-wrap img {
    width: 100%;
    max-height: 220px;
    object-fit: cover;
    border-radius: var(--radius-sm);
    border: 1.5px solid var(--sand-200);
}
.photo-preview-wrap.show { display: block; }
.btn-remove-photo {
    position: absolute;
    top: 8px; right: 8px;
    background: rgba(0,0,0,0.55);
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 28px; height: 28px;
    font-size: 13px;
    cursor: pointer;
    display: grid;
    place-items: center;
    transition: background 0.18s;
    z-index: 5;
}
.btn-remove-photo:hover { background: #dc2626; }

/* ── Status Select ───────────────── */
.toggle-row {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    background: var(--sand-100);
    border-radius: var(--radius-sm);
    border: 1.5px solid var(--sand-200);
}
.toggle-label-text { font-size: 13.5px; font-weight: 600; color: var(--text-dark); }
.toggle-label-sub  { font-size: 12px; color: var(--text-soft); }

/* Buttons */
.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 24px;
    background: var(--green-500);
    color: #fff;
    border: none;
    border-radius: var(--radius-sm);
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.18s;
    box-shadow: 0 2px 8px rgba(46,125,70,0.25);
}
.btn-submit:hover { background: #1a5c30; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(46,125,70,0.35); }
.btn-cancel {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 20px;
    background: var(--white);
    color: var(--text-mid);
    border: 1.5px solid var(--sand-200);
    border-radius: var(--radius-sm);
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.18s;
}
.btn-cancel:hover { border-color: var(--green-400); color: var(--green-500); background: var(--green-50); }
.form-actions { display: flex; align-items: center; gap: 12px; margin-top: 28px; padding-top: 22px; border-top: 1px solid var(--sand-200); }
</style>

<div>
    <a href="{{ route('admin.news.index') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to News List
    </a>

    <div class="page-header">
        <h2>
            <span class="header-icon"><i class="fas fa-plus"></i></span>
            Add News Article
        </h2>
    </div>

    <div class="form-card">

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4"
                 style="border-radius: var(--radius-sm); border: none; font-family: 'Poppins', sans-serif; font-size: 13.5px;">
                <i class="fas fa-exclamation-circle me-2"></i>
                Please fix the errors below.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" id="newsCreateForm">
            @csrf

            {{-- Title --}}
            <div class="form-group">
                <label class="form-label" for="title">Title <span class="req">*</span></label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') }}"
                    placeholder="Enter news title..."
                    autocomplete="off"
                    required
                />
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Description --}}
            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea
                    id="description"
                    name="description"
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="Write a brief description or summary of the news article..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Date --}}
            <div class="form-group">
                <label class="form-label" for="date">
                    <i class="fas fa-calendar-alt" style="color: var(--green-500); margin-right: 4px;"></i>
                    Date <span class="req">*</span>
                </label>
                <input
                    type="date"
                    id="date"
                    name="date"
                    class="form-control @error('date') is-invalid @enderror"
                    value="{{ old('date') }}"
                    required
                />
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Image Upload --}}
            <div class="form-group">
                <label class="form-label" for="image">
                    <i class="fas fa-image" style="color: var(--green-500); margin-right: 4px;"></i>
                    News Image
                </label>

                <div class="photo-upload-area" id="photoUploadArea">
                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/jpg,image/jpeg,image/png,image/webp"
                        onchange="previewPhoto(this)"
                    />
                    <div class="photo-upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                    <div class="photo-upload-text">
                        <strong>Click to upload</strong> or drag &amp; drop
                    </div>
                    <div class="photo-hint">JPG, PNG, WEBP · max 2 MB</div>
                </div>

                <div class="photo-preview-wrap" id="photoPreviewWrap">
                    <img src="" alt="Preview" id="photoPreviewImg" />
                    <button type="button" class="btn-remove-photo" onclick="removePhoto()" title="Remove image">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label class="form-label">Status <span class="req">*</span></label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Published" {{ old('status', 'Published') == 'Published' ? 'selected' : '' }}>Published</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <button type="submit" class="btn-submit" id="submitNewsBtn">
                    <i class="fas fa-save"></i> Save Article
                </button>
                <a href="{{ route('admin.news.index') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function previewPhoto(input) {
    const wrap = document.getElementById('photoPreviewWrap');
    const img  = document.getElementById('photoPreviewImg');
    const area = document.getElementById('photoUploadArea');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            wrap.classList.add('show');
            area.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removePhoto() {
    const wrap  = document.getElementById('photoPreviewWrap');
    const img   = document.getElementById('photoPreviewImg');
    const input = document.getElementById('image');
    const area  = document.getElementById('photoUploadArea');

    input.value = '';
    img.src = '';
    wrap.classList.remove('show');
    area.style.display = '';
}

// Drag & drop highlight
const uploadArea = document.getElementById('photoUploadArea');
uploadArea.addEventListener('dragover',  () => uploadArea.classList.add('drag-over'));
uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('drag-over'));
uploadArea.addEventListener('drop',      () => uploadArea.classList.remove('drag-over'));
</script>

@endsection
