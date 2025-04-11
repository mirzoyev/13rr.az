<?php
include_once '../inc/predoc.php';
if (!$is_admin) {
 header("Location: index.php");
 die();
}
include_once '../inc/header.php';
include_once 'inc/admin.php';

$dbh = db_connect();

$dsu_rs = $dbh->prepare("select dsu.id, dsu.login, dsu.full_name, dsu.is_admin from dbo.site_users as dsu");
$dsu_rs->execute();
if ($dbh->errorCode() == "00000") {
 echo "<table class=\"data_table\">";
 echo "<tr><th>login</th><th>full&nbsp;name</th><th>is&nbsp;admin</th><th>action</th></tr>";
 while ($dsu_r = $dsu_rs->fetchObject()) {
  echo "<tr>";
  echo "<td>".$dsu_r->login."</td>";
  echo "<td>".$dsu_r->full_name."</td>";
  echo "<td align=\"center\">".show_bool($dsu_r->is_admin)."</td>";
  echo "<td><a href=\"admin_user_edit.php?id=".$dsu_r->id."\">edit</a>&nbsp;<a href=\"admin_del_user.php?id=".$dsu_r->id."\">delete</a></td>";
  echo "</tr>";
 }
 echo "</table>";
 echo "<a href=\"admin_user_edit.php?id=0\">add&nbsp;new</a>";
 unset($dsu_rs);
}

db_close();

include_once '../inc/footer.php';
?>
