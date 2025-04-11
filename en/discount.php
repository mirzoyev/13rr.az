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
    'link' => 'index.php'
];
$navigation[1] = [
    'name' => 'restaurant',
    'link' => 'restaurant.php?restaurant_id=' . $r,
];
$navigation[2] = [
    'name' => 'manat',
    'link' => 'payment.php?restaurant_id=' . $r
];
$navigation[3] = [
    'name' => 'plusminus',
    'link' => '',
    'active' => true
];
$navigation[4] = [
    'name' => '',
    'link' => ''
];

include_once '../inc/header.php';

//if ($r_name) $r_name = "restaurant: " . $r_name;

$graph = [
    'names' => [],
    'results' => [],
    'title' => '&nbsp;' . $loc[$language]['table_payment']
];

//echo "<h1>Discounts and charges</h1>";
//echo "<h3>from: $d1 till: $d2 $r_name</h3>";

$dbh = db_connect();

echo '<div class="index section background background-index">';
echo '<div class="container">';
echo '<div class="space space-top space-bottom">';
echo '<div class="row row-center row-wrap">';
echo '<div class="column column-1">';

echo '<div class="gap gap-4"></div>';
echo '<h5>' . ucwords(strtolower($r_name)) . ': ' . $loc[$language]['discount'] . '</h5>';
echo '<div class="gap gap-2"></div>';

echo '<table>';
echo '<thead>';
echo '<tr class="invisible">';
if ($mobile) {
    echo '<th style="width:50%">&nbsp;</th>';
    echo '<th style="width:25%">&nbsp;</th>';
    echo '<th style="width:25%">&nbsp;</th>';
} else {
    echo '<th style="width:60%">&nbsp;</th>';
    echo '<th style="width:20%">&nbsp;</th>';
    echo '<th style="width:20%">&nbsp;</th>';
}
echo '</tr>';
echo '<tr>';
echo '<th>';
echo $loc[$language]['table_title'];
echo '</th>';
echo '<th>';
echo $loc[$language]['table_discount'];
echo '</th>';
echo '<th>';
echo $loc[$language]['table_charge'];
echo '</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

if (false) {
    echo '<div class="row row-between table table-header">';
    echo '<div class="column column-auto cell">' . $loc[$language]['table_title'] . '</div>';
    echo '<div class="column column-auto cell">' . $loc[$language]['table_discount'] . '</div>';
    echo '<div class="column column-auto cell">' . $loc[$language]['table_charge'] . '</div>';
    echo '</div>';
}

$drtd_rs = $dbh->prepare("execute dbo.rep_total_discounts :usr, :d1, :d2, :r");
$drtd_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drtd_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drtd_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drtd_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drtd_rs->execute();
if ($dbh->errorCode() == "00000") {
    $x = 0;
    $d = 0;
    $c = 0;
    $d0 = 0;
    $c0 = 0;
    //echo "<table class=\"data_table\">";
    //echo "<tr><th>title</th><th>discount</th><th>charge</th></tr>";
    while ($drtd_r = $drtd_rs->fetchObject()) {
        if ($x != $drtd_r->r_id && !$r) {
            if ($x) {
//                echo "<tr class=\"subdetails\">";
//                echo "<td>subtotal:</td>";
//                echo "<td class=\"numeric\">" . my_money($d) . "</td>";
//                echo "<td class=\"numeric\">" . my_money($c) . "</td>";
//                echo "</tr>";
            }
            $x = $drtd_r->r_id;
            //echo "<tr><td colspan=\"6\" class=\"block_description\">" . $drtd_r->restaurant . "</td></tr>";
            $d = 0;
            $c = 0;
        }

        if (false) {
            echo '<div class="row row-between table">';
            echo '<div class="column column-auto cell">' . $drtd_r->title . '</div>';
            echo '<div class="column column-auto cell">' . my_money($drtd_r->discount) . '</div>';
            echo '<div class="column column-auto cell">' . my_money($drtd_r->charge) . '</div>';
            echo '</div>';
        }

        echo '<tr>';
        echo '<td>';
        echo $drtd_r->title;
        echo '</td>';
        echo '<td>';
        echo my_money($drtd_r->discount);
        echo '</td>';
        echo '<td>';
        echo my_money($drtd_r->charge);
        echo '</td>';
        echo '</tr>';

//        echo "<tr>";
//        echo "<td>" . $drtd_r->title . "</td>";
//        echo "<td class=\"numeric\">" . my_money($drtd_r->discount) . "</td>";
//        echo "<td class=\"numeric\">" . my_money($drtd_r->charge) . "</td>";
//        echo "</tr>";
        $d += $drtd_r->discount;
        $c += $drtd_r->charge;
        $d0 += $drtd_r->discount;
        $c0 += $drtd_r->charge;
    }
    if ($x) {
//        echo "<tr class=\"subdetails\">";
//        echo "<td>subtotal:</td>";
//        echo "<td class=\"numeric\">" . my_money($d) . "</td>";
//        echo "<td class=\"numeric\">" . my_money($c) . "</td>";
//        echo "</tr>";
    }

    if (false) {
        echo '<div class="row row-between table table-footer">';
        echo '<div class="column column-auto cell">' . $loc[$language]['table_total'] . ':</div>';
        echo '<div class="column column-auto cell">' . my_money($d0) . '</div>';
        echo '<div class="column column-auto cell">' . my_money($c0) . '</div>';
        echo '</div>';
    }

    echo '</tbody>';
    echo '<tfoot>';
    echo '<tr>';
    echo '<td>';
    echo $loc[$language]['table_total'] . ':';
    echo '</td>';
    echo '<td>';
    echo my_money($d0);
    echo '</td>';
    echo '<td style="padding-right:4px">';
    echo my_money($c0);
    echo '&nbsp;';
    echo '</td>';
    echo '</tr>';
    echo '</tfoot>';

//    echo "<tr class=\"block_footer\">";
//    echo "<td>total:</td>";
//    echo "<td class=\"numeric\">" . my_money($d0) . "</td>";
//    echo "<td class=\"numeric\">" . my_money($c0) . "</td>";
//    echo "</tr>";
//    echo "</table>";

    unset($drtd_rs);
}

echo '</table>';
echo '<div class="gap gap-4"></div>';

echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

db_close();

include_once '../inc/footer.php';
