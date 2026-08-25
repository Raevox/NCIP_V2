<?php

namespace App\Observers;

use App\Models\IpAccount;
use Illuminate\Support\Facades\Log;

class IpAccountObserver
{
    /**
     * Handle the IpAccount "created" event.
     */
    public function created(IpAccount $ipAccount): void
    {
        Log::info('═══════════════════════════════════════════');
        Log::info('🔔 IpAccountObserver.created() triggered');
        Log::info('   Account ID: ' . $ipAccount->id);
        Log::info('   Name: ' . $ipAccount->first_name . ' ' . $ipAccount->last_name);
        Log::info('═══════════════════════════════════════════');
        
    }
}
