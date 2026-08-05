{{-- Table Card --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table tribe-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tribe Name</th>
                    <th class="text-center">Status</th>
                    <th>Description</th>
                    <th class="text-center">Date Added</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tribes as $i => $tribe)
                    <tr>
                        <td style="color: var(--text-soft); font-size: 12px;">
                            {{ ($tribes->currentPage() - 1) * $tribes->perPage() + $i + 1 }}
                        </td>
                        <td>
                            <div class="tribe-name-cell">
                                <div class="tribe-avatar">
                                    @if($tribe->photo)
                                        <img src="{{ asset('storage/' . $tribe->photo) }}" alt="{{ $tribe->name }}">
                                    @else
                                        {{ strtoupper(substr($tribe->name, 0, 2)) }}
                                    @endif
                                </div>
                                <div>
                                    <div class="tribe-name-text">{{ $tribe->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            @if($tribe->is_active)
                                <span class="status-badge status-active">
                                    <i class="fas fa-circle" style="font-size:7px;"></i> Active
                                </span>
                            @else
                                <span class="status-badge status-inactive">
                                    <i class="fas fa-circle" style="font-size:7px;"></i> Inactive
                                </span>
                            @endif
                        </td>
                        <td style="max-width: 260px;">
                            <span style="font-size: 12.5px; color: var(--text-mid);">
                                {{ $tribe->description ? \Illuminate\Support\Str::limit($tribe->description, 80) : '—' }}
                            </span>
                        </td>
                        <td class="text-center" style="font-size: 12.5px; color: var(--text-soft);">
                            {{ $tribe->created_at ? $tribe->created_at->format('M d, Y') : '—' }}
                        </td>
                        <td class="text-center">
                            <div class="action-cell" style="justify-content: center;">
                                <a href="{{ route('admin.tribes.edit', $tribe) }}" class="btn-edit">
                                    <i class="fas fa-pen"></i> Edit
                                </a>
                                <button type="button"
                                        class="btn-delete"
                                        onclick="confirmDelete({{ $tribe->id }}, '{{ addslashes($tribe->name) }}')"
                                        id="deleteBtn{{ $tribe->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-flag"></i>
                                <p>No tribes found{{ !empty($search) ? ' for "' . $search . '"' : '' }}.</p>
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
@if($tribes->hasPages())
    <div class="pagination-row">
        <div class="pagination-info">
            Showing {{ $tribes->firstItem() }}–{{ $tribes->lastItem() }} of {{ $tribes->total() }} tribes
        </div>
        <ul class="custom-pagination">

            {{-- Prev --}}
            @if($tribes->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link"><i class="fas fa-chevron-left" style="font-size:11px;"></i></span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $tribes->previousPageUrl() }}">
                        <i class="fas fa-chevron-left" style="font-size:11px;"></i>
                    </a>
                </li>
            @endif

            {{-- Page numbers --}}
            @foreach($tribes->getUrlRange(1, $tribes->lastPage()) as $page => $url)
                @if($page == $tribes->currentPage())
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
            @if($tribes->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $tribes->nextPageUrl() }}">
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
