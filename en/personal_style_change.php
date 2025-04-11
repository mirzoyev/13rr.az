<?php
include_once '../inc/predoc.php';
setcookie("style", "../".$_GET["s"].".css", time() + 3600*24*30*12, "/");

header("Location: personal_style.php");
?>
