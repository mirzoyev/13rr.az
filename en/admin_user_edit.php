<?php
include_once '../inc/predoc.php';
if (!$is_admin) {
    header("Location: index.php");
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

include_once '../inc/header.php';
//include_once 'inc/admin.php';

echo '<div class="index section background background-index">';
echo '<div class="container">';
echo '<div class="space space-top space-bottom">';
echo '<div class="row row-center row-wrap">';
echo '<div class="column column-1">';
echo '<div class="gap gap-4"></div>';
echo '<h5>User parameters</h5>';
echo '<div class="gap gap-2"></div>';

$checked = array("", " checked");

$dbh = db_connect();

$dgsu_rs = $dbh->prepare("execute dbo.get_site_users :id");
$dgsu_rs->bindParam(":id", $id, PDO::PARAM_INT, 0);
$dgsu_rs->execute();
if ($dbh->errorCode() == "00000") {
    echo "<form method=\"POST\" action=\"admin_save_user.php?id=" . $id . "\"><table>";
    $dgsu_login = null;
    $dgsu_full_name = null;
    $dgsu_psw = null;
    $dgsu_is_admin = null;
    $dgsu_list_users = null;
    if ($dgsu_r = $dgsu_rs->fetchObject()) {
        $dgsu_login = $dgsu_r->login;
        $dgsu_full_name = $dgsu_r->full_name;
        $dgsu_psw = $dgsu_r->psw;
        $dgsu_is_admin = $dgsu_r->is_admin;
        $dgsu_list_users = $dgsu_r->list_users;
    }
    echo "<tr><th style='width:1%'>login</th><td style=\"text-align: left;\"><input class=\"temp_input\" type=\"text\" name=\"login\" value=\"" . $dgsu_login . "\"></td></tr>";
    echo "<tr><th style='width:1%'>full&nbsp;name</th><td style=\"text-align: left;\"><input class=\"temp_input\" type=\"text\" name=\"full_name\" value=\"" . $dgsu_full_name . "\"></td></tr>";
    echo "<tr><th style='width:1%'>password</th><td style=\"text-align: left;\"><input class=\"temp_input\" type=\"text\" name=\"psw\" value=\"" . $dgsu_psw . "\"></td></tr>";
    echo "<tr><th style='width:1%'>is&nbsp;admin</th><td style=\"text-align: left;\"><input class=\"temp_input\" type=\"checkbox\" name=\"is_admin\" value=\"1\"" . $checked[intval($dgsu_is_admin)] . "></td></tr>";
    echo "<tr><th>CLU</th><td style=\"text-align: left;\"><input type=\"checkbox\" name=\"list_users\" value=\"1\" ".$checked[intval($dgsu_list_users)]."></td></tr>";
    echo "</table>";
    $checked = array("", " checked");

    $dlur_rs = $dbh->prepare("execute dbo.list_user_restaurants :id");
    $dlur_rs->bindParam(":id", $id, PDO::PARAM_INT, 0);
    $dlur_rs->execute();
    if ($dbh->errorCode() == "00000") {
        echo "<h2>Available objects</h2>";
        echo "<table>";
        while ($dlur_r = $dlur_rs->fetchObject()) {
            echo "<tr>";
            echo "<td style='width:1%'><input type=\"checkbox\" name=\"checked" . $dlur_r->id . "\" value=\"1\"" . $checked[$dlur_r->checked] . ">";
            echo "<input type=\"hidden\" name=\"restaurant[]\" value=\"" . $dlur_r->id . "\"></td>";
            echo "<td style=\"text-align: left;\">" . $dlur_r->title . "&nbsp;(" . $dlur_r->status . ")</td>";
            echo "</tr>";
        }
        echo "</table>";
        unset($dlur_rs);
    }
    echo "<input class='temp_submit' type=\"submit\" value=\"Save\"></form>";
    unset($dgsu_rs);
}

db_close();

echo '<div class="gap gap-2"></div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

include_once '../inc/footer.php';
