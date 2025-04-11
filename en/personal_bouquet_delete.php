<?php
include_once '../inc/predoc.php';
//include_once 'inc/personal.php';

$navigation[0] = [
    'name' => 'back',
    'link' => 'personal_bouquets.php'
];
$navigation[1] = [
    'name' => '',
    'link' => ''
];
$navigation[2] = [
    'name' => '',
    'link' => ''
];
$navigation[3] = [
    'name' => '',
    'link' => ''
];

include_once '../inc/header.php';

echo '<div class="index section background background-index">';
echo '<div class="container">';
echo '<div class="space space-top space-bottom">';
echo '<div class="row row-center row-wrap">';
echo '<div class="column column-1">';

echo '<div class="gap gap-4"></div>';
echo '<h5>__Delete bouquet?</h5>';
echo '<div class="gap gap-2"></div>';

$dbh = db_connect();

$dgbi_rs = $dbh->prepare("execute dbo.get_bouquet_info :id, :usr");
$dgbi_rs->bindParam(":id", $id, PDO::PARAM_INT, 0);
$dgbi_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$dgbi_rs->execute();
if ($dbh->errorCode() == "00000") {
 while ($dgbi_r = $dgbi_rs->fetchObject()) {
  echo "<h4>".$dgbi_r->restaurant."&nbsp;/ ";
  echo $dgbi_r->class_group."&nbsp;/ ";
  echo $dgbi_r->description."</h4>";
  echo "<a href=\"personal_bouquet_do_delete.php?id=".$id."\">yes</a>&nbsp;&nbsp;&nbsp;<a href=\"personal_bouquets.php\">no</a>";
  echo "<br>";
  echo "<br>";

  $dlubd_rs = $dbh->prepare("execute dbo.list_user_bouquet_details :id, :usr");
  $dlubd_rs->bindParam(":id", $id, PDO::PARAM_INT, 0);
  $dlubd_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
  $dlubd_rs->execute();
  if ($dbh->errorCode() == "00000") {
   echo "<h3>items</h3>";
   echo "<table>";
   while ($dlubd_r = $dlubd_rs->fetchObject()) {
    echo "<tr>";
    echo "<td>".$dlubd_r->title."</td>";
    echo "</tr>";
   }
   echo "</table>";
   unset($dlubd_rs);
  }

 }
 unset($dgbi_rs);
}

db_close();

echo '<div class="gap gap-2"></div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

include_once '../inc/footer.php';
