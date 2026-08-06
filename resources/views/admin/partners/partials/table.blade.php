{{-- Table Card --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table partner-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Partner</th>
                    <th class="text-center">Sector</th>
                    <th class="text-center">Order</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Date Added</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partners as $i => $partner)
                    <tr>
                        <td style="color: var(--text-soft); font-size: 12px;">
                            {{ ($partners->currentPage() - 1) * $partners->perPage() + $i + 1 }}
                        </td>
                        <td>
                            <div class="partner-name-cell">
                                <div class="partner-logo-thumb">
                                    @if($partner->logo)
                                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}">
                                    @else
                                        <i class="fas fa-building" style="font-size:18px; color: var(--text-soft);"></i>
                                    @endif
                                </div>
                                <div class="partner-name-text">{{ $partner->name }}</div>
                            </div>
                        </td>
                        <td class="text-center">
                            @if($partner->sector === 'government')
                                <span class="sector-badge sector-government">
                                    <i class="fas fa-landmark" style="font-size:10px;"></i> Government
                                </span>
                            @else
                                <span class="sector-badge sector-private">
                                    <i class="fas fa-briefcase" style="font-size:10px;"></i> Private / CSO
                                </span>
                            @endif
                        </td>
                        <td class="text-center" style="font-size: 13px; color: var(--text-soft);">
                            {{ $partner->sort_order }}
                        </td>
                        <td class="text-center">
                            @if($partner->is_active)
                                <span class="status-badge status-active">
                                    <i class="fas fa-circle" style="font-size:7px;"></i> Active
                                </span>
                            @else
                                <span class="status-badge status-inactive">
                                    <i class="fas fa-circle" style="font-size:7px;"></i> Inactive
                                </span>
                            @endif
                        </td>
                        <td class="text-center" style="font-size: 12.5px; color: var(--text-soft);">
                            {{ $partner->created_at ? $partner->created_at->format('M d, Y') : '—' }}
                        </td>
                        <td class="text-center">
                            <div class="action-cell" style="justify-content: center;">
                                <a href="{{ route('admin.partners.edit', $partner) }}" class="btn-edit">
                                    <i class="fas fa-pen"></i> Edit
                                </a>
                                <button type="button"
                                        class="btn-delete"
                                        onclick="confirmDelete({{ $partner->id }}, '{{ addslashes($partner->name) }}')"
                                        id="deleteBtn{{ $partner->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-handshake"></i>
                                <p>No partners found{{ !empty($search) ? ' for "' . $search . '"' : '' }}.</p>
                                @if(!empty($search))
                                    <a href="javascript:void(0)" onclick="clearSearch()" style="color: var(--green-500); font-size: 13px;">
                                        Clear search
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
@if($partners->hasPages())
    <div class="pagination-row">
        <div class="pagination-info">
            Showing {{ $partners->firstItem() }}–{{ $partners->lastItem() }} of {{ $partners->total() }} partners
        </div>
        <ul class="custom-pagination">

            {{-- Prev --}}
            @if($partners->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link"><i class="fas fa-chevron-left" style="font-size:11px;"></i></span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $partners->previousPageUrl() }}">
                        <i class="fas fa-chevron-left" style="font-size:11px;"></i>
                    </a>
                </li>
            @endif

            {{-- Page numbers --}}
            @foreach($partners->getUrlRange(1, $partners->lastPage()) as $page => $url)
                @if($page == $partners->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach

            {{-- Next --}}
            @if($partners->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $partners->nextPageUrl() }}">
                        <i class="fas fa-chevron-right" style="font-size:11px;"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link"><i class="fas fa-chevron-right" style="font-size:11px;"></i></span>
                </li>
            @endif

        </ul>
    </div>
@endif
