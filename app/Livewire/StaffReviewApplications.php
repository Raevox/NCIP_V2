<?php

namespace App\Livewire;

use Illuminate\Pagination\Paginator;
use App\Models\CocApplication;

class StaffReviewApplications
{
    public static function getPaginatedApplications($page = 1, $status = 'Under Review', $perPage = 10)
    {
        $query = CocApplication::with('applicant')->where('coc_status', $status);
        return $query->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);
    }
}
