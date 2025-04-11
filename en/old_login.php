<!DOCTYPE html><html>
<head>
<meta charset="utf-8" />
<title>Login to reporting</title>
<link rel="stylesheet" type="text/css" href="../main.css" />
</head>
<body>
<form method="POST" action="do_login.php" class="login_form">
 <div class="welcome">Welcome to reporting!</div>
 <input type="text" name="login" value="<?php echo $_COOKIE['login'] ?>">
 <input type="password" name="password" value="">
 <input type="submit" value="login">
</form>
</body>
</html>
