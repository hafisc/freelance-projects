<?php

/**
 * Laravel built-in web server router with CORS support for static storage files.
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

$filePath = __DIR__.'/public'.$uri;

// Serve static file directly with CORS headers if it exists
if ($uri !== '/' && file_exists($filePath) && !is_dir($filePath)) {
    // Allow CORS headers ONLY for static files (so it won't conflict with Laravel's API CORS)
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: *");

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        exit(0);
    }

    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    $mimeTypes = [
        'css'  => 'text/css',
        'js'   => 'application/javascript',
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif'  => 'image/gif',
        'svg'  => 'image/svg+xml',
        'ico'  => 'image/x-icon',
        'json' => 'application/json',
        'woff' => 'font/woff',
        'woff2'=> 'font/woff2',
        'ttf'  => 'font/ttf',
    ];
    
    $mimeType = $mimeTypes[strtolower($extension)] ?? mime_content_type($filePath) ?? 'application/octet-stream';
    header("Content-Type: $mimeType");
    readfile($filePath);
    return true;
}

require_once __DIR__.'/public/index.php';
