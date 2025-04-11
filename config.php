<?php
define('DEBUG', true);
error_reporting(E_ALL);
if (DEBUG === true) {
    set_time_limit(0);
    ini_set('display_errors', 1);
    ini_set('log_errors', 0);
} else {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
}

$version_file = 'version.txt';
if(file_exists($version_file)) {
    define('VERSION', intval(file_get_contents('version.txt')));
} else {
    define('VERSION', 0);
}

$image_file_formats = [
    0 => 'no_image',
    1 => 'gif',
    2 => 'jpg',
    3 => 'png',
    4 => 'webp'
];

if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    $db_settings = [
        'host' => 'localhost',
        'port' => '3306',
        'database' => 'qr_garden',
        'username' => 'root',
        'password' => 'root'
    ];
} else {
    $db_settings = [
        'host' => 'localhost',
        'port' => '3306',
        'database' => 'roman_garden',
        'username' => 'roman_garden',
        'password' => '___'
    ];
}
