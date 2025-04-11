<?php
include_once '../inc/predoc.php';

if (isset($_GET["b"])) $bouquet = $_GET["b"];
else $bouquet = null;

if (!$bouquet) {
 header("Location: personal_bouquets.php");
 die();
}

$dbh = db_connect();

$ddbd_rs = $dbh->prepare("execute dbo.del_bouquet_details :id, :usr, :bouquet");
$ddbd_rs->bindParam(":id", $id, PDO::PARAM_INT, 0);
$ddbd_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$ddbd_rs->bindParam(":bouquet", $bouquet, PDO::PARAM_INT, 0);
$ddbd_rs->execute();

db_close();

header("Location: personal_bouquet_items.php?id=$bouquet");
?>
