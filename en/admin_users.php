<?php
include_once '../inc/predoc.php';
if (!$is_admin) {
    header("Location: index.php");
    die();
}

$navigation[0] = [
    'name' => 'back',
    'link' => 'index.php'
];
if ($is_admin) {
    $navigation[1] = [
        'name' => 'refresh',
        'link' => 'admin_do_import.php',
        'target' => true
    ];

    $navigation[2] = [
        'name' => 'user',
        'link' => '',
        'active' => true
    ];

    $navigation[3] = [
        'name' => 'live',
        'link' => 'admin_online.php'
    ];
}

include_once '../inc/header.php';
//include_once 'inc/admin.php';

echo '<div class="index section background background-index">';
echo '<div class="container">';
echo '<div class="space space-top space-bottom">';
echo '<div class="row row-center row-wrap">';
echo '<div class="column column-1">';

echo '<div class="gap gap-4"></div>';
echo '<h5>Users</h5>';
echo '<div class="gap gap-2"></div>';

$dbh = db_connect();

$dsu_rs = $dbh->prepare("select dsu.id, dsu.login, dsu.full_name, dsu.is_admin, dsu.list_users from dbo.site_users as dsu");
$dsu_rs->execute();
if ($dbh->errorCode() == "00000") {
    echo '<table class="data_table">';
    echo '<thead>';
    echo '<tr><th>login</th><th>full&nbsp;name</th><th>is&nbsp;admin</th><th>CLU</th><th>action</th></tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($dsu_r = $dsu_rs->fetchObject()) {
        echo '<tr>';
        echo '<td>';
        echo $dsu_r->login;
        echo '</td>';
        echo '<td>';
        echo $dsu_r->full_name;
        echo '</td>';
        echo '<td align="center">';
        echo show_bool($dsu_r->is_admin);
        echo '</td>';
        echo '<td align="center">';
        echo show_bool($dsu_r->list_users);
        echo '</td>';
        echo '<td>';
        echo '<a href="admin_user_edit.php?id=' . $dsu_r->id . '">edit</a>&nbsp;';
        echo '<a href="admin_del_user.php?id=' . $dsu_r->id . '">delete</a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '<a href="admin_user_edit.php?id=0">add&nbsp;new</a>';
    unset($dsu_rs);
}

db_close();

echo '<div class="gap gap-2"></div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

include_once '../inc/footer.php';
