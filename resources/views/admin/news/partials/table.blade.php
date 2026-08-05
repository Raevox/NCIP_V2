{{-- Table Card --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table news-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $i => $item)
                    <tr>
                        <td style="color: var(--text-soft); font-size: 12px;">
                            {{ ($news->currentPage() - 1) * $news->perPage() + $i + 1 }}
                        </td>
                        <td>
                            <div class="news-title-cell">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="" class="news-thumb">
                                @else
                                    <div class="news-thumb-placeholder">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="news-title-text">{{ Str::limit($item->title, 60) }}</div>
                                    @if($item->description)
                                        <div class="news-date-text">{{ Str::limit($item->description, 70) }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="text-center" style="font-size: 12.5px; color: var(--text-soft); white-space: nowrap;">
                            <i class="fas fa-calendar-alt" style="font-size:10px; margin-right:4px;"></i>
                            {{ $item->date ? \Carbon\Carbon::parse($item->date)->format('M d, Y') : '—' }}
                        </td>
                        <td class="text-center">
                            @if($item->status === 'Published')
                                <span class="status-badge status-published">
                                    <i class="fas fa-circle" style="font-size:7px;"></i> Published
                                </span>
                            @else
                                <span class="status-badge status-draft">
                                    <i class="fas fa-circle" style="font-size:7px;"></i> Draft
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="action-cell" style="justify-content: center;">
                                <a href="{{ route('admin.news.edit', $item->id) }}" class="btn-edit">
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
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fas fa-newspaper"></i>
                                <p>No news articles found{{ !empty($search) ? ' for "' . $search . '"' : '' }}.</p>
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
@if($news->hasPages())
    <div class="pagination-row">
        <div class="pagination-info">
            Showing {{ $news->firstItem() }}–{{ $news->lastItem() }} of {{ $news->total() }} articles
        </div>
        <ul class="custom-pagination">
            @if($news->onFirstPage())
                <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-left" style="font-size:11px;"></i></span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $news->previousPageUrl() }}"><i class="fas fa-chevron-left" style="font-size:11px;"></i></a></li>
            @endif

            @foreach($news->getUrlRange(1, $news->lastPage()) as $page => $url)
                @if($page == $news->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach

            @if($news->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $news->nextPageUrl() }}"><i class="fas fa-chevron-right" style="font-size:11px;"></i></a></li>
            @else
                <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-right" style="font-size:11px;"></i></span></li>
            @endif
        </ul>
    </div>
@endif
