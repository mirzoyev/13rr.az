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

echo "<h1>Discounts and charges</h1>";
echo "<h3>from: $d1 till: $d2 $r_name</h3>";

$dbh = db_connect();

$drtd_rs = $dbh->prepare("execute dbo.rep_total_discounts :usr, :d1, :d2, :r");
$drtd_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drtd_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drtd_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drtd_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drtd_rs->execute();
if ($dbh->errorCode() == "00000") {
 $x = 0;
 $d = 0;
 $c = 0;
 $d0 = 0;
 $c0 = 0;
 echo "<table class=\"data_table\">";
 echo "<tr><th>title</th><th>discount</th><th>charge</th></tr>";
 while ($drtd_r = $drtd_rs->fetchObject()) {
  if ($x != $drtd_r->r_id && !$r) {
   if ($x) {
    echo "<tr class=\"subdetails\">";
    echo "<td>subtotal:</td>";
    echo "<td class=\"numeric\">".my_money($d)."</td>";
    echo "<td class=\"numeric\">".my_money($c)."</td>";
    echo "</tr>";
   }
   $x = $drtd_r->r_id;
   echo "<tr><td colspan=\"6\" class=\"block_description\">".$drtd_r->restaurant."</td></tr>";
   $d = 0;
   $c = 0;
  }
  echo "<tr>";
  echo "<td>".$drtd_r->title."</td>";
  echo "<td class=\"numeric\">".my_money($drtd_r->discount)."</td>";
  echo "<td class=\"numeric\">".my_money($drtd_r->charge)."</td>";
  echo "</tr>";
  $d += $drtd_r->discount;
  $c += $drtd_r->charge;
  $d0 += $drtd_r->discount;
  $c0 += $drtd_r->charge;
 }
 if ($x) {
  echo "<tr class=\"subdetails\">";
  echo "<td>subtotal:</td>";
  echo "<td class=\"numeric\">".my_money($d)."</td>";
  echo "<td class=\"numeric\">".my_money($c)."</td>";
  echo "</tr>";
 }
 echo "<tr class=\"block_footer\">";
 echo "<td>total:</td>";
 echo "<td class=\"numeric\">".my_money($d0)."</td>";
 echo "<td class=\"numeric\">".my_money($c0)."</td>";
 echo "</tr>";
 echo "</table>";
 unset($drtd_rs);
}

db_close();

include_once '../inc/footer.php';
?>
