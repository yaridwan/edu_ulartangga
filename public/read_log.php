<?php
$logFile = dirname(__DIR__) . '/storage/logs/laravel.log';

if (file_exists($logFile)) {
    $content = file_get_contents($logFile);
    // get the last 5000 characters
    $tail = substr($content, -5000);
    echo "<pre>" . htmlspecialchars($tail) . "</pre>";
} else {
    echo "Log file not found at " . $logFile;
}
