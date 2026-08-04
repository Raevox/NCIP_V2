@extends('layouts.admin')

@section('title', 'Edit Tribe')

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
    background: #1d4ed8;
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

.form-control, .form-select {
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
.form-control:focus, .form-select:focus {
    border-color: var(--green-400);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(62,123,39,0.10);
}
textarea.form-control { resize: vertical; min-height: 100px; }
.is-invalid { border-color: #dc2626 !important; }
.invalid-feedback { font-size: 12px; color: #dc2626; margin-top: 4px; }

.form-group { margin-bottom: 20px; }

/* Toggle switch */
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
.form-check-input {
    width: 44px; height: 24px;
    cursor: pointer;
    background-color: #ccc;
    border: none;
    border-radius: 20px;
    transition: background-color 0.2s;
    flex-shrink: 0;
}
.form-check-input:checked { background-color: var(--green-500); }
.form-check-input:focus { box-shadow: 0 0 0 3px rgba(62,123,39,0.15); }

/* Meta info bar */
.meta-bar {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 12px 16px;
    background: var(--green-50);
    border-radius: var(--radius-sm);
    border: 1px solid var(--green-100);
    margin-bottom: 24px;
    flex-wrap: wrap;
}
.meta-item { font-size: 12px; color: var(--text-mid); }
.meta-item strong { color: var(--text-dark); }

/* ── Photo Upload ─────────────────── */
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

/* Current photo */
.current-photo-wrap {
    position: relative;
    display: inline-block;
    margin-bottom: 12px;
}
.current-photo-wrap img {
    width: 100%;
    max-height: 220px;
    object-fit: cover;
    border-radius: var(--radius-sm);
    border: 1.5px solid var(--sand-200);
    display: block;
}
.current-photo-label {
    font-size: 11.5px;
    color: var(--text-soft);
    margin-bottom: 6px;
    font-weight: 500;
}

/* Preview */
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

.btn-remove-current {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-top: 6px;
    padding: 5px 12px;
    background: #fef2f2;
    color: #dc2626;
    border: 1.5px solid #fca5a5;
    border-radius: var(--radius-sm);
    font-family: 'Poppins', sans-serif;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.18s;
}
.btn-remove-current:hover { background: #dc2626; color: #fff; }

/* Buttons */
.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 24px;
    background: #1d4ed8;
    color: #fff;
    border: none;
    border-radius: var(--radius-sm);
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.18s;
    box-shadow: 0 2px 8px rgba(29,78,216,0.25);
}
.btn-submit:hover { background: #1e40af; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(29,78,216,0.35); }
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
    <a href="{{ route('admin.tribes.index') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Tribe List
    </a>

    <div class="page-header">
        <h2>
            <span class="header-icon"><i class="fas fa-pen"></i></span>
            Edit Tribe
        </h2>
    </div>

    {{-- Meta Info --}}
    <div class="meta-bar" style="max-width: 680px;">
        <div class="meta-item">
            <strong>ID:</strong> #{{ $tribe->id }}
        </div>
        <div class="meta-item">
            <strong>Created:</strong> {{ $tribe->created_at->format('M d, Y') }}
        </div>
        <div class="meta-item">
            <strong>Last Updated:</strong> {{ $tribe->updated_at->format('M d, Y g:i A') }}
        </div>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('admin.tribes.update', $tribe) }}" id="tribeEditForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Hidden field to signal photo removal --}}
            <input type="hidden" name="remove_photo" id="removePhotoFlag" value="0">

            {{-- Tribe Name --}}
            <div class="form-group">
                <label class="form-label" for="name">Tribe Name <span class="req">*</span></label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $tribe->name) }}"
                    placeholder="e.g. Ifugao, Igorot, Tagbanua..."
                    autocomplete="off"
                    required
                />
                @error('name')
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
                    placeholder="Brief description about the tribe (optional)..."
                    maxlength="1000"
                >{{ old('description', $tribe->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Photo Upload --}}
            <div class="form-group">
                <label class="form-label" for="photo">
                    <i class="fas fa-image" style="color: var(--green-500); margin-right: 4px;"></i>
                    Tribe Photo
                </label>

                {{-- Current photo --}}
                @if($tribe->photo)
                    <div id="currentPhotoSection">
                        <div class="current-photo-label">Current photo:</div>
                        <div class="current-photo-wrap">
                            <img src="{{ asset('storage/' . $tribe->photo) }}" alt="{{ $tribe->name }}" id="currentPhotoImg" />
                        </div>
                        <button type="button" class="btn-remove-current" id="btnRemoveCurrent" onclick="removeCurrent()">
                            <i class="fas fa-trash-alt"></i> Remove photo
                        </button>
                    </div>
                @endif

                {{-- Upload area (hidden if current photo exists and not removed) --}}
                <div class="photo-upload-area {{ $tribe->photo ? 'mt-3' : '' }}" id="photoUploadArea"
                     style="{{ $tribe->photo ? 'display:none;' : '' }}">
                    <input
                        type="file"
                        id="photo"
                        name="photo"
                        accept="image/jpg,image/jpeg,image/png,image/webp"
                        onchange="previewPhoto(this)"
                    />
                    <div class="photo-upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                    <div class="photo-upload-text">
                        <strong>Click to upload</strong> or drag & drop
                    </div>
                    <div class="photo-hint">JPG, PNG, WEBP · max 2 MB</div>
                </div>

                {{-- New photo preview --}}
                <div class="photo-preview-wrap" id="photoPreviewWrap">
                    <img src="" alt="Preview" id="photoPreviewImg" />
                    <button type="button" class="btn-remove-photo" onclick="removeNewPhoto()" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                @error('photo')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label class="form-label">Status</label>
                <div class="toggle-row">
                    <input type="hidden" name="is_active" value="0">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                           {{ old('is_active', $tribe->is_active) ? 'checked' : '' }}>
                    <div>
                        <div class="toggle-label-text">Active</div>
                        <div class="toggle-label-sub">Active tribes appear in applicant forms</div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <button type="submit" class="btn-submit" id="updateTribeBtn">
                    <i class="fas fa-save"></i> Update Tribe
                </button>
                <a href="{{ route('admin.tribes.index') }}" class="btn-cancel">
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

function removeNewPhoto() {
    const wrap  = document.getElementById('photoPreviewWrap');
    const img   = document.getElementById('photoPreviewImg');
    const input = document.getElementById('photo');
    const area  = document.getElementById('photoUploadArea');

    input.value = '';
    img.src = '';
    wrap.classList.remove('show');
    area.style.display = '';
}

function removeCurrent() {
    const section = document.getElementById('currentPhotoSection');
    const area    = document.getElementById('photoUploadArea');
    const flag    = document.getElementById('removePhotoFlag');

    if (section) section.style.display = 'none';
    area.style.display = '';
    flag.value = '1';
}

// Show upload area when "Change photo" is clicked after current removal
const uploadArea = document.getElementById('photoUploadArea');
if (uploadArea) {
    uploadArea.addEventListener('dragover',  () => uploadArea.classList.add('drag-over'));
    uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('drag-over'));
    uploadArea.addEventListener('drop',      () => uploadArea.classList.remove('drag-over'));
}
</script>

@endsection
