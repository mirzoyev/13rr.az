<?php
$path = dirname(getcwd());
require_once($path . '/config.php');

$output = [];
$output['version'] = VERSION;

echo json_encode($output);
