<?php
setcookie("login", "", time() - 3600*24*30*12, "/");
setcookie("sign", "", time() - 3600*24*30*12, "/");
header("Location: index.php"); exit();
?>
