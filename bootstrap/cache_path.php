<?php

/*
|--------------------------------------------------------------------------
| Set Custom Cache Path
|--------------------------------------------------------------------------
|
| This file is used to set a custom cache path for Laravel applications
| that are experiencing issues with the default cache directory.
*/

$app = require_once __DIR__.'/app.php';

// Set a custom cache path outside of OneDrive
$cachePath = storage_path('framework/cache');

// Ensure the directory exists
if (! is_dir($cachePath)) {
    mkdir($cachePath, 0755, true);
}

// Set the cache path
$app->useCachePath($cachePath);

return $app;
