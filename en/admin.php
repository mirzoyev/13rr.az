<?php
include_once '../inc/predoc.php';
if (!$is_admin) {
 header("Location: index.php");
 die();
}
include_once '../inc/header.php';
include_once 'inc/admin.php';

$dbh = db_connect();


db_close();

include_once '../inc/footer.php';
?>
