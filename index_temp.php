<?php
header('Content-type: text/html; charset=utf-8');

$root_path = __DIR__;
require_once $root_path . '/config.php';
//require_once $root_path . '/classes/Database.php';
require_once $root_path . '/classes/Section.php';
require_once $root_path . '/classes/Website.php';
//require_once $root_path . '/functions/index.php';

$website = new Website();

$blocks = [
    'menu' => '',
    'meta' => ''
];

$sections = [];

$html = [
    'main' => ''
];

$current_menu = 0;

require_once $root_path . '/' . $website->entity . '.php';
require_once $root_path . '/' . 'templates/index.html';
