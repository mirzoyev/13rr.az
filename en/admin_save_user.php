<?php
include_once '../inc/predoc.php';
if (!$is_admin) {
 header("Location: index.php");
 die();
}

$dbh = db_connect();

if (isset($_POST["login"])) $login = $_POST["login"];
else $login = null;

if (isset($_POST["full_name"])) $full_name = $_POST["full_name"];
else $full_name = null;

if (isset($_POST["psw"])) $psw = $_POST["psw"];
else $psw = null;

if (isset($_POST["is_admin"])) $is_admin = $_POST["is_admin"];
else $is_admin = 0;

if (isset($_POST["list_users"])) $list_users = $_POST["list_users"];
else $list_users = 0;

if ($id == $user_id) $is_admin = 1;

$is_admin = intval($is_admin);

$dssu_rs = $dbh->prepare("execute dbo.save_site_users :id, :login, :full_name, :psw, :is_admin, :list_users");
$dssu_rs->bindParam(":id", $id, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT, 0);
$dssu_rs->bindParam(":login", $login, PDO::PARAM_STR, 16);
$dssu_rs->bindParam(":full_name", $full_name, PDO::PARAM_STR, 500);
$dssu_rs->bindParam(":psw", $psw, PDO::PARAM_STR, 64);
$dssu_rs->bindParam(":is_admin", $is_admin, PDO::PARAM_BOOL, 0);
$dssu_rs->bindParam(":list_users", $list_users, PDO::PARAM_BOOL, 0);
$dssu_rs->execute();

if ($dbh->errorCode() == "00000") {
 if ($dssu_r = $dssu_rs->fetchObject()) {
  $id = $dssu_r->new_id;
 }
 unset($dssu_rs);
}

$restaurant = 0;
$checked = 0;

$dsur_rs = $dbh->prepare("execute dbo.save_user_restaurants :id, :restaurant, :checked");
$dsur_rs->bindParam(":id", $id, PDO::PARAM_INT, 0);
$dsur_rs->bindParam(":restaurant", $restaurant, PDO::PARAM_INT, 0);
$dsur_rs->bindParam(":checked", $checked, PDO::PARAM_BOOL, 0);

foreach ($_POST["restaurant"] as $restaurant) {
 if (isset($_POST["checked".$restaurant])) $checked = intval($_POST["checked".$restaurant]);
 else $checked = 0;
 $dsur_rs->execute();
}

db_close();

header("Location: admin_users.php");
