<?php

use Symfony\Component\Filesystem\Path;

error_reporting(-1);

/** @var Composer\Autoload\ClassLoader $autoload  */
$autoload = require __DIR__ . '/../vendor/autoload.php';


// autoload Wp
$testPathWp = Path::join(getenv('HOME') ?? '', 'Sites', 'okkarent-group', 'okkarentorg');
$testFilesWp = ['wp-load.php'];

foreach ($testFilesWp as $file) {
    $file = Path::join($testPathWp, $file);
    if (is_file($file)) {
        require $file;
    }
}

if (!function_exists('_x')) {
    function _x($text, $context = '', $domain = '')
    {
        return $text;
    }
}

if (!function_exists('__')) {
    function __($text, $domain = '')
    {
        return $text;
    }
}
