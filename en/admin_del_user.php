<?php
include_once '../inc/predoc.php';
if (!$is_admin) {
 header("Location: index.php");
 die();
}

if (!$id || $id == $user_id) {
 header("Location: admin_users.php");
 die();
}

$navigation[0] = [
    'name' => 'back',
    'link' => 'admin_users.php'
];
if ($is_admin) {
 $navigation[2] = [
     'name' => '',
     'link' => ''
 ];
}
$navigation[3] = [
    'name' => '',
    'link' => ''
];

$dgsu_rs = $dbh->prepare("execute dbo.get_site_users :id");
$dgsu_rs->bindParam(":id", $id, PDO::PARAM_INT, 0);
$dgsu_rs->execute();
if ($dbh->errorCode() == "00000") {
 $dgsu_login = null;
 $dgsu_full_name = null;
 if ($dgsu_r = $dgsu_rs->fetchObject()) {
  $dgsu_login = $dgsu_r->login;
  $dgsu_full_name = $dgsu_r->full_name;
 } else {
  header("Location: admin_users.php");
  die();
 }
 unset($dgsu_rs);
}

include_once '../inc/header.php';
//include_once 'inc/admin.php';

echo '<div class="index section background background-index">';
echo '<div class="container">';
echo '<div class="space space-top space-bottom">';
echo '<div class="row row-center row-wrap">';
echo '<div class="column column-1">';
echo '<div class="gap gap-4"></div>';

$dbh = db_connect();

echo "<h1>Delete user?</h1><table class=\"info_table\">";
echo "<tr><th>login</th><th>".$dgsu_login."</th></tr>";
echo "<tr><th>full&nbsp;name</th><th>".$dgsu_full_name."</th></tr>";
echo "</table>";
echo "<a href=\"admin_do_del_user.php?id=".$id."\">yes</a>&nbsp;&nbsp;&nbsp;<a href=\"admin_users.php\">no</a>";

db_close();

echo '<div class="gap gap-2"></div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

include_once '../inc/footer.php';
