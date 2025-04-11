<?php
include_once '../inc/predoc.php';
include_once '../inc/filter_get.php';
include_once '../inc/header.php';
include_once 'inc/main.php';
include_once 'inc/filter.php';

$dbh = db_connect();

echo "<h1>Top 10</h1>";

if ($r) {
 $r_name = restaurant_name($r);
} else $r_name = "";

if ($r_name) $r_name = "restaurant: ".$r_name;

echo "<h3>from: $d1 till: $d2 $r_name</h3>";

echo "<table class=\"data_table\">";
echo "<tr><th>title</th><th>quantity</th><th>avg&nbsp;price</th><th>amount</th><th>discount</th><th>charge</th><th>payment</th></tr>";

$drtdq_rs = $dbh->prepare("execute dbo.rep_top_dish_quantity :usr, :d1, :d2, :r");
$drtdq_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drtdq_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drtdq_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drtdq_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drtdq_rs->execute();
if ($dbh->errorCode() == "00000") {
 echo "<tr><td colspan=\"7\" class=\"block_description\">By quantity</td></tr>";
 while ($drtdq_r = $drtdq_rs->fetchObject()) {
  echo "<tr>";
  echo "<td>".$drtdq_r->dish."</td>";
  echo "<td class=\"numeric\">".my_number($drtdq_r->quantity, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($drtdq_r->avg_price)."</td>";
  echo "<td class=\"numeric\">".my_money($drtdq_r->amount)."</td>";
  echo "<td class=\"numeric\">".my_money($drtdq_r->discount)."</td>";
  echo "<td class=\"numeric\">".my_money($drtdq_r->charge)."</td>";
  echo "<td class=\"numeric\">".my_money($drtdq_r->payment)."</td>";
  echo "</tr>";
 }
 unset($drtdq_rs);
}

$drtda_rs = $dbh->prepare("execute dbo.rep_top_dish_amount :usr, :d1, :d2, :r");
$drtda_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drtda_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drtda_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drtda_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drtda_rs->execute();
if ($dbh->errorCode() == "00000") {
 echo "<tr><td colspan=\"7\" class=\"block_description\">By amount</td></tr>";
 while ($drtda_r = $drtda_rs->fetchObject()) {
  echo "<tr>";
  echo "<td>".$drtda_r->dish."</td>";
  echo "<td class=\"numeric\">".my_number($drtda_r->quantity, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($drtda_r->avg_price)."</td>";
  echo "<td class=\"numeric\">".my_money($drtda_r->amount)."</td>";
  echo "<td class=\"numeric\">".my_money($drtda_r->discount)."</td>";
  echo "<td class=\"numeric\">".my_money($drtda_r->charge)."</td>";
  echo "<td class=\"numeric\">".my_money($drtda_r->payment)."</td>";
  echo "</tr>";
 }
 unset($drtda_rs);
}

$drtdc_rs = $dbh->prepare("execute dbo.rep_top_dish_charge :usr, :d1, :d2, :r");
$drtdc_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drtdc_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drtdc_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drtdc_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drtdc_rs->execute();
if ($dbh->errorCode() == "00000") {
 echo "<tr><td colspan=\"7\" class=\"block_description\">By charge</td></tr>";
 while ($drtdc_r = $drtdc_rs->fetchObject()) {
  echo "<tr>";
  echo "<td>".$drtdc_r->dish."</td>";
  echo "<td class=\"numeric\">".my_number($drtdc_r->quantity, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($drtdc_r->avg_price)."</td>";
  echo "<td class=\"numeric\">".my_money($drtdc_r->amount)."</td>";
  echo "<td class=\"numeric\">".my_money($drtdc_r->discount)."</td>";
  echo "<td class=\"numeric\">".my_money($drtdc_r->charge)."</td>";
  echo "<td class=\"numeric\">".my_money($drtdc_r->payment)."</td>";
  echo "</tr>";
 }
 unset($drtdc_rs);
}

$drtbq_rs = $dbh->prepare("execute dbo.rep_top_boy_quantity :usr, :d1, :d2, :r");
$drtbq_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drtbq_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drtbq_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drtbq_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drtbq_rs->execute();
if ($dbh->errorCode() == "00000") {
 echo "<tr><td colspan=\"7\" class=\"block_description\">Boys by quantity</td></tr>";
 while ($drtbq_r = $drtbq_rs->fetchObject()) {
  echo "<tr>";
  echo "<td>".$drtbq_r->boy."</td>";
  echo "<td class=\"numeric\">".my_number($drtbq_r->quantity, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($drtbq_r->avg_price)."</td>";
  echo "<td class=\"numeric\">".my_money($drtbq_r->amount)."</td>";
  echo "<td class=\"numeric\">".my_money($drtbq_r->discount)."</td>";
  echo "<td class=\"numeric\">".my_money($drtbq_r->charge)."</td>";
  echo "<td class=\"numeric\">".my_money($drtbq_r->payment)."</td>";
  echo "</tr>";
 }
 unset($drtbq_rs);
}

$drtba_rs = $dbh->prepare("execute dbo.rep_top_boy_amount :usr, :d1, :d2, :r");
$drtba_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drtba_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drtba_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drtba_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drtba_rs->execute();
if ($dbh->errorCode() == "00000") {
 echo "<tr><td colspan=\"7\" class=\"block_description\">Boys by amount</td></tr>";
 while ($drtba_r = $drtba_rs->fetchObject()) {
  echo "<tr>";
  echo "<td>".$drtba_r->boy."</td>";
  echo "<td class=\"numeric\">".my_number($drtba_r->quantity, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($drtba_r->avg_price)."</td>";
  echo "<td class=\"numeric\">".my_money($drtba_r->amount)."</td>";
  echo "<td class=\"numeric\">".my_money($drtba_r->discount)."</td>";
  echo "<td class=\"numeric\">".my_money($drtba_r->charge)."</td>";
  echo "<td class=\"numeric\">".my_money($drtba_r->payment)."</td>";
  echo "</tr>";
 }
 unset($drtba_rs);
}

$drtbc_rs = $dbh->prepare("execute dbo.rep_top_boy_charge :usr, :d1, :d2, :r");
$drtbc_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drtbc_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drtbc_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drtbc_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drtbc_rs->execute();
if ($dbh->errorCode() == "00000") {
 echo "<tr><td colspan=\"7\" class=\"block_description\">Boys by charge</td></tr>";
 while ($drtbc_r = $drtbc_rs->fetchObject()) {
  echo "<tr>";
  echo "<td>".$drtbc_r->boy."</td>";
  echo "<td class=\"numeric\">".my_number($drtbc_r->quantity, 4)."</td>";
  echo "<td class=\"numeric\">".my_money($drtbc_r->avg_price)."</td>";
  echo "<td class=\"numeric\">".my_money($drtbc_r->amount)."</td>";
  echo "<td class=\"numeric\">".my_money($drtbc_r->discount)."</td>";
  echo "<td class=\"numeric\">".my_money($drtbc_r->charge)."</td>";
  echo "<td class=\"numeric\">".my_money($drtbc_r->payment)."</td>";
  echo "</tr>";
 }
 echo "</table>";
 unset($drtbc_rs);
}

echo "</table>";

db_close();

include_once '../inc/footer.php';
?>
