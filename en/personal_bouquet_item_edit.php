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

if (isset($_GET["b"])) $bouquet = $_GET["b"];
else $bouquet = null;

if (!$bouquet) {
 header("Location: personal_bouquets.php");
 die();
}

echo '<div class="index section background background-index">';
echo '<div class="container">';
echo '<div class="space space-top space-bottom">';
echo '<div class="row row-center row-wrap">';
echo '<div class="column column-1">';

echo '<div class="gap gap-4"></div>';
echo '<h5>__Edit bouquet\'s item</h5>';
echo '<div class="gap gap-2"></div>';

$dbh = db_connect();

$dgbi_rs = $dbh->prepare("execute dbo.get_bouquet_info :id, :usr");
$dgbi_rs->bindParam(":id", $bouquet, PDO::PARAM_INT, 0);
$dgbi_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$dgbi_rs->execute();
if ($dbh->errorCode() == "00000") {
 while ($dgbi_r = $dgbi_rs->fetchObject()) {
  //echo "<h1>Edit bouquet's item</h1>";
  echo "<h6>".$dgbi_r->restaurant."&nbsp;/ ";
  echo $dgbi_r->class_group."&nbsp;/ ";
  echo $dgbi_r->description."</h6>";

 }
 unset($dgbi_rs);
}

function arr_dgbd_menuitem_dmlitt_fill() {
 global $dbh, $user_id, $bouquet;
 $res = array();
 $rs = $dbh->prepare("execute dbo.list_user_bouquet_possibility :id, :usr");
 $rs->bindParam(":id", $bouquet, PDO::PARAM_INT, 0);
 $rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
 $rs->execute();
 if (($dbh->errorCode() == "00000") && ($rs->errorCode() == "00000")) while ($r = $rs->fetchObject()) $res[$r->id] = $r->title;
 unset($rs);

 return $res;
}

$arr_dgbd_menuitem_dmlitt = arr_dgbd_menuitem_dmlitt_fill();

function arr_dgbd_menuitem_dmlitt_out($x) {
 global $arr_dgbd_menuitem_dmlitt;
 $r = "";
 foreach($arr_dgbd_menuitem_dmlitt as $a => $b) $r.= "<option".(($a == $x) ? " selected":"")." value=\"".$a."\">".$b."</option>";
 return $r;
}

$dgbd_rs = $dbh->prepare("execute dbo.get_bouquet_details :id, :usr");
$dgbd_rs->bindParam(":id", $id, PDO::PARAM_INT, 0);
$dgbd_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$dgbd_rs->execute();
if ($dbh->errorCode() == "00000") {
 echo "<form method=\"POST\" action=\"personal_bouquet_item_save.php?id=$id&b=$bouquet\"><table>";
 $dgbd_menuitem = null;
 if ($dgbd_r = $dgbd_rs->fetchObject()) {
  $dgbd_menuitem = $dgbd_r->menuitem;
 }
 echo "<tr><td><select name=\"menuitem\">".arr_dgbd_menuitem_dmlitt_out($dgbd_menuitem)."</select></td></tr>";
 echo "<tr><td><input type=\"submit\" class=\"temp_submit\" value=\"save\"></td></tr>";
 echo "</table></form>";
 unset($dgbd_rs);
}

echo '<div class="gap gap-2"></div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

include_once '../inc/footer.php';
