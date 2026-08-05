@extends('layouts.admin')

@section('title', 'Add Accomplishment')

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

.page-header { margin-bottom: 24px; display: flex; align-items: center; gap: 10px; }
.page-header h2 {
    font-size: 24px; font-weight: 700; color: var(--text-dark);
    display: flex; align-items: center; gap: 10px; letter-spacing: -0.3px;
}
.header-icon {
    width: 38px; height: 38px; background: var(--green-500); color: #fff;
    border-radius: var(--radius-sm); display: grid; place-items: center;
    font-size: 16px; flex-shrink: 0;
}
.back-link {
    display: inline-flex; align-items: center; gap: 6px;
    color: var(--text-soft); text-decoration: none; font-size: 13px;
    font-weight: 500; margin-bottom: 16px; transition: color 0.18s;
}
.back-link:hover { color: var(--green-500); }

.form-card {
    background: var(--white); border-radius: var(--radius-md);
    border: 1px solid var(--sand-200); box-shadow: var(--shadow-sm);
    padding: 30px 32px; max-width: 780px;
}
.form-label {
    font-size: 13.5px; font-weight: 600; color: var(--text-dark);
    margin-bottom: 6px; display: block;
}
.form-label .req { color: #dc2626; margin-left: 2px; }
.form-control, .form-select {
    width: 100%; padding: 10px 14px;
    border: 1.5px solid var(--sand-200); border-radius: var(--radius-sm);
    font-family: 'Poppins', sans-serif; font-size: 13.5px; color: var(--text-dark);
    background: var(--sand-100); transition: border-color 0.2s, box-shadow 0.2s; outline: none;
}
.form-control:focus, .form-select:focus {
    border-color: var(--green-400); background: var(--white);
    box-shadow: 0 0 0 3px rgba(62,123,39,0.10);
}
textarea.form-control { resize: vertical; min-height: 110px; }
.is-invalid { border-color: #dc2626 !important; }
.invalid-feedback { font-size: 12px; color: #dc2626; margin-top: 4px; }
.form-group { margin-bottom: 20px; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

/* Photo upload */
.photo-upload-area {
    border: 2px dashed var(--sand-200); border-radius: var(--radius-sm);
    padding: 24px 20px; text-align: center; background: var(--sand-100);
    cursor: pointer; transition: border-color 0.2s, background 0.2s; position: relative;
}
.photo-upload-area:hover, .photo-upload-area.drag-over {
    border-color: var(--green-400); background: var(--green-50);
}
.photo-upload-area input[type="file"] {
    position: absolute; inset: 0; width: 100%; height: 100%;
    opacity: 0; cursor: pointer; z-index: 2;
}
.photo-upload-icon { font-size: 32px; color: var(--text-soft); margin-bottom: 8px; }
.photo-upload-text { font-size: 13px; color: var(--text-soft); }
.photo-upload-text strong { color: var(--green-500); }
.photo-hint { font-size: 11.5px; color: var(--text-soft); margin-top: 4px; }
.photo-preview-wrap { display: none; position: relative; margin-top: 12px; }
.photo-preview-wrap img {
    width: 100%; max-height: 220px; object-fit: cover;
    border-radius: var(--radius-sm); border: 1.5px solid var(--sand-200);
}
.photo-preview-wrap.show { display: block; }
.btn-remove-photo {
    position: absolute; top: 8px; right: 8px;
    background: rgba(0,0,0,0.55); color: #fff; border: none;
    border-radius: 50%; width: 28px; height: 28px; font-size: 13px;
    cursor: pointer; display: grid; place-items: center; transition: background 0.18s; z-index: 5;
}
.btn-remove-photo:hover { background: #dc2626; }

/* Extra images preview */
.extra-preview-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 8px; margin-top: 10px;
}
.extra-preview-grid img {
    width: 100%; height: 80px; object-fit: cover;
    border-radius: 6px; border: 1.5px solid var(--sand-200);
}

/* Layout selector */
.layout-options {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 10px;
}
.layout-option { position: relative; }
.layout-option input[type="radio"] { position: absolute; opacity: 0; }
.layout-option label {
    display: flex; flex-direction: column; align-items: center; gap: 8px;
    padding: 14px 10px; border: 2px solid var(--sand-200); border-radius: var(--radius-sm);
    cursor: pointer; transition: all 0.18s; background: var(--sand-100);
    font-size: 12.5px; font-weight: 600; color: var(--text-mid); text-align: center;
}
.layout-option label i { font-size: 22px; color: var(--text-soft); }
.layout-option input[type="radio"]:checked + label {
    border-color: var(--green-500); background: var(--green-50); color: var(--green-500);
}
.layout-option input[type="radio"]:checked + label i { color: var(--green-500); }

/* Toggle */
.toggle-row {
    display: flex; align-items: center; gap: 14px; padding: 14px 16px;
    background: var(--sand-100); border-radius: var(--radius-sm); border: 1.5px solid var(--sand-200);
}
.toggle-label-text { font-size: 13.5px; font-weight: 600; color: var(--text-dark); }
.toggle-label-sub  { font-size: 12px; color: var(--text-soft); }
.form-check-input {
    width: 44px; height: 24px; cursor: pointer; background-color: #ccc;
    border: none; border-radius: 20px; transition: background-color 0.2s; flex-shrink: 0;
}
.form-check-input:checked { background-color: var(--green-500); }

/* Buttons */
.btn-submit {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 24px; background: var(--green-500); color: #fff;
    border: none; border-radius: var(--radius-sm); font-family: 'Poppins', sans-serif;
    font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.18s;
    box-shadow: 0 2px 8px rgba(46,125,70,0.25);
}
.btn-submit:hover { background: #1a5c30; transform: translateY(-1px); }
.btn-cancel {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 20px; background: var(--white); color: var(--text-mid);
    border: 1.5px solid var(--sand-200); border-radius: var(--radius-sm);
    font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 600;
    text-decoration: none; cursor: pointer; transition: all 0.18s;
}
.btn-cancel:hover { border-color: var(--green-400); color: var(--green-500); background: var(--green-50); }
.form-actions {
    display: flex; align-items: center; gap: 12px;
    margin-top: 28px; padding-top: 22px; border-top: 1px solid var(--sand-200);
}
.section-divider {
    margin: 24px 0 16px;
    font-size: 12px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.8px; color: var(--text-soft);
    border-bottom: 1px solid var(--sand-200); padding-bottom: 8px;
}
</style>

<div>
    <a href="{{ route('admin.accomplishments.index') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Accomplishments
    </a>

    <div class="page-header">
        <h2>
            <span class="header-icon"><i class="fas fa-plus"></i></span>
            Add New Accomplishment
        </h2>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('admin.accomplishments.store') }}" id="accCreateForm" enctype="multipart/form-data">
            @csrf

            {{-- Title --}}
            <div class="form-group">
                <label class="form-label" for="title">Title <span class="req">*</span></label>
                <input type="text" id="title" name="title"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') }}"
                    placeholder="e.g. CLSU Partnership for IP"
                    autocomplete="off" required />
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Description --}}
            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea id="description" name="description"
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="Full accomplishment description...">{{ old('description') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Date + Year Row --}}
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="date_label">Date Label</label>
                    <input type="text" id="date_label" name="date_label"
                        class="form-control @error('date_label') is-invalid @enderror"
                        value="{{ old('date_label') }}"
                        placeholder="e.g. May 7, 2025" />
                    @error('date_label') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="year_group">Year Group</label>
                    <input type="text" id="year_group" name="year_group"
                        class="form-control @error('year_group') is-invalid @enderror"
                        value="{{ old('year_group') }}"
                        placeholder="e.g. 2025" maxlength="20" />
                    @error('year_group') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Sort Order --}}
            <div class="form-group">
                <label class="form-label" for="sort_order">Sort Order</label>
                <input type="number" id="sort_order" name="sort_order"
                    class="form-control @error('sort_order') is-invalid @enderror"
                    value="{{ old('sort_order', 0) }}" min="0" style="max-width: 120px;" />
                @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="section-divider">Layout Type</div>

            {{-- Layout Type --}}
            <div class="form-group">
                <div class="layout-options">
                    <div class="layout-option">
                        <input type="radio" id="layout_1" name="layout_type" value="1"
                               {{ old('layout_type', '1') == '1' ? 'checked' : '' }}>
                        <label for="layout_1">
                            <i class="fas fa-columns"></i>
                            Left Image
                        </label>
                    </div>
                    <div class="layout-option">
                        <input type="radio" id="layout_2" name="layout_type" value="2"
                               {{ old('layout_type') == '2' ? 'checked' : '' }}>
                        <label for="layout_2">
                            <i class="fas fa-columns fa-flip-horizontal"></i>
                            Right Image
                        </label>
                    </div>
                    <div class="layout-option">
                        <input type="radio" id="layout_4" name="layout_type" value="4"
                               {{ old('layout_type') == '4' ? 'checked' : '' }}>
                        <label for="layout_4">
                            <i class="fas fa-credit-card"></i>
                            Card (Overlay)
                        </label>
                    </div>
                    <div class="layout-option">
                        <input type="radio" id="layout_5" name="layout_type" value="5"
                               {{ old('layout_type') == '5' ? 'checked' : '' }}>
                        <label for="layout_5">
                            <i class="fas fa-th"></i>
                            Image Grid
                        </label>
                    </div>
                </div>
                @error('layout_type') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="section-divider">Images</div>

            {{-- Main Image --}}
            <div class="form-group">
                <label class="form-label" for="image">
                    <i class="fas fa-image" style="color: var(--green-500); margin-right: 4px;"></i>
                    Main Image
                </label>
                <div class="photo-upload-area" id="photoUploadArea">
                    <input type="file" id="image" name="image"
                        accept="image/jpg,image/jpeg,image/png,image/webp"
                        onchange="previewMain(this)" />
                    <div class="photo-upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                    <div class="photo-upload-text"><strong>Click to upload</strong> or drag & drop</div>
                    <div class="photo-hint">JPG, PNG, WEBP · max 4 MB</div>
                </div>
                <div class="photo-preview-wrap" id="mainPreviewWrap">
                    <img src="" alt="Preview" id="mainPreviewImg" />
                    <button type="button" class="btn-remove-photo" onclick="removeMain()" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            {{-- Extra Images (layout 5) --}}
            <div class="form-group" id="extraImagesGroup">
                <label class="form-label" for="extra_images">
                    <i class="fas fa-images" style="color: var(--green-500); margin-right: 4px;"></i>
                    Extra Images <span style="font-weight:400; color: var(--text-soft);">(for Grid layout — up to 4)</span>
                </label>
                <div class="photo-upload-area">
                    <input type="file" id="extra_images" name="extra_images[]"
                        accept="image/jpg,image/jpeg,image/png,image/webp"
                        multiple onchange="previewExtras(this)" />
                    <div class="photo-upload-icon"><i class="fas fa-images"></i></div>
                    <div class="photo-upload-text"><strong>Click to upload</strong> multiple images</div>
                    <div class="photo-hint">JPG, PNG, WEBP · max 4 MB each · max 4 files</div>
                </div>
                <div class="extra-preview-grid" id="extraPreviewGrid"></div>
                @error('extra_images') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="section-divider">Visibility</div>

            {{-- Status --}}
            <div class="form-group">
                <label class="form-label">Status</label>
                <div class="toggle-row">
                    <input type="hidden" name="is_active" value="0">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                           {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                    <div>
                        <div class="toggle-label-text">Active</div>
                        <div class="toggle-label-sub">Active accomplishments appear on the public page</div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <button type="submit" class="btn-submit" id="submitAccBtn">
                    <i class="fas fa-save"></i> Save Accomplishment
                </button>
                <a href="{{ route('admin.accomplishments.index') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function previewMain(input) {
    const wrap = document.getElementById('mainPreviewWrap');
    const img  = document.getElementById('mainPreviewImg');
    const area = document.getElementById('photoUploadArea');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            wrap.classList.add('show');
            area.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeMain() {
    document.getElementById('mainPreviewWrap').classList.remove('show');
    document.getElementById('mainPreviewImg').src = '';
    document.getElementById('image').value = '';
    document.getElementById('photoUploadArea').style.display = '';
}

function previewExtras(input) {
    const grid = document.getElementById('extraPreviewGrid');
    grid.innerHTML = '';
    if (input.files) {
        Array.from(input.files).slice(0, 4).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                grid.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
}

// Show/hide extra images group based on layout selection
document.querySelectorAll('input[name="layout_type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('extraImagesGroup').style.opacity = this.value === '5' ? '1' : '0.45';
    });
});
// Init
const currentLayout = document.querySelector('input[name="layout_type"]:checked');
if (currentLayout) {
    document.getElementById('extraImagesGroup').style.opacity = currentLayout.value === '5' ? '1' : '0.45';
}

// Drag & drop
const uploadArea = document.getElementById('photoUploadArea');
if (uploadArea) {
    uploadArea.addEventListener('dragover',  () => uploadArea.classList.add('drag-over'));
    uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('drag-over'));
    uploadArea.addEventListener('drop',      () => uploadArea.classList.remove('drag-over'));
}
</script>

@endsection
