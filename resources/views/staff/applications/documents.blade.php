<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/staff.css') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        @yield('content')
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<div class="documents-preview">
    <div class="preview-header">
        <div class="header-content">
            <div class="icon-wrapper">
                <i class="fas fa-folder-open"></i>
            </div>
            <div class="header-text">
                <h5 class="mb-1">Uploaded Documents</h5>
                <p class="mb-0 text-muted">Review and download application documents</p>
            </div>
        </div>
    </div>
    
    <div class="documents-grid">
        {{-- Applicant Photo --}}
        <div class="doc-card">
            <div class="doc-header">
                <div class="doc-icon photo-icon">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="doc-info">
                    <h6 class="doc-title">Applicant Photo</h6>
                    <p class="doc-subtitle">Profile picture</p>
                </div>
                <div class="doc-status">
                    @if(!empty($application->applicant_picture))
                        <span class="status-badge uploaded">
                            <i class="fas fa-check-circle"></i>
                        </span>
                    @else
                        <span class="status-badge missing">
                            <i class="fas fa-times-circle"></i>
                        </span>
                    @endif
                </div>
            </div>
            <div class="doc-actions">
                @if(!empty($application->applicant_picture))
                    <a href="{{ asset('storage/'.$application->applicant_picture) }}" target="_blank" class="action-btn view-btn">
                        <i class="fas fa-eye"></i>
                        <span>View</span>
                    </a>
                    <a href="{{ asset('storage/'.$application->applicant_picture) }}" download class="action-btn download-btn">
                        <i class="fas fa-download"></i>
                        <span>Download</span>
                    </a>
                @else
                    <div class="empty-state">
                        <i class="fas fa-image text-muted"></i>
                        <span class="text-muted">No photo uploaded</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Birth Certificate --}}
        <div class="doc-card">
            <div class="doc-header">
                <div class="doc-icon certificate-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <div class="doc-info">
                    <h6 class="doc-title">Birth Certificate</h6>
                    <p class="doc-subtitle">Official document</p>
                </div>
                <div class="doc-status">
                    @if(!empty($application->birth_certificate) || ($ipAccount && !empty($ipAccount->document_path)))
                        <span class="status-badge uploaded">
                            <i class="fas fa-check-circle"></i>
                        </span>
                    @else
                        <span class="status-badge missing">
                            <i class="fas fa-times-circle"></i>
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="doc-actions">
                @php
                    $birthCertificatePath = $application->birth_certificate ?: ($ipAccount->document_path ?? null);
                @endphp
                @if($birthCertificatePath)
                    <a href="{{ asset('storage/' . $birthCertificatePath) }}" target="_blank" class="action-btn view-btn">
                        <i class="fas fa-eye"></i>
                        <span>View</span>
                    </a>
                    <a href="{{ asset('storage/' . $birthCertificatePath) }}" download class="action-btn download-btn">
                        <i class="fas fa-download"></i>
                        <span>Download</span>
                    </a>
                @else
                    <div class="empty-state">
                        <i class="fas fa-file-alt text-muted"></i>
                        <span class="text-muted">No certificate uploaded</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Signature section removed --}}

        {{-- Tribal Certificate --}}
        <div class="doc-card">
            <div class="doc-header">
                <div class="doc-icon tribal-icon">
                    <i class="fas fa-scroll"></i>
                </div>
                <div class="doc-info">
                    <h6 class="doc-title">Certificate of Tribal Chieftain</h6>
                    <p class="doc-subtitle">Tribal documentation</p>
                </div>
                <div class="doc-status">
                    @if(!empty($application->tribal_certificate))
                        <span class="status-badge uploaded">
                            <i class="fas fa-check-circle"></i>
                        </span>
                    @else
                        <span class="status-badge missing">
                            <i class="fas fa-times-circle"></i>
                        </span>
                    @endif
                </div>
            </div>
            <div class="doc-actions">
                @if(!empty($application->tribal_certificate))
                    <a href="{{ asset('storage/'.$application->tribal_certificate) }}" target="_blank" class="action-btn view-btn">
                        <i class="fas fa-eye"></i>
                        <span>View</span>
                    </a>
                    <a href="{{ asset('storage/'.$application->tribal_certificate) }}" download class="action-btn download-btn">
                        <i class="fas fa-download"></i>
                        <span>Download</span>
                    </a>
                @else
                    <div class="empty-state">
                        <i class="fas fa-scroll text-muted"></i>
                        <span class="text-muted">No certificate uploaded</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Genealogy Form --}}
        <div class="doc-card">
            <div class="doc-header">
                <div class="doc-icon genealogy-icon">
                    <i class="fas fa-sitemap"></i>
                </div>
                <div class="doc-info">
                    <h6 class="doc-title">Completed Genealogy Form</h6>
                    <p class="doc-subtitle">Family tree documentation</p>
                </div>
                <div class="doc-status">
                    @if(!empty($application->genealogy_form))
                        <span class="status-badge uploaded">
                            <i class="fas fa-check-circle"></i>
                        </span>
                        {{-- File info badge --}}
                        @php
                            $fileExtension = pathinfo($application->genealogy_form, PATHINFO_EXTENSION);
                            $fileType = strtoupper($fileExtension);
                        @endphp
                        <span class="file-type-badge">{{ $fileType }}</span>
                    @else
                        <span class="status-badge missing">
                            <i class="fas fa-times-circle"></i>
                        </span>
                    @endif
                </div>
            </div>
            <div class="doc-actions">
                @if(!empty($application->genealogy_form))
                    <a href="{{ asset('storage/'.$application->genealogy_form) }}" target="_blank" class="action-btn view-btn">
                        <i class="fas fa-eye"></i>
                        <span>View</span>
                    </a>
                    <a href="{{ asset('storage/'.$application->genealogy_form) }}" download class="action-btn download-btn">
                        <i class="fas fa-download"></i>
                        <span>Download</span>
                    </a>
                @else
                    <div class="empty-state">
                        <i class="fas fa-sitemap text-muted"></i>
                        <span class="text-muted">No genealogy form uploaded</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @php
        $versionGroups = $application->documentVersions->groupBy('document_type');
        $versionLabels = [
            'applicant_picture' => 'Applicant Photo',
            'birth_certificate' => 'Birth Certificate',
            'tribal_certificate' => 'Tribal Certificate',
            'genealogy_form' => 'Genealogy Form',
        ];
    @endphp
    @if($versionGroups->isNotEmpty())
        <div class="revision-history">
            <h6 class="revision-title"><i class="fas fa-clock-rotate-left"></i>Document Revision History</h6>
            <p class="revision-subtitle">Previous uploads are retained for comparison.</p>

            @foreach($versionGroups as $type => $versions)
                <div class="revision-group">
                    <strong class="revision-group-title">{{ $versionLabels[$type] ?? Str::headline($type) }} <small>{{ $versions->count() }} {{ Str::plural('version', $versions->count()) }}</small></strong>
                    <div class="revision-list">
                        @foreach($versions as $version)
                            <div class="revision-item {{ $loop->first ? 'current' : '' }}">
                                <div>
                                    <span class="badge {{ $loop->first ? 'bg-success' : 'bg-secondary' }} me-2">
                                        Revision {{ $version->revision }}{{ $loop->first ? ' · Current' : '' }}
                                    </span>
                                    <span>{{ $version->original_name ?: basename($version->path) }}</span>
                                    <small class="text-muted d-block mt-1">
                                        {{ $version->created_at->format('M d, Y g:i A') }}
                                        @if($version->file_size) · {{ number_format($version->file_size / 1024, 1) }} KB @endif
                                    </small>
                                </div>
                                <div class="revision-actions">
                                    <a class="revision-button view" href="{{ asset('storage/'.$version->path) }}" target="_blank">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a class="revision-button download" href="{{ asset('storage/'.$version->path) }}" download>
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Document Status Summary --}}
    @if(isset($application) && in_array($application->status, ['Under Review', 'Returned']))
    <div class="status-summary">
        <div class="summary-header">
            <div class="summary-icon">
                <i class="fas fa-chart-pie"></i>
            </div>
            <div class="summary-content">
                <h6 class="summary-title">Document Completion Status</h6>
                <p class="summary-subtitle">Track your application progress</p>
            </div>
        </div>
        
        <div class="progress-container">
            @php
                $totalDocs = 4; // Updated: removed signature from count
                $uploadedDocs = 0;
                if (!empty($application->applicant_picture)) $uploadedDocs++;
                if (!empty($application->birth_certificate) || ($ipAccount && !empty($ipAccount->document_path))) $uploadedDocs++;
                if (!empty($application->tribal_certificate)) $uploadedDocs++;
                if (!empty($application->genealogy_form)) $uploadedDocs++;
                $percentage = ($uploadedDocs / $totalDocs) * 100;
            @endphp
            
            <div class="progress-info">
                <span class="progress-text">{{ $uploadedDocs }} of {{ $totalDocs }} documents uploaded</span>
                <span class="progress-percentage">{{ number_format($percentage, 0) }}%</span>
            </div>
            <div class="progress-bar-container">
                <div class="progress-bar-fill" style="width: {{ $percentage }}%"></div>
            </div>
        </div>

        <div class="status-grid">
            <div class="status-item">
                <div class="status-icon {{ !empty($application->applicant_picture) ? 'uploaded' : 'missing' }}">
                    <i class="fas {{ !empty($application->applicant_picture) ? 'fa-check' : 'fa-times' }}"></i>
                </div>
                <span class="status-label">Applicant Photo</span>
            </div>
            
            <div class="status-item">
                <div class="status-icon {{ (!empty($application->birth_certificate) || ($ipAccount && !empty($ipAccount->document_path))) ? 'uploaded' : 'missing' }}">
                    <i class="fas {{ (!empty($application->birth_certificate) || ($ipAccount && !empty($ipAccount->document_path))) ? 'fa-check' : 'fa-times' }}"></i>
                </div>
                <span class="status-label">Birth Certificate</span>
            </div>
            
            {{-- Signature status item removed --}}
            
            <div class="status-item">
                <div class="status-icon {{ !empty($application->tribal_certificate) ? 'uploaded' : 'missing' }}">
                    <i class="fas {{ !empty($application->tribal_certificate) ? 'fa-check' : 'fa-times' }}"></i>
                </div>
                <span class="status-label">Tribal Certificate</span>
            </div>
            
            <div class="status-item">
                <div class="status-icon {{ !empty($application->genealogy_form) ? 'uploaded' : 'missing' }}">
                    <i class="fas {{ !empty($application->genealogy_form) ? 'fa-check' : 'fa-times' }}"></i>
                </div>
                <span class="status-label">Genealogy Form</span>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.revision-history{margin:0 30px 30px;padding:24px;background:#fff;border:1px solid #dfe8da;border-radius:14px;box-shadow:0 3px 12px rgba(43,78,31,.07);position:relative}.revision-history:before{content:'';position:absolute;top:0;left:24px;right:24px;height:3px;background:#3e7b27;border-radius:0 0 3px 3px}.revision-title{display:flex;align-items:center;gap:10px;margin:0 0 4px!important;color:#222!important;font-size:1.08rem!important;font-weight:700}.revision-title i{width:38px;height:38px;border-radius:10px;background:#3e7b27;color:#fff;display:grid;place-items:center;font-size:15px}.revision-subtitle{margin:0 0 20px 48px;color:#718096;font-size:.82rem}.revision-group{margin-top:18px}.revision-group-title{display:flex;justify-content:space-between;align-items:center;color:#3e7b27;font-size:.88rem;margin-bottom:8px}.revision-group-title small{color:#7b8477;background:#f2f5f0;padding:4px 9px;border-radius:20px;font-size:.68rem}.revision-list{border:1px solid #e4e9e1;border-radius:10px;overflow:hidden}.revision-item{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:13px 15px;background:#fff;border-bottom:1px solid #edf0eb}.revision-item:last-child{border-bottom:0}.revision-item.current{background:#f5faf2;border-left:3px solid #3e7b27}.revision-item .badge{border-radius:20px!important;font-size:.65rem!important;padding:5px 9px!important}.revision-item>div:first-child>span:not(.badge){color:#30362d;font-size:.83rem;font-weight:600}.revision-item small{color:#8a9186!important;font-size:.7rem}.revision-actions{display:flex;gap:7px}.revision-button{display:inline-flex;align-items:center;gap:5px;padding:7px 10px;border-radius:7px;text-decoration:none;font-size:.72rem;font-weight:600;transition:.2s}.revision-button.view{background:#3e7b27;color:#fff}.revision-button.view:hover{background:#245524;color:#fff}.revision-button.download{border:1px solid #cbd5c7;color:#586452;background:#fff}.revision-button.download:hover{border-color:#3e7b27;color:#3e7b27}@media(max-width:576px){.revision-history{margin:0 15px 20px;padding:18px}.revision-subtitle{margin-left:0}.revision-item{align-items:flex-start;flex-direction:column}.revision-actions{width:100%}.revision-button.view{flex:1;justify-content:center}}
/* Main Container */
.documents-preview {
    background: #fff !important;
    border-radius: 24px;
    padding: 0;
    margin-bottom: 30px;
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
    overflow: hidden;
    position: relative;
}

.documents-preview::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
    pointer-events: none;
}

/* Header Section */
.preview-header {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    padding: 25px 30px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
}

.header-content {
    display: flex;
    align-items: center;
    gap: 20px;
}

.icon-wrapper {
    width: 60px;
    height: 60px;
    background: #fff;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e5e5e5;

}

.icon-wrapper i {
    font-size: 24px;
    color: #3e7b27;;
}

.header-text h5 {
    color: #2d3748;
    font-weight: 700;
    font-size: 1.5rem;
    margin: 0;
}

.header-text p {
    color: #718096;
    font-size: 0.95rem;
    margin: 0;
}

/* Documents Grid */
.documents-grid {
    padding: 30px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    background: #fff;
}

/* Document Cards */
.doc-card {
    background: #fff;
    backdrop-filter: blur(20px);
    border-radius: 10px;
    padding: 25px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
    border: 1px solid #3e7b27;
}


.doc-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background:  #3e7b27;
    transform: scaleY(0);
    transition: transform 0.3s ease;
}

.doc-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.2);
}

.doc-card:hover::before {
    transform: scaleY(1);
}

/* Document Header */
.doc-header {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 20px;
}

.doc-icon {
    width: 50px;
    height: 50px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
    flex-shrink: 0;
}

.photo-icon { background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); }
.certificate-icon { background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%); }
/* Signature icon CSS removed */
.tribal-icon { background: linear-gradient(135deg, #f39c12 0%, #d35400 100%); }
.genealogy-icon { background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%); }

.doc-info {
    flex: 1;
}

.doc-title {
    color: #3e7b27 !important;
    font-weight: 600;
    font-size: 1.1rem;
    margin: 0 0 5px 0;
    line-height: 1.3;
}

.doc-subtitle {
    color: #000000;
    font-size: 0.85rem;
    margin: 0;
}

.doc-status {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 8px;
}

.status-badge {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}

.status-badge.uploaded {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
}

.status-badge.missing {
    background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
    color: white;
}

.file-type-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 4px 8px;
    border-radius: 8px;
    font-size: 0.7rem;
    font-weight: 600;
}

/* Document Actions */
.doc-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 12px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
}

.view-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.view-btn:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.download-btn {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
}

.download-btn:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(72, 187, 120, 0.3);
}

.empty-state {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px;
    background: rgba(247, 250, 252, 0.8);
    border-radius: 12px;
    border: 2px dashed #cbd5e0;
}

.empty-state i {
    font-size: 18px;
}

.empty-state span {
    font-size: 0.9rem;
    font-weight: 500;
}

/* Status Summary */
.status-summary {
    background: #ffffff !important;
    backdrop-filter: blur(20px);
    margin: 0 30px 30px 30px;
    border-radius: 20px;
    padding: 25px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.summary-header {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 25px;
}

.summary-icon {
    width: 50px;
    height: 50px;
    background: #3e7b27;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.summary-title {
    color: #000000;
    font-weight: 600;
    font-size: 1.2rem;
    margin: 0;
}

.summary-subtitle {
    color: #222;
    font-size: 0.9rem;
    margin: 0;
}

/* Progress Container */
.progress-container {
    margin-bottom: 25px;
}

.progress-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.progress-text {
    color: #222;
    font-weight: 500;
}

.progress-percentage {
    color: #3e7b27;
    font-weight: 700;
    font-size: 1.1rem;
}

.progress-bar-container {
    height: 10px;
    background: rgba(226, 232, 240, 0.8);
    border-radius: 20px;
    overflow: hidden;
}

.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #3e7b27 0%, #66bb4f 100%);
    border-radius: 20px;
    transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.progress-bar-fill::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.4) 50%, transparent 100%);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

/* Status Grid */
.status-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
}

.status-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 15px;
    background: rgba(247, 250, 252, 0.6);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.status-item:hover {
    background: rgba(247, 250, 252, 0.9);
    transform: translateY(-2px);
}

.status-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 600;
}

.status-icon.uploaded {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
}

.status-icon.missing {
    background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
    color: white;
}

.status-label {
    color: #4a5568;
    font-weight: 500;
    font-size: 0.9rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .documents-preview {
        border-radius: 20px;
        margin-bottom: 20px;
    }
    
    .preview-header {
        padding: 20px;
    }
    
    .header-content {
        gap: 15px;
    }
    
    .icon-wrapper {
        width: 50px;
        height: 50px;
    }
    
    .icon-wrapper i {
        font-size: 20px;
    }
    
    .header-text h5 {
        font-size: 1.3rem;
    }
    
    .documents-grid {
        grid-template-columns: 1fr;
        padding: 20px;
        gap: 16px;
    }
    
    .doc-card {
        padding: 20px;
    }
    
    .doc-header {
        gap: 12px;
    }
    
    .doc-icon {
        width: 42px;
        height: 42px;
        font-size: 18px;
    }
    
    .doc-title {
        font-size: 1rem;
    }
    
    .doc-actions {
        flex-direction: column;
        gap: 8px;
    }
    
    .action-btn {
        justify-content: center;
        padding: 12px 16px;
    }
    
    .status-summary {
        margin: 0 20px 20px 20px;
        padding: 20px;
    }
    
    .status-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    
    .summary-header {
        gap: 15px;
    }
    
    .summary-icon {
        width: 42px;
        height: 42px;
        font-size: 18px;
    }
}

@media (max-width: 480px) {
    .documents-grid {
        padding: 15px;
    }
    
    .doc-card {
        padding: 16px;
    }
    
    .status-summary {
        margin: 0 15px 15px 15px;
        padding: 16px;
    }
}
</style>
