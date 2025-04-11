<?php
include_once '../inc/predoc.php';
include_once '../inc/filter_get.php';

$r = 0;
if ($_GET['restaurant_id']) {
    $r = $_GET['restaurant_id'];
}

if ($r) {
    $r_name = restaurant_name($r);
} else $r_name = "";

$navigation[0] = [
    'name' => 'back',
    'link' => 'restaurant.php?restaurant_id=' . $_GET['restaurant_id']
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
$navigation[4] = [
    'name' => '',
    'link' => ''
];

include_once '../inc/header.php';

if ($r_name) $r_name = "restaurant: " . $r_name;

$dbh = db_connect();

$graph = [
    'names' => [],
    'results' => [],
    'title' => '&nbsp;Top 10'
];


echo '<div class="index section background background-index">';
echo '<div class="container">';
echo '<div class="space space-top space-bottom">';
echo '<div class="row row-center row-wrap">';
echo '<div class="column column-1">';

// first table
echo '<div class="gap gap-4"></div>';
echo '<h5> ' . ucwords(strtolower($r_name)) . ': ' . $loc[$language]['by_amount'] . '</h5>';
echo '<div class="gap gap-2"></div>';

echo '<table class="data_table2">';
echo '<thead>';
echo '<tr class="invisible">';
if ($mobile) {
    echo '<th style="width:50%">&nbsp;</th>';
    echo '<th style="width:25%">&nbsp;</th>';
    echo '<th style="width:25%">&nbsp;</th>';
} else {
    echo '<th style="width:22%">&nbsp;</th>';
    echo '<th style="width:13%">&nbsp;</th>';
    echo '<th style="width:13%">&nbsp;</th>';
    echo '<th style="width:13%">&nbsp;</th>';
    echo '<th style="width:13%">&nbsp;</th>';
    echo '<th style="width:13%">&nbsp;</th>';
    echo '<th style="width:13%">&nbsp;</th>';
}
echo '</tr>';
echo '<tr>';
echo '<th>';
echo $loc[$language]['table_title'];
echo '</th>';
echo '<th>';
echo $loc[$language]['table_quantity'];
echo '</th>';
if (!$mobile) {
    echo '<th>';
    echo $loc[$language]['table_average'];
    echo '</th>';
    echo '<th>';
    echo $loc[$language]['table_amount'];
    echo '</th>';
    echo '<th>';
    echo $loc[$language]['table_discount'];
    echo '</th>';
    echo '<th>';
    echo $loc[$language]['table_charge'];
    echo '</th>';
}
echo '<th>';
echo $loc[$language]['table_payment'];
echo '</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

$drtda_rs = $dbh->prepare("execute dbo.rep_top_dish_amount :usr, :d1, :d2, :r");
$drtda_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drtda_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drtda_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drtda_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drtda_rs->execute();
if ($dbh->errorCode() == "00000") {
    //echo "<tr><td colspan=\"7\" class=\"block_description\">By amount</td></tr>";
    while ($drtda_r = $drtda_rs->fetchObject()) {
        echo '<tr>';
        echo '<td>';
        echo $drtda_r->dish;
        echo '</td>';
        echo '<td>';
        echo my_number($drtda_r->quantity, 0);
        echo '</td>';

        if (!$mobile) {
            echo '<td>';
            echo my_money($drtda_r->avg_price);
            echo '</td>';
            echo '<td>';
            echo my_money($drtda_r->amount);
            echo '</td>';
            echo '<td>';
            echo my_money($drtda_r->discount);
            echo '</td>';
            echo '<td>';
            echo my_money($drtda_r->charge);
            echo '</td>';
        }

        echo '<td>';
        echo my_money($drtda_r->payment);
        echo '</td>';
        echo '</tr>';
    }
    unset($drtda_rs);
}
echo '</tbody>';
echo '</table>';
//echo '<div class="gap gap-4"></div>';

// second table

echo '<div class="gap gap-4"></div>';
echo '<h5> ' . ucwords(strtolower($r_name)) . ': ' . $loc[$language]['boy_by_amount'] . '</h5>';
echo '<div class="gap gap-2"></div>';

echo '<table class="data_table2">';
echo '<thead>';
echo '<tr class="invisible">';
if ($mobile) {
    echo '<th style="width:50%">&nbsp;</th>';
    echo '<th style="width:25%">&nbsp;</th>';
    echo '<th style="width:25%">&nbsp;</th>';
} else {
    echo '<th style="width:22%">&nbsp;</th>';
    echo '<th style="width:13%">&nbsp;</th>';
    echo '<th style="width:13%">&nbsp;</th>';
    echo '<th style="width:13%">&nbsp;</th>';
    echo '<th style="width:13%">&nbsp;</th>';
    echo '<th style="width:13%">&nbsp;</th>';
    echo '<th style="width:13%">&nbsp;</th>';
}
echo '</tr>';
echo '<tr>';
echo '<th>';
//echo $loc[$language]['table_title'];
echo '__Name';
echo '</th>';
echo '<th>';
echo $loc[$language]['table_quantity'];
echo '</th>';
if (!$mobile) {
    echo '<th>';
    echo $loc[$language]['table_average'];
    echo '</th>';
    echo '<th>';
    echo $loc[$language]['table_amount'];
    echo '</th>';
    echo '<th>';
    echo $loc[$language]['table_discount'];
    echo '</th>';
    echo '<th>';
    echo $loc[$language]['table_charge'];
    echo '</th>';
}
echo '<th>';
echo $loc[$language]['table_payment'];
echo '</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

$drtba_rs = $dbh->prepare("execute dbo.rep_top_boy_amount :usr, :d1, :d2, :r");
$drtba_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drtba_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drtba_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drtba_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drtba_rs->execute();
if ($dbh->errorCode() == "00000") {
    //echo "<tr><td colspan=\"7\" class=\"block_description\">Boys by amount</td></tr>";
    while ($drtba_r = $drtba_rs->fetchObject()) {
        echo '<tr>';
        echo '<td>';
        echo $drtba_r->boy;
        echo '</td>';
        echo '<td>';
        echo my_number($drtba_r->quantity, 0);
        echo '</td>';

        if (!$mobile) {
            echo '<td>';
            echo my_money($drtba_r->avg_price);
            echo '</td>';
            echo '<td>';
            echo my_money($drtba_r->amount);
            echo '</td>';
            echo '<td>';
            echo my_money($drtba_r->discount);
            echo '</td>';
            echo '<td>';
            echo my_money($drtba_r->charge);
            echo '</td>';
        }

        echo '<td>';
        echo my_money($drtba_r->payment);
        echo '</td>';
        echo '</tr>';
    }
    unset($drtba_rs);
}

echo '</tbody>';
echo '</table>';
//echo '<div class="gap gap-4"></div>';

echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

db_close();

include_once '../inc/footer.php';
