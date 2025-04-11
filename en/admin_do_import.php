<?php
include_once '../inc/predoc.php';
if (!$is_admin) {
 header("Location: index.php");
 die();
}

$dbh = db_connect();

$did_rs = $dbh->prepare("execute dbo.import_data");
$did_rs->execute();

db_close();

echo '<script type="text/javascript">setTimeout("window.close();", 1000);</script>';

//header("Location: admin_users.php");
