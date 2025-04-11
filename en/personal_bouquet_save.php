<?php
include_once '../inc/predoc.php';

$dbh = db_connect();

if (isset($_POST["restaurant"])) $restaurant = $_POST["restaurant"];
else $restaurant = null;

if (isset($_POST["grp"])) $grp = $_POST["grp"];
else $grp = null;

if (isset($_POST["description"])) $description = $_POST["description"];
else $description = null;

if (isset($_POST["disp_order"])) $disp_order = $_POST["disp_order"];
else $disp_order = null;

$dsb_rs = $dbh->prepare("execute dbo.save_bouquets :id, :usr, :restaurant, :grp, :description, :disp_order");
$dsb_rs->bindParam(":id", $id, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT, 0);
$dsb_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$dsb_rs->bindParam(":restaurant", $restaurant, PDO::PARAM_INT, 0);
$dsb_rs->bindParam(":grp", $grp, PDO::PARAM_INT, 0);
$dsb_rs->bindParam(":description", $description, PDO::PARAM_STR, 500);
$dsb_rs->bindParam(":disp_order", $disp_order, PDO::PARAM_INT, 0);
$dsb_rs->execute();

$new_id = 0;

if ($dbh->errorCode() == "00000") {
 if ($dsb_r = $dsb_rs->fetchObject()) {
  $new_id = $dsb_r->new_id;
 }
 unset($dsb_rs);
}

db_close();

if ($new_id && !$id) header("Location: personal_bouquet_items.php?id=".$new_id);
else header("Location: personal_bouquets.php");
