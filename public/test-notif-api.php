<?php
// Test notification API endpoint

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

use App\Models\AdminNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

try {
    echo "<h2>Notification API Test</h2>";
    
    // Check database directly
    $count = DB::table('admin_notifications')->count();
    echo "<p><strong>Total in Database:</strong> $count</p>";
    
    // Try to fetch via Model
    $notifs = AdminNotification::query()->get();
    echo "<p><strong>Via Model Query:</strong> " . $notifs->count() . " records</p>";
    
    // Show sample records
    if ($notifs->count() > 0) {
        echo "<h3>Sample Records:</h3>";
        echo "<pre>";
        foreach ($notifs->take(3) as $n) {
            echo "ID: {$n->id}, Type: {$n->type}, Title: {$n->title}\n";
        }
        echo "</pre>";
        
        // Try pagination
        $paginated = AdminNotification::paginate(15);
        echo "<p><strong>Paginated Result:</strong> " . json_encode([
            'total' => $paginated->total(),
            'count' => $paginated->count(),
            'per_page' => $paginated->perPage(),
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'has_more' => $paginated->hasMorePages()
        ], JSON_PRETTY_PRINT) . "</p>";
    } else {
        echo "<p style='color: red;'>❌ No records found in model query!</p>";
    }
    
} catch (\Exception $e) {
    echo "<p style='color: red;'><strong>Error:</strong> " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
