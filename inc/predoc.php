<?php
if ($_SERVER['REMOTE_ADDR'] === '91.201.42.81') {
    define('DEBUG', true);
} else {
    define('DEBUG', false);
}

if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

$version_file = '../version.txt';
if (file_exists($version_file)) {
    define('VERSION', intval(file_get_contents($version_file)));
} else {
    define('VERSION', 0);
}

$is_post = 0;
$d1 = null;
$d2 = null;
$r = null;

$d1_prev = null;
$d2_prev = null;

//filter calendar
$navigation = [
    0 => [
        'name' => 'restaurant',
        'link' => 'index.php'
    ],
    1 => [
        'name' => '',
        'link' => ''
    ],
    2 => [
        'name' => '',
        'link' => ''
    ],
    3 => [
        'name' => 'gear',
        'link' => 'personal.php'
    ],
    4 => [
        'name' => 'exit',
        'link' => 'do_exit.php'
    ]
];

include_once '../inc/db.php';

$user_id = 0;
$login = '';
$sign = 0;
$is_admin = 0;

$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? ("https://") : ("http://")) . $_SERVER['HTTP_HOST'] . "/";

$base_title = 'r-keeper_inno';
$title = $base_title;
$subtitle = '';
$subtitle_info = '';

$id = 0;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
}

$page = 1;
if (isset($_GET['pg'])) {
    $page = intval($_GET['pg']);
}
if ($page < 1) $page = 0; else $page--;

$dbh = db_connect();

if (isset($_COOKIE['login']) and isset($_COOKIE['sign'])) {
    $login = $_COOKIE['login'];
    $sign = intval($_COOKIE['sign']);
    $dcsus_rs = $dbh->prepare("execute dbo.check_site_user_sign :login, :sign");
    $dcsus_rs->bindParam(":login", $login, PDO::PARAM_STR, 16);
    $dcsus_rs->bindParam(":sign", $sign, PDO::PARAM_INT, 0);
    $dcsus_rs->execute();
    if ($dbh->errorCode() == "00000") {
        if ($dcsus_r = $dcsus_rs->fetchObject()) {
            $user_id = $dcsus_r->id;
            $is_admin = $dcsus_r->is_admin;
            $list_users = $dcsus_r->list_users;
        } else {
            setcookie("sign", "", time() - 3600 * 24 * 30 * 12, "/");
        }
        unset($dcsus_rs);
    }
} else {
    if (!isset($_COOKIE['login'])) {
        $_COOKIE['login'] = '';
    }
}

db_close();

if (!DEBUG) {
    if ($user_id == 0) {
        if (!isset($login_page)) {
            header('Location: login.php');
            die();
        }
    }
}

$usr_css_name = "../main.css";
if (isset($_COOKIE['style'])) {
    $usr_css_name = $_COOKIE['style'];
}

if ($is_admin) {
    $navigation[2] = [
        'name' => 'user',
        'link' => 'admin_users.php'
    ];
}


function not_null($x)
{
    if ($x == null || $x == '') return '&nbsp;';
    else return $x;
}

function null_if_empty($x)
{
    if ($x) return $x;
    else return null;
}

function mail_to($x)
{
    if ($x == null || $x == '') return '&nbsp;';
    else return '<a href="mailto:' . $x . '">' . $x . '</a>';
}

function checked($x)
{
    if ($x) return ' checked';
    else return '';
}

function show_bool($x)
{
    if ($x) return "yes"; else return "&nbsp;";
}

function my_number($x, $d)
{
    if ($x === NULL) return "&nbsp;";
    else if ($d > 0) return number_format($x, $d);
    else return $x;
}

function my_number0($x, $d)
{
    if ($x === NULL) return number_format(0, $d);
    else if ($d > 0) return number_format($x, $d);
    else return $x;
}

function my_money($x)
{
    return my_number0($x, 2);
}

function current_date()
{
    global $dbh;
    if (!$dbh) $dbh = db_connect();
    $res = null;
    $dt_rs = $dbh->prepare("select getDate() as dt");
    $dt_rs->execute();
    if ($dbh->errorCode() == "00000") {
        if ($dt_r = $dt_rs->fetchObject()) {
            $res = $dt_r->dt;
        }
        unset($dt_rs);
    }
    return $res;
}

function current_date_only()
{
    global $dbh;
    if (!$dbh) $dbh = db_connect();
    $res = null;
    $dt_rs = $dbh->prepare("select cast(getDate() as date) as dt");
    $dt_rs->execute();
    if ($dbh->errorCode() == "00000") {
        if ($dt_r = $dt_rs->fetchObject()) {
            $res = $dt_r->dt;
        }
        unset($dt_rs);
    }
    return $res;
}

function restaurant_name($x)
{
    global $dbh;
    if (!$dbh) $dbh = db_connect();
    $res = null;
    $dgr_rs = $dbh->prepare("execute dbo.get_restaurants :id");
    $dgr_rs->bindParam(":id", $x, PDO::PARAM_INT, 0);
    $dgr_rs->execute();
    if ($dbh->errorCode() == "00000") {
        if ($dgr_r = $dgr_rs->fetchObject()) {
            $res = $dgr_r->title;
        }
        unset($dgr_rs);
    }
    return $res;
}
