@extends('layouts.applicant')
@section('title', __('Uploaded Documents'))
@section('page-title', __('Uploaded Documents'))

@section('content')
<style>
.documents-panel {
    width: min(960px, 95%);
    margin: clamp(2rem, 4vw, 3rem) auto 8rem;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.documents-header {
    background: #3e7b27;
    color: #fff;
    padding: 1.1rem 1.4rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}

.documents-title {
    display: flex;
    align-items: center;
    gap: 0.65rem;
}

.documents-title h2 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
}

.application-number {
    margin: 0.2rem 0 0;
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.85);
}

.back-link {
    min-height: 36px;
    padding: 0.45rem 0.75rem;
    border: 1px solid rgba(255, 255, 255, 0.75);
    border-radius: 6px;
    color: #fff;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
}

.back-link:hover,
.back-link:focus {
    background: #fff;
    color: #2f5f1e;
}

.documents-body {
    padding: clamp(1rem, 3vw, 1.5rem);
}

.documents-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1rem;
}

.document-item {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 1rem;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 0.85rem;
}

.document-item.missing {
    background: #f9fafb;
}

.document-heading {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.document-icon {
    width: 40px;
    height: 40px;
    flex: 0 0 40px;
    border-radius: 6px;
    background: #edf5e9;
    color: #3e7b27;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.document-name {
    margin: 0;
    color: #1f2937;
    font-size: 0.95rem;
    font-weight: 600;
}

.document-file {
    margin: 0.2rem 0 0;
    color: #6b7280;
    font-size: 0.78rem;
    overflow-wrap: anywhere;
}

.document-status {
    margin-top: auto;
    min-height: 36px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    padding: 0.45rem 0.7rem;
    font-size: 0.85rem;
    font-weight: 600;
}

a.document-status {
    background: #3e7b27;
    color: #fff;
    text-decoration: none;
}

a.document-status:hover,
a.document-status:focus {
    background: #2f5f1e;
    color: #fff;
}

span.document-status {
    background: #f3f4f6;
    color: #6b7280;
}

@media (max-width: 768px) {
    .documents-panel {
        width: 100%;
        margin-top: 5.5rem;
    }

    .documents-grid {
        grid-template-columns: 1fr;
    }
}
</style>

@php
    $documentDefinitions = [
        'applicant_picture' => ['label' => __('Applicant Photo'), 'icon' => 'fa-user'],
        'tribal_certificate' => ['label' => __('Tribal Certificate'), 'icon' => 'fa-file-contract'],
        'genealogy_form' => ['label' => __('Genealogy Form'), 'icon' => 'fa-sitemap'],
    ];
@endphp

<section class="documents-panel" aria-labelledby="documents-title">
    <header class="documents-header">
        <div class="documents-title">
            <i class="fas fa-folder-open" aria-hidden="true"></i>
            <div>
                <h2 id="documents-title">{{ __('Uploaded Documents') }}</h2>
                <p class="application-number">{{ __('Application No.') }} {{ $application->id }}</p>
            </div>
        </div>
        <a href="{{ route('applicant.history') }}" class="back-link">
            <i class="fas fa-arrow-left" aria-hidden="true"></i>
            <span>{{ __('Back to History') }}</span>
        </a>
    </header>

    <div class="documents-body">
        <div class="documents-grid">
            @foreach($documentDefinitions as $key => $definition)
                @php($uploadedDocument = $documents[$key] ?? null)
                <article class="document-item {{ $uploadedDocument ? '' : 'missing' }}">
                    <div class="document-heading">
                        <span class="document-icon">
                            <i class="fas {{ $definition['icon'] }}" aria-hidden="true"></i>
                        </span>
                        <div>
                            <h3 class="document-name">{{ $definition['label'] }}</h3>
                            <p class="document-file">
                                {{ $uploadedDocument ? $uploadedDocument['filename'] . ' (' . $uploadedDocument['type'] . ')' : __('Not uploaded') }}
                            </p>
                        </div>
                    </div>

                    @if($uploadedDocument)
                        <a href="{{ route('applicant.history.documents.view', [$application, $key]) }}"
                           target="_blank"
                           rel="noopener"
                           class="document-status">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                            <span>{{ __('View Document') }}</span>
                        </a>
                    @else
                        <span class="document-status">
                            <i class="fas fa-circle-xmark" aria-hidden="true"></i>
                            <span>{{ __('No File') }}</span>
                        </span>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
