<?php
include_once '../inc/predoc.php';

$dbh = db_connect();

if (isset($_POST["restaurant"])) $restaurant = $_POST["restaurant"];
else $restaurant = null;

if (isset($_POST["description"])) $description = $_POST["description"];
else $description = null;

if (isset($_POST["disp_order"])) $disp_order = $_POST["disp_order"];
else $disp_order = null;

$dsb_rs = $dbh->prepare("execute dbo.save_grp_bouquets :id, :usr, :restaurant, :description, :disp_order");
$dsb_rs->bindParam(":id", $id, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT, 0);
$dsb_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$dsb_rs->bindParam(":restaurant", $restaurant, PDO::PARAM_INT, 0);
$dsb_rs->bindParam(":description", $description, PDO::PARAM_STR_NATL, 500);
$dsb_rs->bindParam(":disp_order", $disp_order, PDO::PARAM_INT, 0);
$dsb_rs->execute();

$new_id = 0;

if ($dbh->errorCode() == "00000") {
 if ($dsb_r = $dsb_rs->fetchObject()) {
  $new_id = $dsb_r->new_id;
 }
 unset($dsb_rs);
}

if ($new_id) {
 $checked_a = $_POST['checked'];
 $unchecked_a = $_POST['unchecked'];

 $checked = 0;
 $unchecked = 0;

 $dsgbd_rs = $dbh->prepare("execute dbo.save_grp_bouquet_details :bouquet, :checked, :unchecked");
 $dsgbd_rs->bindParam(":bouquet", $new_id, PDO::PARAM_INT, 0);
 $dsgbd_rs->bindParam(":checked", $checked, PDO::PARAM_INT, 0);
 $dsgbd_rs->bindParam(":unchecked", $unchecked, PDO::PARAM_INT, 0);
 foreach ($unchecked_a as $unchecked) {
  $checked = 0;
  $y = $unchecked;
  foreach ($checked_a as $x) if ($x == $y) {$checked = $unchecked; $unchecked = 0;}
  $dsgbd_rs->execute();
 }
}

db_close();

header("Location: personal_grp_bouquets.php");
