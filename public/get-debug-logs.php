<?php
// View Laravel Debug Logs - Last 50 lines

$logFile = __DIR__ . '/../storage/logs/laravel.log';

if (!file_exists($logFile)) {
    die("Log file not found: $logFile");
}

$lines = file($logFile, FILE_IGNORE_NEW_LINES);
$lines = array_slice($lines, -50); // Last 50 lines

echo "<h3>Last 50 Log Lines:</h3>";
echo "<pre style='font-size: 12px; max-height: 400px; overflow-y: auto;'>";

foreach ($lines as $line) {
    if (strpos($line, 'Notifications API') !== false) {
        echo "<span style='color: green; font-weight: bold;'>$line</span>\n";
    } elseif (strpos($line, 'Total count in DB') !== false) {
        echo "<span style='background: yellow;'>$line</span>\n";
    } elseif (strpos($line, 'ERROR') !== false || strpos($line, '❌') !== false) {
        echo "<span style='color: red; font-weight: bold;'>$line</span>\n";
    } elseif (strpos($line, 'Step') !== false) {
        echo "<span style='color: blue;'>$line</span>\n";
    } else {
        echo htmlspecialchars($line) . "\n";
    }
}

echo "</pre>";
?>
