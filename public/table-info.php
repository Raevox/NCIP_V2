<?php
// Show table structure and row count

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

use Illuminate\Support\Facades\DB;

try {
    echo "<h3>MySQL Database Information</h3>";
    
    // Get database name
    $dbName = DB::select('SELECT DATABASE() as db')[0]->db;
    echo "<p><strong>Connected Database:</strong> $dbName</p>";
    
    // Check if admin_notifications table exists
    $tableExists = DB::select("SELECT COUNT(*) as count FROM information_schema.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?", [$dbName, 'admin_notifications']);
    
    if ($tableExists[0]->count > 0) {
        echo "<p class='success'>✅ Table 'admin_notifications' EXISTS</p>";
        
        // Get row count
        $rowCount = DB::table('admin_notifications')->count();
        echo "<p><strong>Row Count:</strong> <span style='font-size: 20px; font-weight: bold;'>$rowCount</span></p>";
        
        if ($rowCount === 0) {
            echo "<p class='warning'>⚠️ Table is EMPTY - no records!</p>";
        } else {
            echo "<p class='success'>✅ Table has $rowCount records</p>";
        }
        
        // Show column info
        echo "<h4>Table Columns:</h4>";
        $columns = DB::select("SELECT COLUMN_NAME, COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? ORDER BY ORDINAL_POSITION", [$dbName, 'admin_notifications']);
        
        echo "<table border='1' cellpadding='8' style='border-collapse: collapse;'>";
        echo "<tr><th>Column</th><th>Type</th></tr>";
        foreach ($columns as $col) {
            echo "<tr><td>{$col->COLUMN_NAME}</td><td>{$col->COLUMN_TYPE}</td></tr>";
        }
        echo "</table>";
        
        // Try to fetch sample records
        if ($rowCount > 0) {
            echo "<h4>Sample Records (First 3):</h4>";
            $records = DB::table('admin_notifications')->limit(3)->get();
            echo "<table border='1' cellpadding='8' style='border-collapse: collapse;'>";
            echo "<tr><th>ID</th><th>Type</th><th>Title</th><th>Is Read</th><th>Created At</th></tr>";
            foreach ($records as $rec) {
                echo "<tr>";
                echo "<td>{$rec->id}</td>";
                echo "<td>{$rec->type}</td>";
                echo "<td>" . substr($rec->title, 0, 30) . "</td>";
                echo "<td>" . ($rec->is_read ? 'Yes' : 'No') . "</td>";
                echo "<td>{$rec->created_at}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
    } else {
        echo "<p class='error'>❌ Table 'admin_notifications' DOES NOT EXIST!</p>";
        
        // Show available tables
        echo "<h4>Available Tables:</h4>";
        $tables = DB::select("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = ?", [$dbName]);
        echo "<ul>";
        foreach ($tables as $t) {
            echo "<li>{$t->TABLE_NAME}</li>";
        }
        echo "</ul>";
    }
    
} catch (\Exception $e) {
    echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
