<?php

// Debug
if(isset($_GET['debug'])){
    error_reporting(E_ALL);
    ini_set('display_errors', true);
} else {
    error_reporting(0);
    ini_set('display_errors', false);
}

// Include PHP files from directory
function include_files_from_directory($relative_path) {
    $dir = get_template_directory() . '/' . trim($relative_path, '/');
    
    if (!is_dir($dir) || !is_readable($dir)) {
        return;
    }

    $files = array_diff(scandir($dir), ['.', '..']); // Exclude '.' and '..'

    foreach ($files as $file) {
        $file_path = $dir . DIRECTORY_SEPARATOR . $file;
        if (pathinfo($file, PATHINFO_EXTENSION) === 'php' && is_file($file_path) && is_readable($file_path)) {
            require_once $file_path;
        }
    }
}

$include_paths = [
    '/inc/functions/',
    '/inc/hooks/',
    '/inc/thirds/',
    '/templates/modules/',
    '/templates/components/',
];

foreach ($include_paths as $path) {
    include_files_from_directory($path);
}

// Libs
$autoload_path = get_template_directory() . '/inc/libs/vendor/autoload.php';
if (file_exists($autoload_path) && is_readable($autoload_path)){
    require_once($autoload_path);
}