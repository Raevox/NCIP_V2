@extends('layouts.admin')

@section('title', 'IP Records')

@section('content')
<div class="topbar">
    <h2>IP Records</h2>
</div>

<div class="filters">
    <form method="GET" action="{{ route('ip_records.index') }}" id="filterForm">
        <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Search by name..." />

        <select name="municipality" id="municipalityFilter">
            <option value="">All Municipalities</option>
            @foreach($municipalities as $municipality)
                <option value="{{ $municipality }}" {{ request('municipality') == $municipality ? 'selected' : '' }}>
                    {{ $municipality }}
                </option>
            @endforeach
        </select>

        <select name="ip_group" id="ipGroupFilter">
            <option value="">All IP Groups</option>
            @foreach($ipGroups as $group)
                <option value="{{ $group }}" {{ request('ip_group') == $group ? 'selected' : '' }}>
                    {{ $group }}
                </option>
            @endforeach
        </select>

        <button type="submit">Filter</button>
        <a id="downloadBtn" class="btn">Download CSV</a>
    </form>

    <!-- ADD NEW BUTTON -->
    <div class="actions" style="margin-top: 10px;">
        <a href="{{ route('ip_records.create') }}" class="btn add-btn">+ Add New</a>
    </div>
</div>

<table class="ip-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Present Address</th>
            <th>IP Group</th>
            <th>Date of Census</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($ipRecords as $record)
        <tr>
            <td>{{ $record->name }}</td>
            <td>{{ $record->present_address }}</td>
            <td>{{ $record->ip_group }}</td>
            <td>{{ $record->census_date }}</td>
            <td><a href="{{ route('admin.iprecord.show', $record->id) }}">View</a></td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No records found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="pagination">
    {{ $ipRecords->appends(request()->query())->links() }}
</div>

<script>
    document.getElementById('downloadBtn').addEventListener('click', function (e) {
        e.preventDefault();

        const form = document.getElementById('filterForm');
        const params = new URLSearchParams(new FormData(form)).toString();

        window.location.href = `/admin/ip-records/download-csv?${params}`;
    });
</script>
@endsection
