<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search by name, email, or ID..." 
                       wire:model.live="searchTerm">
            </div>
        </div>
        <div class="col-md-6 text-end">
            <div class="btn-group" role="group">
                <input type="radio" class="btn-check" name="status" id="status_under" value="under_review" 
                       wire:model.live="filterStatus" checked>
                <label class="btn btn-outline-primary" for="status_under">
                    Under Review ({{ $applications->where('coc_status', 'Under Review')->count() ?? 0 }})
                </label>

                <input type="radio" class="btn-check" name="status" id="status_approved" value="approved" 
                       wire:model.live="filterStatus">
                <label class="btn btn-outline-success" for="status_approved">
                    Approved ({{ $applications->where('coc_status', 'Approved')->count() ?? 0 }})
                </label>

                <input type="radio" class="btn-check" name="status" id="status_returned" value="returned" 
                       wire:model.live="filterStatus">
                <label class="btn btn-outline-warning" for="status_returned">
                    Returned ({{ $applications->where('coc_status', 'Returned')->count() ?? 0 }})
                </label>
            </div>
        </div>
    </div>

    <!-- Applications Table -->
    <div class="table-responsive">
        <table class="table table-hover table-sm">
            <thead class="table-light">
                <tr>
                    <th style="cursor: pointer;" wire:click="toggleSort('id')">
                        ID
                        @if($sortBy === 'id')
                            <i class="fas fa-{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}"></i>
                        @endif
                    </th>
                    <th>Applicant Name</th>
                    <th>Email</th>
                    <th>Tribe</th>
                    <th style="cursor: pointer;" wire:click="toggleSort('coc_status')">
                        Status
                        @if($sortBy === 'coc_status')
                            <i class="fas fa-{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}"></i>
                        @endif
                    </th>
                    <th style="cursor: pointer;" wire:click="toggleSort('created_at')">
                        Submitted
                        @if($sortBy === 'created_at')
                            <i class="fas fa-{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}"></i>
                        @endif
                    </th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    <tr>
                        <td class="fw-bold">#{{ $app->id }}</td>
                        <td>
                            @if($app->applicant)
                                {{ $app->applicant->name ?? ($app->applicant->first_name . ' ' . $app->applicant->last_name) }}
                            @else
                                <span class="text-muted">Unknown</span>
                            @endif
                        </td>
                        <td>{{ $app->applicant->email ?? 'N/A' }}</td>
                        <td>{{ $app->tribe ?? 'N/A' }}</td>
                        <td>
                            @php
                                $statusClass = match($app->coc_status) {
                                    'Approved' => 'success',
                                    'Returned' => 'warning',
                                    default => 'info'
                                };
                            @endphp
                            <span class="badge bg-{{ $statusClass }}">{{ $app->coc_status }}</span>
                        </td>
                        <td>{{ $app->created_at?->diffForHumans() ?? 'N/A' }}</td>
                        <td class="text-center">
                            <a href="{{ route('staff.review.show', $app->id) }}" class="btn btn-sm btn-primary" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No applications found. 
                            @if($searchTerm)
                                Try clearing your search.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
            Showing <strong>{{ $applications->firstItem() ?? 0 }}</strong> to 
            <strong>{{ $applications->lastItem() ?? 0 }}</strong> of 
            <strong>{{ $applications->total() }}</strong> results
        </div>
        <div>
            {{ $applications->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
