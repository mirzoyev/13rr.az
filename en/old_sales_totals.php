<?php
include_once '../inc/predoc.php';
include_once '../inc/filter_get.php';
include_once '../inc/header.php';
//include_once 'inc/main.php';
//include_once 'inc/filter.php';

$r = 0;
if ($_GET['restaurant_id']) {
 $r = $_GET['restaurant_id'];
}

if ($r) {
 $r_name = restaurant_name($r);
} else $r_name = "";

//if ($r_name) $r_name = "restaurant: ".$r_name;

echo '<h4> ' . $r_name . ' sales totals</h4>';
//echo "<h3>from: $d1 till: $d2 $r_name</h3>";

$dbh = db_connect();

$drts_rs = $dbh->prepare("execute dbo.rep_total_sales :usr, :d1, :d2, :r");
$drts_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drts_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drts_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drts_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drts_rs->execute();
if ($dbh->errorCode() == "00000") {
 echo "<table class=\"data_table\">";
 echo "<tr><th>title</th><th>quantity</th><th>avg&nbsp;price</th><th>amount</th><th>discount</th><th>charge</th><th>payment</th></tr>";
 $x = 0;
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
 while ($drts_r = $drts_rs->fetchObject()) {
  if ($x != $drts_r->r_id && !$r) {
   if ($x) {
    echo "<tr class=\"subdetails\">";
    echo "<td>subtotal:</td>";
    echo "<td class=\"numeric\">".my_number($q, 4)."</td>";
    echo "<td class=\"numeric\">".my_money($a / $q)."</td>";
    echo "<td class=\"numeric\">".my_money($a)."</td>";
    echo "<td class=\"numeric\">".my_money($d)."</td>";
    echo "<td class=\"numeric\">".my_money($c)."</td>";
    echo "<td class=\"numeric\">".my_money($p)."</td>";
    echo "</tr>";
   }
   $x = $drts_r->r_id;
   echo "<tr><td colspan=\"6\" class=\"block_description\">".$drts_r->restaurant."</td></tr>";
   $q = 0;
   $a = 0;
   $v = 0;
   $p = 0;
   $d = 0;
   $c = 0;
  }
  echo "<tr>";
  echo "<td>".$drts_r->title."</td>";
  echo "<td class=\"numeric\">".my_number($drts_r->quantity, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($drts_r->avg_price)."</td>";
  echo "<td class=\"numeric\">".my_money($drts_r->amount)."</td>";
  echo "<td class=\"numeric\">".my_money($drts_r->discount)."</td>";
  echo "<td class=\"numeric\">".my_money($drts_r->charge)."</td>";
  echo "<td class=\"numeric\">".my_money($drts_r->payment)."</td>";
  echo "</tr>";
  $q += $drts_r->quantity;
  $a += $drts_r->amount;
  $p += $drts_r->payment;
  $d += $drts_r->discount;
  $c += $drts_r->charge;
  $q0 += $drts_r->quantity;
  $a0 += $drts_r->amount;
  $p0 += $drts_r->payment;
  $d0 += $drts_r->discount;
  $c0 += $drts_r->charge;
 }
 if (!$r && $q) {
  echo "<tr class=\"subdetails\">";
  echo "<td>subtotal:</td>";
  echo "<td class=\"numeric\">".my_number($q, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($a / $q)."</td>";
  echo "<td class=\"numeric\">".my_money($a)."</td>";
  echo "<td class=\"numeric\">".my_money($d)."</td>";
  echo "<td class=\"numeric\">".my_money($c)."</td>";
  echo "<td class=\"numeric\">".my_money($p)."</td>";
  echo "</tr>";
 }
 if ($q0) {
  echo "<tr class=\"block_footer\">";
  echo "<td>total:</td>";
  echo "<td class=\"numeric\">".my_number($q0, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($a0 / $q0)."</td>";
  echo "<td class=\"numeric\">".my_money($a0)."</td>";
  echo "<td class=\"numeric\">".my_money($d0)."</td>";
  echo "<td class=\"numeric\">".my_money($c0)."</td>";
  echo "<td class=\"numeric\">".my_money($p0)."</td>";
  echo "</tr>";
 }
 echo "</table>";
 unset($drts_rs);
}

db_close();

include_once '../inc/footer.php';
?>
