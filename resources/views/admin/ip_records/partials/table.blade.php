
<div class="table-responsive">
    <table class="table table-striped ip-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Present Address</th>
                <th>IP Group</th>
                <th>Date of Census</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $record)
                <tr>
                    <td>{{ $record->first_name }} {{ $record->last_name }}</td>
                    <td>{{ $record->barangay }}, {{ $record->municipality }}, {{ $record->province }}</td>
                    <td>{{ $record->ip_group }}</td>
                    <td>{{ $record->census_date ? \Carbon\Carbon::parse($record->census_date)->format('m/d/Y') : 'N/A' }}</td>
                    <td class="text-center">
                        <!-- Simple Dropdown - Only View and Archive -->
                        <div class="dropdown">
                            <button class="btn btn-action-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                ⋮
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a href="{{ route('ip_records.show', $record->id) }}" class="dropdown-item">View</a></li>
                                <li>
                                    <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#archiveModal{{ $record->id }}">
                                        Archive
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- Archive Modal -->
                        <div class="modal fade" id="archiveModal{{ $record->id }}" tabindex="-1" aria-labelledby="archiveModalLabel{{ $record->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content shadow">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="archiveModalLabel{{ $record->id }}">
                                            <i class="fas fa-exclamation-triangle me-1"></i> Confirm Archive
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to move <strong>{{ $record->first_name }} {{ $record->last_name }}</strong> to the archive?
                                        <br>
                                        <small class="text-muted">This action won't delete the record permanently. It can be restored later.</small>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('ip_records.destroy', $record->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Yes, Archive</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($records->hasPages())
<div class="pagination-container px-3 py-3 border-top">
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-muted small">
            Showing {{ $records->firstItem() ?? 0 }} to {{ $records->lastItem() ?? 0 }} of {{ $records->total() }} results
        </div>
        <div>
            {{ $records->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endif
