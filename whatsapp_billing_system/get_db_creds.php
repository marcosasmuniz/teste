<?php
// get_db_creds.php

// This script is intended to be called by install.sh to fetch database credentials.
// It assumes it's being run from the root of the project (e.g., /app/whatsapp_billing_system/).

$configFile = __DIR__ . '/config/config.php';

if (!file_exists($configFile)) {
    echo "ERROR:config.php not found at $configFile\n";
    exit(1);
}

// Attempt to load the configuration.
// This will execute config.php. If it only defines constants, they will be available.
// If it returns an array, $config will hold it.
$config = require $configFile;

// Initialize variables
$dbHost = null;
$dbName = null;
$dbUser = null;
$dbPass = null;

// Try to get values from returned array first (recommended way)
if (is_array($config) && isset($config['database'])) {
    $dbHost = $config['database']['host'] ?? null;
    $dbName = $config['database']['name'] ?? null;
    $dbUser = $config['database']['user'] ?? null;
    $dbPass = $config['database']['pass'] ?? null;
}

// Fallback or primary method: Check for defined constants
// This allows flexibility if config.php uses define() or returns an array.
if ($dbHost === null && defined('DB_HOST')) $dbHost = DB_HOST;
if ($dbName === null && defined('DB_NAME')) $dbName = DB_NAME;
if ($dbUser === null && defined('DB_USER')) $dbUser = DB_USER;
if ($dbPass === null && defined('DB_PASS')) $dbPass = DB_PASS;


// Validate that all necessary credentials were found
if ($dbHost === null || $dbName === null || $dbUser === null || $dbPass === null) {
    $missing = [];
    if ($dbHost === null) $missing[] = 'DB_HOST or $config[\'database\'][\'host\']';
    if ($dbName === null) $missing[] = 'DB_NAME or $config[\'database\'][\'name\']';
    if ($dbUser === null) $missing[] = 'DB_USER or $config[\'database\'][\'user\']';
    if ($dbPass === null) $missing[] = 'DB_PASS or $config[\'database\'][\'pass\']';
    echo "ERROR:One or more database credentials not found in $configFile. Missing: " . implode(', ', $missing) . "\n";
    exit(1);
}

// Output each credential on a new line for easy parsing in shell script
echo "$dbHost\n";
echo "$dbName\n";
echo "$dbUser\n";
echo "$dbPass\n";

exit(0);
?>
