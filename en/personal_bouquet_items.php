<?php
include_once '../inc/predoc.php';
//include_once 'inc/personal.php';

$navigation[0] = [
    'name' => 'back',
    'link' => 'personal_bouquets.php'
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
echo '<h5>__Bouquet items</h5>';
echo '<div class="gap gap-2"></div>';

$dbh = db_connect();

$dgbi_rs = $dbh->prepare('execute dbo.get_bouquet_info :id, :usr');
$dgbi_rs->bindParam(':id', $id, PDO::PARAM_INT, 0);
$dgbi_rs->bindParam(':usr', $user_id, PDO::PARAM_INT, 0);
$dgbi_rs->execute();
if ($dbh->errorCode() == '00000') {
    while ($dgbi_r = $dgbi_rs->fetchObject()) {
        //echo '<h1>Bouquet items</h1>';
        echo '<h6>' . $dgbi_r->restaurant . '&nbsp;/ ';
        echo $dgbi_r->class_group . '&nbsp;/ ';
        echo $dgbi_r->description . '</h6>';

        $dlubd_rs = $dbh->prepare('execute dbo.list_user_bouquet_details :id, :usr');
        $dlubd_rs->bindParam(':id', $id, PDO::PARAM_INT, 0);
        $dlubd_rs->bindParam(':usr', $user_id, PDO::PARAM_INT, 0);
        $dlubd_rs->execute();
        if ($dbh->errorCode() == '00000') {
            echo '<table class="data_table">';
            echo '<tr><th>title</th><th colspan="2">action</th></tr>';
            while ($dlubd_r = $dlubd_rs->fetchObject()) {
                echo '<tr>';
                echo '<td>' . $dlubd_r->title . '</td>';
                echo '<td><a href="personal_bouquet_item_edit.php?id=' . $dlubd_r->id . '&b=' . $id . '">edit</a></td>';
                echo '<td><a href="personal_bouquet_item_delete.php?id=' . $dlubd_r->id . '&b=' . $id . '">delete</a></td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '<a href="personal_bouquet_item_edit.php?b=' . $id . '">add&nbsp;new</a>';
            unset($dlubd_rs);
        }

    }
    unset($dgbi_rs);
}

echo '<div class="gap gap-2"></div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

include_once '../inc/footer.php';
