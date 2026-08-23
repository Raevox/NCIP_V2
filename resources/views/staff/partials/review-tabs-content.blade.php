<div class="tabs-container">
        <!-- Tabs Navigation -->
        <div class="tabs-nav">
            <div class="tab-item">
                <a class="tab-link active" data-tab="underReview">
                    <i class="fas fa-hourglass-half"></i> Under Review
                    <span class="tab-badge" id="underReviewCount">{{ $underReview->total() }}</span>
                    <span class="tab-dot {{ (!empty($applicantBadge['has_under_review'])) ? 'show' : '' }}" id="dotStaffUnderReview" title="Applications under review"></span>
                </a>
            </div>
            <div class="tab-item">
                <a class="tab-link" data-tab="approved">
                    <i class="fas fa-check-circle"></i> Approved
                    <span class="tab-badge" id="approvedCount">{{ $approved->total() }}</span>
                    <span class="tab-dot {{ (!empty($applicantBadge['has_unread_approved'])) ? 'show' : '' }}" id="dotStaffApproved" title="New approved applications"></span>
                </a>
            </div>
            <div class="tab-item">
                <a class="tab-link" data-tab="returned">
                    <i class="fas fa-undo"></i> Returned
                    <span class="tab-badge" id="returnedCount">{{ $returned->total() }}</span>
                </a>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content-wrapper" id="tableContainer">
            <!-- Under Review Tab -->
            <div id="underReview" class="tab-pane active">
                @if($underReview->count() > 0)
                    <table class="review-table">
                        <thead>
                            <tr>
                                <th>Applicant</th>
                                <th>Date Submitted</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($underReview as $app)
                                @php
                                    $firstName = $app->applicant->first_name ?? 'N';
                                    $lastName  = $app->applicant->last_name ?? 'A';
                                    $initials  = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                                    $fullName  = trim($firstName . ' ' . $lastName);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="name-cell">
                                            <div class="name-avatar">{{ $initials }}</div>
                                            <span class="name-text">{{ $fullName }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="date-text">{{ $app->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td>
                                        <span class="status-badge under-review">Under Review</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('staff.review.show', $app->id) }}" class="btn-view">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($underReview->hasPages())
                        <div class="pagination-wrapper">
                            {{ $underReview->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>No applications under review</p>
                    </div>
                @endif
            </div>

            <!-- Approved Tab -->
            <div id="approved" class="tab-pane">
                @if($approved->count() > 0)
                    <table class="review-table">
                        <thead>
                            <tr>
                                <th>Applicant</th>
                                <th>Date Submitted</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approved as $app)
                                @php
                                    $firstName = $app->applicant->first_name ?? 'N';
                                    $lastName  = $app->applicant->last_name ?? 'A';
                                    $initials  = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                                    $fullName  = trim($firstName . ' ' . $lastName);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="name-cell">
                                            <div class="name-avatar">{{ $initials }}</div>
                                            <span class="name-text">{{ $fullName }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="date-text">{{ $app->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td>
                                        <span class="status-badge approved">Approved</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('staff.review.show', $app->id) }}" class="btn-view">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($approved->hasPages())
                        <div class="pagination-wrapper">
                            {{ $approved->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <i class="fas fa-check-circle"></i>
                        <p>No approved applications yet</p>
                    </div>
                @endif
            </div>

            <!-- Returned Tab -->
            <div id="returned" class="tab-pane">
                @if($returned->count() > 0)
                    <table class="review-table">
                        <thead>
                            <tr>
                                <th>Applicant</th>
                                <th>Date Submitted</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($returned as $app)
                                @php
                                    $firstName = $app->applicant->first_name ?? 'N';
                                    $lastName  = $app->applicant->last_name ?? 'A';
                                    $initials  = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                                    $fullName  = trim($firstName . ' ' . $lastName);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="name-cell">
                                            <div class="name-avatar">{{ $initials }}</div>
                                            <span class="name-text">{{ $fullName }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="date-text">{{ $app->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td>
                                        <span class="status-badge returned">Returned</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('staff.review.show', $app->id) }}" class="btn-view">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($returned->hasPages())
                        <div class="pagination-wrapper">
                            {{ $returned->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <i class="fas fa-undo"></i>
                        <p>No returned applications yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>