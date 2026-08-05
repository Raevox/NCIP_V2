{{-- Table Card --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table acc-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th class="text-center">Layout</th>
                    <th class="text-center">Year</th>
                    <th class="text-center">Order</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($accomplishments as $i => $item)
                    <tr>
                        <td style="color: var(--text-soft); font-size: 12px;">
                            {{ ($accomplishments->currentPage() - 1) * $accomplishments->perPage() + $i + 1 }}
                        </td>
                        <td>
                            <div class="acc-title-cell">
                                @if($item->image)
                                    @if(str_starts_with($item->image, 'content/'))
                                        <img src="{{ asset($item->image) }}" alt="" class="acc-thumb">
                                    @else
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="" class="acc-thumb">
                                    @endif
                                @else
                                    <div class="acc-thumb-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="acc-title-text">{{ Str::limit($item->title, 55) }}</div>
                                    @if($item->date_label)
                                        <div class="acc-date-text"><i class="fas fa-calendar-alt" style="font-size:10px;"></i> {{ $item->date_label }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="layout-badge">
                                @switch($item->layout_type)
                                    @case(1) <i class="fas fa-columns"></i> Left Image @break
                                    @case(2) <i class="fas fa-columns"></i> Right Image @break
                                    @case(4) <i class="fas fa-credit-card"></i> Card @break
                                    @case(5) <i class="fas fa-th"></i> Grid @break
                                @endswitch
                            </span>
                        </td>
                        <td class="text-center" style="font-size: 13px; font-weight: 600; color: var(--green-500);">
                            {{ $item->year_group ?: '—' }}
                        </td>
                        <td class="text-center" style="font-size: 12.5px; color: var(--text-soft);">
                            {{ $item->sort_order }}
                        </td>
                        <td class="text-center">
                            @if($item->is_active)
                                <span class="status-badge status-active">
                                    <i class="fas fa-circle" style="font-size:7px;"></i> Active
                                </span>
                            @else
                                <span class="status-badge status-inactive">
                                    <i class="fas fa-circle" style="font-size:7px;"></i> Inactive
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="action-cell" style="justify-content: center;">
                                <a href="{{ route('admin.accomplishments.edit', $item) }}" class="btn-edit">
                                    <i class="fas fa-pen"></i> Edit
                                </a>
                                <button type="button"
                                        class="btn-delete"
                                        onclick="confirmDelete({{ $item->id }}, '{{ addslashes(Str::limit($item->title, 40)) }}')"
                                        id="deleteBtn{{ $item->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-trophy"></i>
                                <p>No accomplishments found{{ !empty($search) ? ' for "' . $search . '"' : '' }}.</p>
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
@if($accomplishments->hasPages())
    <div class="pagination-row">
        <div class="pagination-info">
            Showing {{ $accomplishments->firstItem() }}–{{ $accomplishments->lastItem() }} of {{ $accomplishments->total() }} accomplishments
        </div>
        <ul class="custom-pagination">
            @if($accomplishments->onFirstPage())
                <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-left" style="font-size:11px;"></i></span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $accomplishments->previousPageUrl() }}"><i class="fas fa-chevron-left" style="font-size:11px;"></i></a></li>
            @endif

            @foreach($accomplishments->getUrlRange(1, $accomplishments->lastPage()) as $page => $url)
                @if($page == $accomplishments->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach

            @if($accomplishments->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $accomplishments->nextPageUrl() }}"><i class="fas fa-chevron-right" style="font-size:11px;"></i></a></li>
            @else
                <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-right" style="font-size:11px;"></i></span></li>
            @endif
        </ul>
    </div>
@endif
