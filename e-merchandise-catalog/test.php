<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Testing Server Setup</h1>";

echo "<h2>1. Basic PHP Check</h2>";
echo "PHP is working! Version: " . phpversion() . "<br><br>";

echo "<h2>2. Files and Folders Check</h2>";
$checkFiles = [
    __DIR__ . '/.env' => '.env file',
    __DIR__ . '/public/index.php' => 'public/index.php',
    __DIR__ . '/vendor/autoload.php' => 'vendor/autoload.php',
];

foreach ($checkFiles as $path => $name) {
    if (file_exists($path)) {
        echo "✅ $name exists<br>";
    } else {
        echo "❌ $name <strong>does NOT exist</strong><br>";
    }
}

echo "<br>";
echo "<h2>3. Folder Permissions Check</h2>";
$checkFolders = [
    __DIR__ . '/storage',
    __DIR__ . '/bootstrap/cache',
];

foreach ($checkFolders as $folder) {
    if (is_dir($folder)) {
        $perms = substr(sprintf('%o', fileperms($folder)), -4);
        echo "📁 $folder exists (permissions: $perms)<br>";
        if (is_writable($folder)) {
            echo "✅ $folder is writable<br><br>";
        } else {
            echo "❌ $folder is NOT writable - important! Fix permissions to 755 or 775<br><br>";
        }
    } else {
        echo "❌ $folder does NOT exist<br><br>";
    }
}

echo "<h2>4. Next Steps</h2>";
echo "- If vendor/autoload.php is missing, run <code>composer install</code><br>";
echo "- If .env is missing, copy .env.example to .env and edit it<br>";
echo "- If storage isn't writable, fix permissions in cPanel File Manager";
