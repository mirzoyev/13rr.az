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

echo "<h1>Sales by method of payment with menu items</h1>";
echo "<h3>from: $d1 till: $d2 $r_name</h3>";

$dbh = db_connect();

$drbmwi_rs = $dbh->prepare("execute dbo.rep_by_method_with_items :usr, :d1, :d2, :r");
$drbmwi_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drbmwi_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drbmwi_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drbmwi_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drbmwi_rs->execute();
if ($dbh->errorCode() == "00000") {
 echo "<table class=\"data_table\">";
 echo "<tr><th>dish</th><th>quantity</th><th>amount</th><th>discount</th><th>charge</th><th>payment</th></tr>";
 $x0 = 0;
 $x1 = 0;
 $x2 = 0;
 $x3 = 0;
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
 $q2 = 0;
 $a2 = 0;
 $p2 = 0;
 $d2 = 0;
 $c2 = 0;
 $q3 = 0;
 $a3 = 0;
 $p3 = 0;
 $d3 = 0;
 $c3 = 0;
 $qt = 0;
 $at = 0;
 $pt = 0;
 $dt = 0;
 $ct = 0;
 $pr = '';
 $pct = '';
 $pc = '';
 while ($drbmwi_r = $drbmwi_rs->fetchObject()) {
  if (!$r && $x0 != $drbmwi_r->r_id) {
   if ($x3) {
    echo "<tr class=\"subdetails\">";
    echo "<td>subtotal:</td>";
    echo "<td class=\"numeric\">".my_number($q3, 4)."</td>";
    echo "<td class=\"numeric\">".my_money($a3)."</td>";
    echo "<td class=\"numeric\">".my_money($d3)."</td>";
    echo "<td class=\"numeric\">".my_money($c3)."</td>";
    echo "<td class=\"numeric\">".my_money($p3)."</td>";
    echo "</tr>";
   }
   if ($x2) {
    echo "<tr class=\"subdetails\">";
    echo "<td>$pc:</td>";
    echo "<td class=\"numeric\">".my_number($q2, 4)."</td>";
    echo "<td class=\"numeric\">".my_money($a2)."</td>";
    echo "<td class=\"numeric\">".my_money($d2)."</td>";
    echo "<td class=\"numeric\">".my_money($c2)."</td>";
    echo "<td class=\"numeric\">".my_money($p2)."</td>";
    echo "</tr>";
   }
   if ($x1) {
    echo "<tr class=\"subdetails\">";
    echo "<td>$pct:</td>";
    echo "<td class=\"numeric\">".my_number($q1, 4)."</td>";
    echo "<td class=\"numeric\">".my_money($a1)."</td>";
    echo "<td class=\"numeric\">".my_money($d1)."</td>";
    echo "<td class=\"numeric\">".my_money($c1)."</td>";
    echo "<td class=\"numeric\">".my_money($p1)."</td>";
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
   echo "<tr><td colspan=\"6\" class=\"block_description\">".$drbmwi_r->restaurant."</td></tr>";
   $q0 = 0;
   $a0 = 0;
   $p0 = 0;
   $d0 = 0;
   $c0 = 0;
   $x0 = $drbmwi_r->r_id;
   $pr = $drbmwi_r->restaurant;
   $x1 = 0;
   $x2 = 0;
   $x3 = 0;
  }
  if ($x1 != $drbmwi_r->ct_id) {
   if ($x3) {
    echo "<tr class=\"subdetails\">";
    echo "<td>subtotal:</td>";
    echo "<td class=\"numeric\">".my_number($q3, 4)."</td>";
    echo "<td class=\"numeric\">".my_money($a3)."</td>";
    echo "<td class=\"numeric\">".my_money($d3)."</td>";
    echo "<td class=\"numeric\">".my_money($c3)."</td>";
    echo "<td class=\"numeric\">".my_money($p3)."</td>";
    echo "</tr>";
   }
   if ($x2) {
    echo "<tr class=\"subdetails\">";
    echo "<td>$pc:</td>";
    echo "<td class=\"numeric\">".my_number($q2, 4)."</td>";
    echo "<td class=\"numeric\">".my_money($a2)."</td>";
    echo "<td class=\"numeric\">".my_money($d2)."</td>";
    echo "<td class=\"numeric\">".my_money($c2)."</td>";
    echo "<td class=\"numeric\">".my_money($p2)."</td>";
    echo "</tr>";
   }
   if ($x1) {
    echo "<tr class=\"subdetails\">";
    echo "<td>$pct:</td>";
    echo "<td class=\"numeric\">".my_number($q1, 4)."</td>";
    echo "<td class=\"numeric\">".my_money($a1)."</td>";
    echo "<td class=\"numeric\">".my_money($d1)."</td>";
    echo "<td class=\"numeric\">".my_money($c1)."</td>";
    echo "<td class=\"numeric\">".my_money($p1)."</td>";
    echo "</tr>";
   }
   $x1 = $drbmwi_r->ct_id;
   $q1 = 0;
   $a1 = 0;
   $p1 = 0;
   $d1 = 0;
   $c1 = 0;
   echo "<tr><td colspan=\"5\" class=\"block_description\">".$drbmwi_r->currency_type."</td></tr>";
   $pct = $drbmwi_r->currency_type;
   $x2 = 0;
   $x3 = 0;
  }
  if ($x2 != $drbmwi_r->c_id) {
   if ($x3) {
    echo "<tr class=\"subdetails\">";
    echo "<td>subtotal:</td>";
    echo "<td class=\"numeric\">".my_number($q3, 4)."</td>";
    echo "<td class=\"numeric\">".my_money($a3)."</td>";
    echo "<td class=\"numeric\">".my_money($d3)."</td>";
    echo "<td class=\"numeric\">".my_money($c3)."</td>";
    echo "<td class=\"numeric\">".my_money($p3)."</td>";
    echo "</tr>";
   }
   if ($x2) {
    echo "<tr class=\"subdetails\">";
    echo "<td>$pc:</td>";
    echo "<td class=\"numeric\">".my_number($q2, 4)."</td>";
    echo "<td class=\"numeric\">".my_money($a2)."</td>";
    echo "<td class=\"numeric\">".my_money($d2)."</td>";
    echo "<td class=\"numeric\">".my_money($c2)."</td>";
    echo "<td class=\"numeric\">".my_money($p2)."</td>";
    echo "</tr>";
   }
   $x2 = $drbmwi_r->c_id;
   $q2 = 0;
   $a2 = 0;
   $p2 = 0;
   $d2 = 0;
   $c2 = 0;
   echo "<tr><td colspan=\"5\" class=\"block_description\">".$drbmwi_r->currency."</td></tr>";
   $pc = $drbmwi_r->currency;
   $x3 = 0;
  }
  if ($x3 != $drbmwi_r->cg_id) {
   if ($x3) {
    echo "<tr class=\"subdetails\">";
    echo "<td>subtotal:</td>";
    echo "<td class=\"numeric\">".my_number($q3, 4)."</td>";
    echo "<td class=\"numeric\">".my_money($a3)."</td>";
    echo "<td class=\"numeric\">".my_money($d3)."</td>";
    echo "<td class=\"numeric\">".my_money($c3)."</td>";
    echo "<td class=\"numeric\">".my_money($p3)."</td>";
    echo "</tr>";
   }
   $x3 = $drbmwi_r->cg_id;
   $q3 = 0;
   $a3 = 0;
   $p3 = 0;
   $d3 = 0;
   $c3 = 0;
   echo "<tr><td colspan=\"5\" class=\"block_description\">".$drbmwi_r->class_group."</td></tr>";
  }
  echo "<tr>";
  echo "<td>".$drbmwi_r->dish."</td>";
  echo "<td class=\"numeric\">".my_number($drbmwi_r->quantity, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($drbmwi_r->amount)."</td>";
  echo "<td class=\"numeric\">".my_money($drbmwi_r->discount)."</td>";
  echo "<td class=\"numeric\">".my_money($drbmwi_r->charge)."</td>";
  echo "<td class=\"numeric\">".my_money($drbmwi_r->payment)."</td>";
  echo "</tr>";
  $q0 += $drbmwi_r->quantity;
  $a0 += $drbmwi_r->amount;
  $p0 += $drbmwi_r->payment;
  $d0 += $drbmwi_r->discount;
  $c0 += $drbmwi_r->charge;
  $q1 += $drbmwi_r->quantity;
  $a1 += $drbmwi_r->amount;
  $p1 += $drbmwi_r->payment;
  $d1 += $drbmwi_r->discount;
  $c1 += $drbmwi_r->charge;
  $q2 += $drbmwi_r->quantity;
  $a2 += $drbmwi_r->amount;
  $p2 += $drbmwi_r->payment;
  $d2 += $drbmwi_r->discount;
  $c2 += $drbmwi_r->charge;
  $q3 += $drbmwi_r->quantity;
  $a3 += $drbmwi_r->amount;
  $p3 += $drbmwi_r->payment;
  $d3 += $drbmwi_r->discount;
  $c3 += $drbmwi_r->charge;
  $qt += $drbmwi_r->quantity;
  $at += $drbmwi_r->amount;
  $pt += $drbmwi_r->payment;
  $dt += $drbmwi_r->discount;
  $ct += $drbmwi_r->charge;
 }
 if ($q3) {
  echo "<tr class=\"subdetails\">";
  echo "<td>subtotal:</td>";
  echo "<td class=\"numeric\">".my_number($q3, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($a3)."</td>";
  echo "<td class=\"numeric\">".my_money($d3)."</td>";
  echo "<td class=\"numeric\">".my_money($c3)."</td>";
  echo "<td class=\"numeric\">".my_money($p3)."</td>";
  echo "</tr>";
 }
 if ($q2) {
  echo "<tr class=\"subdetails\">";
  echo "<td>$pc:</td>";
  echo "<td class=\"numeric\">".my_number($q2, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($a2)."</td>";
  echo "<td class=\"numeric\">".my_money($d2)."</td>";
  echo "<td class=\"numeric\">".my_money($c2)."</td>";
  echo "<td class=\"numeric\">".my_money($p2)."</td>";
  echo "</tr>";
 }
 if ($q1) {
  echo "<tr class=\"subdetails\">";
  echo "<td>$pct:</td>";
  echo "<td class=\"numeric\">".my_number($q1, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($a1)."</td>";
  echo "<td class=\"numeric\">".my_money($d1)."</td>";
  echo "<td class=\"numeric\">".my_money($c1)."</td>";
  echo "<td class=\"numeric\">".my_money($p1)."</td>";
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
 if ($qt) {
  echo "<tr class=\"block_footer\">";
  echo "<td>total:</td>";
  echo "<td class=\"numeric\">".my_number($qt, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($at)."</td>";
  echo "<td class=\"numeric\">".my_money($dt)."</td>";
  echo "<td class=\"numeric\">".my_money($ct)."</td>";
  echo "<td class=\"numeric\">".my_money($pt)."</td>";
  echo "</tr>";
 }
 echo "</table>";
 unset($drbmwi_rs);
}

db_close();

include_once '../inc/footer.php';
?>
