<?php
// Test the API and database directly

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

use App\Models\AdminNotification;
use Illuminate\Support\Facades\DB;

try {
    echo "<h2>Database Test</h2>";
    
    // Test database connection
    $pdo = DB::connection();
    echo "✅ Database connected<br><br>";
    
    // Check if table exists
    $tables = DB::select("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE()");
    echo "<h3>Tables in database:</h3>";
    $hasNotificationTable = false;
    foreach ($tables as $table) {
        echo "- " . $table->TABLE_NAME . "<br>";
        if ($table->TABLE_NAME === 'admin_notifications') {
            $hasNotificationTable = true;
        }
    }
    echo "<br>";
    
    if (!$hasNotificationTable) {
        echo "❌ admin_notifications table NOT found!<br>";
    } else {
        echo "✅ admin_notifications table EXISTS<br><br>";
        
        // Check table structure
        $columns = DB::select("DESCRIBE admin_notifications");
        echo "<h3>Table Structure:</h3>";
        foreach ($columns as $col) {
            echo "- {$col->Field} ({$col->Type})<br>";
        }
        echo "<br>";
        
        // Count records
        $count = DB::table('admin_notifications')->count();
        echo "<h3>Records in table: <strong>$count</strong></h3><br>";
        
        // Show first 5 records
        if ($count > 0) {
            $records = DB::table('admin_notifications')->limit(5)->get();
            echo "<h3>Sample Records:</h3>";
            echo "<pre>";
            foreach ($records as $record) {
                echo "ID: {$record->id}, Type: {$record->type}, Title: {$record->title}<br>";
            }
            echo "</pre><br>";
        }
    }
    
} catch (\Exception $e) {
    echo "<h2 style='color: red;'>❌ Error: " . $e->getMessage() . "</h2>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
