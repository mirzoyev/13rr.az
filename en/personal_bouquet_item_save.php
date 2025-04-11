<?php
include_once '../inc/predoc.php';

$dbh = db_connect();

if (isset($_GET["b"])) $bouquet = $_GET["b"];
else $bouquet = null;

if (isset($_POST["menuitem"])) $menuitem = $_POST["menuitem"];
else $menuitem = null;

$dsbd_rs = $dbh->prepare("execute dbo.save_bouquet_details :id, :usr, :bouquet, :menuitem");
$dsbd_rs->bindParam(":id", $id, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT, 0);
$dsbd_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$dsbd_rs->bindParam(":bouquet", $bouquet, PDO::PARAM_INT, 0);
$dsbd_rs->bindParam(":menuitem", $menuitem, PDO::PARAM_INT, 0);
$dsbd_rs->execute();

db_close();

header("Location: personal_bouquet_items.php?id=$bouquet");
