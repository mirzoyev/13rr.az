<?php
include_once '../inc/predoc.php';
if (!$is_admin) {
 header("Location: index.php");
 die();
}

$dbh = db_connect();

$ddsu_rs = $dbh->prepare("execute dbo.del_site_users :id");
$ddsu_rs->bindParam(":id", $id, PDO::PARAM_INT, 0);
$ddsu_rs->execute();

db_close();

header("Location: admin_users.php");
