<?php

namespace App\Observers;

use App\Models\CocApplication;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class CocApplicationObserver
{
    /**
     * Handle the CocApplication "created" event.
     */
    public function created(CocApplication $application): void
    {
        Log::info('═══════════════════════════════════════════');
        Log::info('🔔 CocApplicationObserver.created() triggered');
        Log::info('   Application ID: ' . $application->id);
        Log::info('   Status: ' . ($application->status ?? 'null'));
        Log::info('   Coc Status: ' . ($application->coc_status ?? 'null'));
        Log::info('═══════════════════════════════════════════');
        
        // Only send notification on creation if status is Submitted
        // This prevents duplicate notifications with the updated event
        if ($application->status === 'Submitted' || $application->coc_status === null) {
            Log::info('✅ Triggering notifyCocNeedsApproval from created event');
            NotificationService::notifyCocNeedsApproval($application);
        } else {
            Log::info('⏭️  Skipping notification (status: ' . $application->status . ', coc_status: ' . $application->coc_status . ')');
        }
    }

    /**
     * Handle the CocApplication "updated" event.
     */
    public function updated(CocApplication $application): void
    {
        Log::info('═══════════════════════════════════════════');
        Log::info('🔔 CocApplicationObserver.updated() triggered');
        Log::info('   Application ID: ' . $application->id);
        Log::info('   Changed attributes: ' . implode(', ', array_keys($application->getChanges())));
        Log::info('═══════════════════════════════════════════');
        
        // Check if application was submitted (Draft -> Under Review)
        if ($application->wasChanged('coc_status') && $application->coc_status === 'Under Review') {
            Log::info('✅ COC status changed to "Under Review" - notifying reviewers');
            NotificationService::notifyCocNeedsApproval(
                $application,
                $application->getOriginal('coc_status') === 'Returned'
            );
        }
        
        // Check if status was changed to "Returned"
        if ($application->wasChanged('coc_status') && $application->coc_status === 'Returned') {
            Log::info('✅ COC status changed to "Returned" - notifying about rejection');
            $reason = null;
            $remarks = is_string($application->remarks) ? json_decode($application->remarks, true) : $application->remarks;
            if (is_array($remarks) && count($remarks) > 0) {
                $reason = $remarks[array_key_last($remarks)] ?? null;
            }
            NotificationService::notifyCocReturned($application, $reason);
        }
        
        // Check if status was changed to "Admin Approval" (staff forwarded)
        if ($application->wasChanged('coc_status') && $application->coc_status === 'Admin Approval') {
            Log::info('✅ COC status changed to "Admin Approval" - staff forwarded for approval');
            NotificationService::notifyApplicationForwarded($application);
        }

        // Check if status was changed to "Approved" (admin approved)
        if ($application->wasChanged('coc_status') && $application->coc_status === 'Approved') {
            Log::info('✅ COC status changed to "Approved" - notifying staff and admins');
            NotificationService::notifyCocApproved($application);
        }
    }
}
