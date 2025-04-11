<?php
include_once '../inc/predoc.php';

$dbh = db_connect();

$ddb_rs = $dbh->prepare("execute dbo.del_bouquets :id, :usr");
$ddb_rs->bindParam(":id", $id, PDO::PARAM_INT, 0);
$ddb_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$ddb_rs->execute();

db_close();

header("Location: personal_bouquets.php");
