<?php
error_reporting( E_ALL );
ini_set('display_errors', 1);

include_once '../inc/db.php';

$dbh = db_connect();

if (isset($_POST['login']) and isset($_POST['password'])) {
 $login = $_POST["login"];
 $dcsu_rs = $dbh->prepare("execute dbo.check_site_users :login, :psw");
 $dcsu_rs->bindParam(":login", $login, PDO::PARAM_STR, 16);
 $dcsu_rs->bindParam(":psw", $_POST['password'], PDO::PARAM_STR, 64);
 $dcsu_rs->execute();
 if ($dbh->errorCode() == "00000") {
  if ($dcsu_r = $dcsu_rs->fetchObject()) {
   $sign = $dcsu_r->psw_hash;
   setcookie("login", $login, time() + 3600*24*30*12, "/");
   setcookie("sign", $sign, time() + 3600*24*30*12, "/");

  } else {
   setcookie("sign", "", time() - 3600*24*30*12, "/");
  }
  unset($dcsu_rs);
 }
}

db_close();

header("Location: index.php"); exit();
?>
