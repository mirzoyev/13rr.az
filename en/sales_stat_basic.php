<?php
include_once '../inc/predoc.php';
include_once '../inc/filter_get.php';
include_once '../inc/header.php';
include_once 'inc/main.php';
include_once 'inc/filter.php';

$dbh = db_connect();

echo "<h1>Sales statistics</h1>";

if ($r) {
 $r_name = restaurant_name($r);
} else $r_name = "";

if ($r_name) $r_name = "restaurant: ".$r_name;

echo "<h3>from: $d1 till: $d2 $r_name</h3>";

$drspm_rs = $dbh->prepare("execute dbo.rep_stat_per_month :usr, :d1, :d2, :r");
$drspm_rs->bindParam(":usr", $usr, PDO::PARAM_INT, 0);
$drspm_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drspm_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drspm_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drspm_rs->execute();
if ($dbh->errorCode() == "00000") {
 echo "<table>";
 echo "<tr><th>restaurant_name</th><th>restaurant</th><th>y</th><th>m</th><th>tables</th><th>guestscount</th><th>pricesum</th><th>paysum</th><th>quantity</th><th>discounts</th><th>charges</th><th>complimentary</th></tr>";
 while ($drspm_r = $drspm_rs->fetchObject()) {
  echo "<tr>";
  echo "<td>".$drspm_r->restaurant_name."</td>";
  echo "<td>".$drspm_r->restaurant."</td>";
  echo "<td>".$drspm_r->y."</td>";
  echo "<td>".$drspm_r->m."</td>";
  echo "<td>".$drspm_r->tables."</td>";
  echo "<td>".$drspm_r->guestscount."</td>";
  echo "<td>".$drspm_r->pricesum."</td>";
  echo "<td>".$drspm_r->paysum."</td>";
  echo "<td>".$drspm_r->quantity."</td>";
  echo "<td>".$drspm_r->discounts."</td>";
  echo "<td>".$drspm_r->charges."</td>";
  echo "<td>".$drspm_r->complimentary."</td>";
  echo "</tr>";
 }
 echo "</table>";
 unset($drspm_rs);
}


db_close();

include_once '../inc/footer.php';
?>
