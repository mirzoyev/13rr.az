<?php
include_once '../inc/predoc.php';
include_once '../inc/filter_get.php';
include_once '../inc/header.php';
include_once 'inc/main.php';
include_once 'inc/filter.php';

if ($r) {
 $r_name = restaurant_name($r);
} else $r_name = "";

if ($r_name) $r_name = "restaurant: ".$r_name;

echo "<h1>Receipts</h1>";
echo "<h3>from: $d1 till: $d2 $r_name</h3>";

$dbh = db_connect();

$drsbm_rs = $dbh->prepare("execute dbo.rep_sales_by_method :usr, :d1, :d2, :r");
$drsbm_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drsbm_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drsbm_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drsbm_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drsbm_rs->execute();
if ($dbh->errorCode() == "00000") {
 echo "<table class=\"data_table\">";
 echo "<tr><th>dish</th><th>quantity</th><th>amount</th><th>discount</th><th>charge</th><th>payment</th></tr>";
 $x0 = 0;
 $x1 = 0;
 $x2 = date(0);
 $x3 = 0;
 $x4 = 0;
 $q = 0;
 $a = 0;
 $p = 0;
 $d = 0;
 $c = 0;
 $pr = "";
 while ($drsbm_r = $drsbm_rs->fetchObject()) {
  if ($q && $x3 != $drsbm_r->receipt) {
   echo "<tr class=\"subdetails\">";
   echo "<td>$pr:</td>";
   echo "<td class=\"numeric\">".my_number($q, 4)."</td>";
   echo "<td class=\"numeric\">".my_money($a)."</td>";
   echo "<td class=\"numeric\">".my_money($d)."</td>";
   echo "<td class=\"numeric\">".my_money($c)."</td>";
   echo "<td class=\"numeric\">".my_money($p)."</td>";
   echo "</tr>";
   $q = 0;
   $a = 0;
   $p = 0;
   $d = 0;
   $c = 0;
  }
  if ($x0 != $drsbm_r->ct_id) {
   $x0 = $drsbm_r->ct_id;
   echo "<tr><td colspan=\"5\" class=\"block_description\">".$drsbm_r->currency_type."</td></tr>";
   $x1 = 0;
   $x2 = date(0);
   $x3 = 0;
   $x4 = 0;
  }
  if ($x1 != $drsbm_r->c_id) {
   $x1 = $drsbm_r->c_id;
   echo "<tr><td colspan=\"5\" class=\"block_description\">".$drsbm_r->currency."</td></tr>";
   $x2 = date(0);
   $x3 = 0;
   $x4 = 0;
  }
  if ($x2 != date($drsbm_r->dt)) {
   $x2 = date($drsbm_r->dt);
   echo "<tr><td colspan=\"5\" class=\"block_description\">".$drsbm_r->dt."</td></tr>";
   $x3 = 0;
   $x4 = 0;
  }
  if ($x3 != $drsbm_r->receipt) {
   $x3 = $drsbm_r->receipt;
   echo "<tr><td colspan=\"5\" class=\"block_description\">".$drsbm_r->receipt."</td></tr>";
   $pr = $drsbm_r->receipt;
   $x4 = 0;
  }
  if ($x4 != $drsbm_r->cg_id) {
   $x4 = $drsbm_r->cg_id;
   echo "<tr><td colspan=\"5\" class=\"block_description\">".$drsbm_r->class_group."</td></tr>";
  }
  echo "<tr>";
  echo "<td>".$drsbm_r->dish."</td>";
  echo "<td class=\"numeric\">".my_number($drsbm_r->quantity, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($drsbm_r->amount)."</td>";
  echo "<td class=\"numeric\">".my_money($drsbm_r->discount)."</td>";
  echo "<td class=\"numeric\">".my_money($drsbm_r->charge)."</td>";
  echo "<td class=\"numeric\">".my_money($drsbm_r->payment)."</td>";
  echo "</tr>";
  $q += $drsbm_r->quantity;
  $a += $drsbm_r->amount;
  $p += $drsbm_r->payment;
  $d += $drsbm_r->discount;
  $c += $drsbm_r->charge;
 }
 if ($q) {
  echo "<tr class=\"subdetails\">";
  echo "<td>$pr:</td>";
  echo "<td class=\"numeric\">".my_number($q, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($a)."</td>";
  echo "<td class=\"numeric\">".my_money($d)."</td>";
  echo "<td class=\"numeric\">".my_money($c)."</td>";
  echo "<td class=\"numeric\">".my_money($p)."</td>";
  echo "</tr>";
 }
 echo "</table>";
 unset($drsbm_rs);
}

db_close();

include_once '../inc/footer.php';
?>
