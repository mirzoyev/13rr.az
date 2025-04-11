<?php
include_once '../inc/predoc.php';

$navigation[0] = [
    'name' => 'back',
    'link' => 'personal.php'
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

$scp_ok = 0;

if (isset($_POST["password"])) $psw = $_POST["password"];
else $psw = null;

if (isset($_POST["password1"])) $new_psw = $_POST["password1"];
else $new_psw = null;

if (isset($_POST["password2"])) $new_psw2 = $_POST["password2"];
else $new_psw2 = null;

if ($new_psw && $new_psw == $new_psw2) {
 $dbh = db_connect();
 $dcup_rs = $dbh->prepare("execute dbo.change_user_password :id, :old_psw, :new_psw");
 $dcup_rs->bindParam(":id", $user_id, PDO::PARAM_INT, 0);
 $dcup_rs->bindParam(":old_psw", $psw, PDO::PARAM_STR, 64);
 $dcup_rs->bindParam(":new_psw", $new_psw, PDO::PARAM_STR, 64);
 $dcup_rs->execute();
 db_close();
 $dcsu_rs = $dbh->prepare("execute dbo.check_site_users :login, :psw");
 $dcsu_rs->bindParam(":login", $login, PDO::PARAM_STR, 16);
 $dcsu_rs->bindParam(":psw", $new_psw, PDO::PARAM_STR, 64);
 $dcsu_rs->execute();
 if ($dbh->errorCode() == "00000") {
  if ($dcsu_r = $dcsu_rs->fetchObject()) {
   $sign = $dcsu_r->psw_hash;
   setcookie("sign", $sign, time() + 3600*24*30*12, "/");
   $scp_ok = 1;
  } else {
   setcookie("sign", "", time() - 3600*24*30*12, "/");
  }
  unset($dcsu_rs);
 }
}

if ($scp_ok) {
 header("Location: personal.php");
} else {
include_once '../inc/header.php';
//include_once 'inc/personal.php';
//echo $login;


    echo '<div class="index section background background-index">';
    echo '<div class="container">';
    echo '<div class="space space-top space-bottom">';
    echo '<div class="row row-center row-wrap">';
    echo '<div class="column column-1">';

    echo '<div class="gap gap-4"></div>';
    echo '<h5>Changes not saved!</h5>';
    echo '<div class="gap gap-2"></div>';

?>

<p>Go back to the <a href="personal.php">previous page</a> and try again.</p>
<?php

    echo '<div class="gap gap-2"></div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

include_once '../inc/footer.php';
}
