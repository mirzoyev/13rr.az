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
$navigation[1] = [
    'name' => '',
    'link' => ''
];
$navigation[2] = [
    'name' => '',
    'link' => ''
];
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
echo '<h5>Users Online</h5>';
echo '<div class="gap gap-2"></div>';

$dbh = db_connect();

$dsul_rs = $dbh->prepare("select dsul.id, dsul.full_name, dsul.online, dsul.last_report_request, dsul.last_report_proc from dbo.site_users_list as dsul");
$dsul_rs->execute();
if ($dbh->errorCode() == "00000") {
    echo '<table class="data_table">';
    echo '<thead>';
    echo '<tr><th>user</th><th align="center">online</th><th align="center">last&nbsp;report&nbsp;request</th><th>last&nbsp;report&nbsp;name</th></tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($dsul_r = $dsul_rs->fetchObject()) {
        echo '<tr>';
        echo '<td>';
        echo $dsul_r->full_name;
        echo '</td>';
        echo '<td align="center">';
        echo show_bool($dsul_r->online);
        echo '</td>';
        echo '<td align="center">';
        echo '<nobr>';
        echo $dsul_r->last_report_request;
        echo '</nobr>';
        echo '</td>';
        echo '<td>';
        echo $dsul_r->last_report_proc;
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    unset($dsu_rs);
}

db_close();

include_once '../inc/footer.php';
