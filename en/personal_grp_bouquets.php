<?php
include_once '../inc/predoc.php';
//include_once '../inc/header.php';
//include_once 'inc/personal.php';

$navigation[0] = [
    'name' => 'back',
    'link' => 'personal.php'
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

echo '<div class="index section background background-index">';
echo '<div class="container">';
echo '<div class="space space-top space-bottom">';
echo '<div class="row row-center row-wrap">';
echo '<div class="column column-1">';

echo '<div class="gap gap-4"></div>';
echo '<h5>__Group bouquets</h5>';
echo '<div class="gap gap-2"></div>';

$dbh = db_connect();

$dlub_rs = $dbh->prepare("execute dbo.list_user_grp_bouquets :usr");
$dlub_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$dlub_rs->execute();
if ($dbh->errorCode() == "00000") {
    echo '<table class="data_table">';
    echo '<tr><th>description</th><th>order</th><th colspan="2">action</th></tr>';
    $r = 0;
    while ($dlub_r = $dlub_rs->fetchObject()) {
        if ($r != $dlub_r->r_id) {
            $r = $dlub_r->r_id;
            echo '<tr><td colspan="5" class="block_description" style="background: #0f9d58">' . $dlub_r->restaurant . '</td></tr>';
        }

        echo '<tr>';
        echo '<td>' . $dlub_r->description . '</td>';
        echo '<td class="numeric">' . $dlub_r->disp_order . '</td>';

        echo '<td>';
        echo '<a href="personal_grp_bouquet_edit.php?id=' . $dlub_r->id . '">edit</a>&nbsp;';
        echo '<a href="personal_grp_bouquet_delete.php?id=' . $dlub_r->id . '">delete</a>';
        echo '</td>';
        echo "</tr>";
    }
    echo '</table>';
    unset($dlub_rs);
    echo '<a href="personal_grp_bouquet_edit.php">add&nbsp;new</a>';
}

echo '<div class="gap gap-2"></div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

include_once '../inc/footer.php';
