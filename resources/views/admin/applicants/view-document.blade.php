@extends('layouts.admin')

@section('title', 'View Document')

@section('content')
<div class="d-flex justify-content-center py-4">
    <div class="document-viewer-wrapper" style="max-width: 900px; width: 100%;">
        
        <!-- Zoom Controls Container -->
        <div class="zoom-controls-panel mb-3 p-3 bg-light rounded shadow-sm">
            <div class="text-center">
                <button class="btn btn-outline-primary me-2 mb-2" onclick="zoomIn()">
                    <i class="fas fa-search-plus me-1"></i> Zoom In
                </button>
                <button class="btn btn-outline-primary me-2 mb-2" onclick="zoomOut()">
                    <i class="fas fa-search-minus me-1"></i> Zoom Out
                </button>
                <button class="btn btn-outline-secondary me-2 mb-2" onclick="resetZoom()">
                    <i class="fas fa-redo me-1"></i> Reset
                </button>
            </div>
            <div class="text-center mt-2">
                <small class="text-primary fw-bold">
                    <i class="fas fa-info-circle me-1"></i> 
                    Ctrl+Scroll or Double-click to zoom • Drag to pan
                </small>
            </div>
        </div>

        <!-- Document Paper Container -->
        <div class="paper-container bg-white shadow-lg rounded p-4" style="border: 1px solid #e0e0e0;">
            <div class="text-center mb-4">
                <h3 class="mb-0">{{ $applicant->first_name }} {{ $applicant->last_name }} - Document</h3>
                <hr class="mx-auto" style="width: 80%; border-top: 2px solid #007bff;">
            </div>

            <div class="document-content text-center">
                @if(in_array($extension, ['jpg','jpeg','png','gif']))
                    <div class="image-zoom-container">
                        <img src="{{ asset('storage/' . $applicant->document_path) }}" 
                             alt="Document" 
                             class="zoomable-image">
                    </div>
                @elseif($extension === 'pdf')
                    <div class="pdf-container mb-3" style="border: 2px solid #f8f9fa; border-radius: 8px; overflow: hidden;">
                        <iframe src="{{ asset('storage/' . $applicant->document_path) }}" 
                                width="100%" 
                                height="600px"
                                style="border: none;"></iframe>
                    </div>
                @else
                    <div class="alert alert-info mb-3" style="background: linear-gradient(135deg, #e3f2fd 0%, #f1f8e9 100%); border: 1px solid #81c784;">
                        <i class="fas fa-file-alt fa-2x mb-2"></i>
                        <p class="mb-2">Cannot preview this file type.</p>
                        <a href="{{ asset('storage/' . $applicant->document_path) }}" 
                           target="_blank" 
                           class="btn btn-outline-primary">
                            <i class="fas fa-download"></i> Download File
                        </a>
                    </div>
                @endif
            </div>

            <div class="text-center mt-4 pt-3" style="border-top: 1px solid #e9ecef;">
                <a href="{{ url()->previous() }}" class="btn btn-secondary px-4 py-2">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.paper-container {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1) !important;
    position: relative;
}

.paper-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #007bff, #28a745, #ffc107, #dc3545);
    border-radius: 8px 8px 0 0;
}

.image-zoom-container {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    width: 100%;
    height: 600px;
    border: 2px solid #f8f9fa;
    cursor: grab;
}

.image-zoom-container.dragging {
    cursor: grabbing;
}

.zoomable-image {
    transition: transform 0.1s ease;
    transform-origin: center center;
    max-width: none;
    max-height: none;
    width: 100%;
    height: 100%;
    object-fit: contain;
    position: absolute;
    top: 0;
    left: 0;
}

.zoomable-image:hover {
    transform: scale(1.05);
}

.zoom-controls-panel {
    background: rgba(248, 249, 250, 0.95);
    backdrop-filter: blur(5px);
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
}

.zoom-controls-panel:hover {
    background: rgba(248, 249, 250, 1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Modal styles removed - no longer needed */
</style>

<script>
let currentZoom = 1;
let currentX = 0;
let currentY = 0;
const zoomStep = 0.2;
const maxZoom = 3;
const minZoom = 0.5;

let isDragging = false;
let startX = 0;
let startY = 0;
let initialX = 0;
let initialY = 0;

function zoomIn() {
    const image = document.querySelector('.zoomable-image');
    if (currentZoom < maxZoom) {
        currentZoom += zoomStep;
        updateImageTransform();
        updateCursor();
    }
}

function zoomOut() {
    const image = document.querySelector('.zoomable-image');
    if (currentZoom > minZoom) {
        currentZoom -= zoomStep;
        // Reset position if zoomed out to original size
        if (currentZoom <= 1) {
            currentX = 0;
            currentY = 0;
        }
        updateImageTransform();
        updateCursor();
    }
}

function resetZoom() {
    currentZoom = 1;
    currentX = 0;
    currentY = 0;
    updateImageTransform();
    updateCursor();
}

function updateImageTransform() {
    const image = document.querySelector('.zoomable-image');
    image.style.transform = `scale(${currentZoom}) translate(${currentX}px, ${currentY}px)`;
}

function updateCursor() {
    const image = document.querySelector('.zoomable-image');
    const container = document.querySelector('.image-zoom-container');
    if (currentZoom > 1) {
        container.style.cursor = 'grab';
        image.style.cursor = 'grab';
    } else {
        container.style.cursor = 'zoom-in';
        image.style.cursor = 'zoom-in';
    }
}

// Initialize all functionality
document.addEventListener('DOMContentLoaded', function() {
    const image = document.querySelector('.zoomable-image');
    const container = document.querySelector('.image-zoom-container');
    
    if (image && container) {
        // Mouse wheel zoom (Ctrl + scroll)
        container.addEventListener('wheel', handleWheelZoom);
        
        // Double click zoom
        let clickCount = 0;
        let clickTimer = null;
        container.addEventListener('click', function(e) {
            clickCount++;
            if (clickCount === 1) {
                clickTimer = setTimeout(function() {
                    // Single click - do nothing now
                    clickCount = 0;
                }, 300);
            } else if (clickCount === 2) {
                // Double click - zoom
                clearTimeout(clickTimer);
                handleDoubleClick(e);
                clickCount = 0;
            }
        });
        
        // Drag functionality
        container.addEventListener('mousedown', startDrag);
        document.addEventListener('mousemove', drag);
        document.addEventListener('mouseup', endDrag);
        
        // Touch events for mobile (includes double tap)
        let touchCount = 0;
        let touchTimer = null;
        container.addEventListener('touchstart', function(e) {
            if (e.touches.length === 1) {
                touchCount++;
                if (touchCount === 1) {
                    touchTimer = setTimeout(function() {
                        // Single touch - start drag if zoomed
                        if (currentZoom > 1) {
                            startDrag({
                                clientX: e.touches[0].clientX,
                                clientY: e.touches[0].clientY,
                                preventDefault: () => e.preventDefault()
                            });
                        }
                        touchCount = 0;
                    }, 300);
                } else if (touchCount === 2) {
                    // Double tap - zoom
                    clearTimeout(touchTimer);
                    handleDoubleClick({
                        clientX: e.touches[0].clientX,
                        clientY: e.touches[0].clientY
                    });
                    touchCount = 0;
                }
            }
        });
        
        container.addEventListener('touchmove', handleTouch);
        container.addEventListener('touchend', handleTouch);
    }
});

function startDrag(e) {
    if (currentZoom <= 1) return; // Only allow drag when zoomed
    
    isDragging = true;
    const container = document.querySelector('.image-zoom-container');
    container.classList.add('dragging');
    
    startX = e.clientX;
    startY = e.clientY;
    initialX = currentX;
    initialY = currentY;
    
    e.preventDefault();
}

function drag(e) {
    if (!isDragging || currentZoom <= 1) return;
    
    e.preventDefault();
    
    const deltaX = (e.clientX - startX) / currentZoom;
    const deltaY = (e.clientY - startY) / currentZoom;
    
    currentX = initialX + deltaX;
    currentY = initialY + deltaY;
    
    // Limit panning to keep image within reasonable bounds
    const maxPan = 200 * (currentZoom - 1);
    currentX = Math.max(-maxPan, Math.min(maxPan, currentX));
    currentY = Math.max(-maxPan, Math.min(maxPan, currentY));
    
    updateImageTransform();
}

function endDrag() {
    isDragging = false;
    const container = document.querySelector('.image-zoom-container');
    container.classList.remove('dragging');
}

// Mouse wheel zoom with Ctrl key
function handleWheelZoom(e) {
    if (e.ctrlKey) {
        e.preventDefault();
        
        const rect = e.currentTarget.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        if (e.deltaY < 0) {
            // Scroll up - zoom in
            zoomAtPoint(x, y, zoomStep);
        } else {
            // Scroll down - zoom out  
            zoomAtPoint(x, y, -zoomStep);
        }
    }
}

// Double click/tap zoom
function handleDoubleClick(e) {
    const rect = document.querySelector('.image-zoom-container').getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    
    if (currentZoom === 1) {
        // Zoom in to 2x at click point
        zoomAtPoint(x, y, 1);
    } else {
        // Reset zoom
        resetZoom();
    }
}

// Zoom at specific point (like native browser zoom)
function zoomAtPoint(x, y, zoomDelta) {
    const container = document.querySelector('.image-zoom-container');
    const containerRect = container.getBoundingClientRect();
    const containerCenterX = containerRect.width / 2;
    const containerCenterY = containerRect.height / 2;
    
    const oldZoom = currentZoom;
    const newZoom = Math.max(minZoom, Math.min(maxZoom, currentZoom + zoomDelta));
    
    if (newZoom !== currentZoom) {
        currentZoom = newZoom;
        
        // Calculate zoom offset based on click point
        const zoomRatio = newZoom / oldZoom;
        const offsetX = (x - containerCenterX) * (1 - zoomRatio);
        const offsetY = (y - containerCenterY) * (1 - zoomRatio);
        
        currentX = (currentX + offsetX / oldZoom);
        currentY = (currentY + offsetY / oldZoom);
        
        // Reset position if zoomed out to original size
        if (currentZoom <= 1) {
            currentX = 0;
            currentY = 0;
        } else {
            // Limit panning to keep image within reasonable bounds
            const maxPan = 200 * (currentZoom - 1);
            currentX = Math.max(-maxPan, Math.min(maxPan, currentX));
            currentY = Math.max(-maxPan, Math.min(maxPan, currentY));
        }
        
        updateImageTransform();
        updateCursor();
    }
}

// Touch handling for mobile devices
function handleTouch(e) {
    if (currentZoom <= 1) return;
    
    switch(e.type) {
        case 'touchmove':
            if (e.touches.length === 1) {
                drag({
                    clientX: e.touches[0].clientX,
                    clientY: e.touches[0].clientY,
                    preventDefault: () => e.preventDefault()
                });
            }
            break;
        case 'touchend':
            endDrag();
            break;
    }
}
</script>
@endsection
