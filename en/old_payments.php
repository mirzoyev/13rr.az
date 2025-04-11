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

echo "<h1>Payments by type</h1>";
echo "<h3>from: $d1 till: $d2 $r_name</h3>";

$dbh = db_connect();

$drsbc_rs = $dbh->prepare("execute dbo.rep_sales_by_currency :usr, :d1, :d2, :r");
$drsbc_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drsbc_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drsbc_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drsbc_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drsbc_rs->execute();
if ($dbh->errorCode() == "00000") {
 echo "<table class=\"data_table\">";
 echo "<tr><th>currency</th><th>quantity</th><th>amount</th><th>discount</th><th>charge</th><th>payment</th></tr>";
 $x = 0;
 $x0 = 0;
 $q = 0;
 $a = 0;
 $p = 0;
 $d = 0;
 $c = 0;
 $q0 = 0;
 $a0 = 0;
 $p0 = 0;
 $d0 = 0;
 $c0 = 0;
 $q1 = 0;
 $a1 = 0;
 $p1 = 0;
 $d1 = 0;
 $c1 = 0;
 $pr = '';
 while ($drsbc_r = $drsbc_rs->fetchObject()) {
  if (!$r && $x0 != $drsbc_r->r_id) {
   if ($x) {
    echo "<tr class=\"subdetails\">";
    echo "<td>subtotal:</td>";
    echo "<td class=\"numeric\">".my_number($q, 4)."</td>";
    echo "<td class=\"numeric\">".my_money($a)."</td>";
    echo "<td class=\"numeric\">".my_money($d)."</td>";
    echo "<td class=\"numeric\">".my_money($c)."</td>";
    echo "<td class=\"numeric\">".my_money($p)."</td>";
    echo "</tr>";
   }
   if ($x0) {
    echo "<tr class=\"subdetails\">";
    echo "<td>$pr:</td>";
    echo "<td class=\"numeric\">".my_number($q0, 4)."</td>";
    echo "<td class=\"numeric\">".my_money($a0)."</td>";
    echo "<td class=\"numeric\">".my_money($d0)."</td>";
    echo "<td class=\"numeric\">".my_money($c0)."</td>";
    echo "<td class=\"numeric\">".my_money($p0)."</td>";
    echo "</tr>";
   }
   echo "<tr><td colspan=\"6\" class=\"block_description\">".$drsbc_r->restaurant."</td></tr>";
   $q0 = 0;
   $a0 = 0;
   $p0 = 0;
   $d0 = 0;
   $c0 = 0;
   $x0 = $drsbc_r->r_id;
   $pr = $drsbc_r->restaurant;
   $x = 0;
  }
  if ($x != $drsbc_r->ct_id) {
   if ($x) {
    echo "<tr class=\"subdetails\">";
    echo "<td>subtotal:</td>";
    echo "<td class=\"numeric\">".my_number($q, 4)."</td>";
    echo "<td class=\"numeric\">".my_money($a)."</td>";
    echo "<td class=\"numeric\">".my_money($d)."</td>";
    echo "<td class=\"numeric\">".my_money($c)."</td>";
    echo "<td class=\"numeric\">".my_money($p)."</td>";
    echo "</tr>";
   }
   $x = $drsbc_r->ct_id;
   $q = 0;
   $a = 0;
   $p = 0;
   $d = 0;
   $c = 0;
   echo "<tr><td colspan=\"5\" class=\"block_description\">".$drsbc_r->currency_type."</td></tr>";
  }
  echo "<tr>";
  echo "<td>".$drsbc_r->currency."</td>";
  echo "<td class=\"numeric\">".my_number($drsbc_r->quantity, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($drsbc_r->amount)."</td>";
  echo "<td class=\"numeric\">".my_money($drsbc_r->discount)."</td>";
  echo "<td class=\"numeric\">".my_money($drsbc_r->charge)."</td>";
  echo "<td class=\"numeric\">".my_money($drsbc_r->payment)."</td>";
  echo "</tr>";
  $q += $drsbc_r->quantity;
  $a += $drsbc_r->amount;
  $p += $drsbc_r->payment;
  $d += $drsbc_r->discount;
  $c += $drsbc_r->charge;
  $q0 += $drsbc_r->quantity;
  $a0 += $drsbc_r->amount;
  $p0 += $drsbc_r->payment;
  $d0 += $drsbc_r->discount;
  $c0 += $drsbc_r->charge;
  $q1 += $drsbc_r->quantity;
  $a1 += $drsbc_r->amount;
  $p1 += $drsbc_r->payment;
  $d1 += $drsbc_r->discount;
  $c1 += $drsbc_r->charge;
 }
 if ($q) {
  echo "<tr class=\"subdetails\">";
  echo "<td>subtotal:</td>";
  echo "<td class=\"numeric\">".my_number($q, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($a)."</td>";
  echo "<td class=\"numeric\">".my_money($d)."</td>";
  echo "<td class=\"numeric\">".my_money($c)."</td>";
  echo "<td class=\"numeric\">".my_money($p)."</td>";
  echo "</tr>";
 }
 if (!$r && $q0) {
  echo "<tr class=\"subdetails\">";
  echo "<td>$pr:</td>";
  echo "<td class=\"numeric\">".my_number($q0, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($a0)."</td>";
  echo "<td class=\"numeric\">".my_money($d0)."</td>";
  echo "<td class=\"numeric\">".my_money($c0)."</td>";
  echo "<td class=\"numeric\">".my_money($p0)."</td>";
  echo "</tr>";
 }
 if ($q1) {
  echo "<tr class=\"block_footer\">";
  echo "<td>totals:</td>";
  echo "<td class=\"numeric\">".my_number($q1, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($a1)."</td>";
  echo "<td class=\"numeric\">".my_money($d1)."</td>";
  echo "<td class=\"numeric\">".my_money($c1)."</td>";
  echo "<td class=\"numeric\">".my_money($p1)."</td>";
  echo "</tr>";
 }
 echo "</table>";
 unset($drsbc_rs);
}

db_close();

include_once '../inc/footer.php';
?>
