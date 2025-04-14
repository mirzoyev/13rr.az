<?php

include_once '../inc/predoc.php';
include_once '../inc/filter_get.php';

$navigation[0] = [
    'name' => 'home',
    'link' => '',
    'active' => true
];

include_once '../inc/header.php';

//include_once 'inc/main.php';
//include_once 'inc/filter.php';
//test

$graph_id = 'payment';
if (isset($_GET['graph_id'])) {
    $graph_id = $_GET['graph_id'];
}

$graph = [
    'names' => [],
    'results' => [],
    'title' => '&nbsp;' . $loc[$language]['table_' . $graph_id] . ' (%)'
];

echo '<div class="index section background background-index">';
echo '<div class="container">';
echo '<div class="space space-top space-bottom">';
echo '<div class="row row-center row-wrap">';
echo '<div class="column column-1">';

echo '<div class="gap gap-4"></div>';
echo '<h5>' . $loc[$language]['total'] . '</h5>';
echo '<div class="gap gap-2"></div>';

echo '<table class="data_table2">';
echo '<thead>';
echo '<tr class="invisible">';
if ($mobile) {
    //2 1
    echo '<th style="width:50%">&nbsp;</th>';
    echo '<th style="width:25%">&nbsp;</th>';
    echo '<th style="width:25%">&nbsp;</th>';
} else {
    //2.5 1
    echo '<th style="width:15%">&nbsp;</th>';
    echo '<th style="width:10%">&nbsp;</th>';
    echo '<th style="width:10%">&nbsp;</th>';
    echo '<th style="width:10%">&nbsp;</th>';
    echo '<th style="width:10%">&nbsp;</th>';
    echo '<th style="width:10%">&nbsp;</th>';
    echo '<th style="width:10%">&nbsp;</th>';
    echo '<th style="width:10%">&nbsp;</th>';
}
echo '</tr>';
echo '<tr>';
echo '<th>';
echo $loc[$language]['table_restaurant'];
echo '</th>';
echo '<th>';
echo '<a href="index.php?graph_id=guests">';
echo $loc[$language]['table_guests'];
echo '</a>';
echo '</th>';
if (!$mobile) {
    echo '<th>';
    echo '<a href="index.php?graph_id=avg_bill">';
    //temp table_name_fix
    $loc[$language]['table_avg_bill'] = $loc[$language]['avg_bill'];
    echo $loc[$language]['table_avg_bill'];
    echo '</a>';
    echo '</th>';
    echo '<th>';
    echo '<a href="index.php?graph_id=amount">';
    echo $loc[$language]['table_amount'];
    echo '</a>';
    echo '</th>';
    echo '<th>';
    echo '<a href="index.php?graph_id=discount">';
    echo $loc[$language]['table_discount'];
    echo '</a>';
    echo '</th>';
    echo '<th>';
    echo '<a href="index.php?graph_id=charge">';
    echo $loc[$language]['table_charge'];
    echo '</a>';
    echo '</th>';
}
echo '<th>';
echo '<a href="index.php?graph_id=payment">';
echo $loc[$language]['table_payment'];
echo '</a>';
echo '</th>';
if (!$mobile) {
    echo '<th>';
    echo '<a href="index.php?graph_id=complimentary">';
    //temp table_name_fix
    $loc[$language]['table_complimentary'] = $loc[$language]['compl'];
    echo $loc[$language]['compl'];
    echo '</a>';
    echo '</th>';
}
echo '</tr>';
echo '</thead>';
echo '<tbody>';

if ($r) {
    $r_name = restaurant_name($r);
} else $r_name = "";

if ($r_name) $r_name = "restaurant: " . $r_name;

//echo "<h3>from: $d1 till: $d2 $r_name</h3>";
//echo $d1;
//echo '<br>';

$dbh = db_connect();

$drt_rs = $dbh->prepare("execute dbo.rep_totals :usr, :d1, :d2, :r");
$drt_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drt_rs->bindParam(":d1", $d1_prev, PDO::PARAM_STR, 0);
$drt_rs->bindParam(":d2", $d2_prev, PDO::PARAM_STR, 0);
$drt_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drt_rs->execute();
$previous_payment = 0;
if ($dbh->errorCode() == "00000") {
    while ($drt_r = $drt_rs->fetchObject()) {
        $previous_payment = $drt_r->paysum;
    }
    unset($drt_rs);
}
//$previous_payment = $previous_payment * 4;

$drvs_rs = $dbh->prepare("execute dbo.rep_visits_stat :usr, :d1, :d2, :r");
$drvs_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drvs_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drvs_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drvs_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drvs_rs->execute();
if ($dbh->errorCode() == "00000") {
    $q = 0;
    $a = 0;
    $p = 0;
    $d = 0;
    $c = 0;
    $v = 0;
    $g = 0;
    $h = 0;

    while ($drvs_r = $drvs_rs->fetchObject()) {
        $restaurant_name = ucwords(strtolower($drvs_r->restaurant));
        $restaurant_results = my_money($drvs_r->paysum);

        //print_r($drvs_r);
        $table_data = [
            'guests' => $drvs_r->guestscount,
            'avg_bill' => my_money($drvs_r->avg_price),
            'amount' => my_money($drvs_r->pricesum),
            'discount' => my_money($drvs_r->discounts),
            'charge' => my_money($drvs_r->charges),
            'payment' => my_money($drvs_r->paysum),
            'complimentary' => my_money($drvs_r->complimentary)
        ];
        echo '<tr>';
        echo '<td>';
        echo '<a href="restaurant.php?restaurant_id=' . $drvs_r->r_id . '">' . $restaurant_name . '</a>';
        echo '</td>';
        echo '<td>';
        echo $table_data['guests'];
        echo '</td>';
        if (!$mobile) {
            echo '<td>';
            echo $table_data['avg_bill'];
            echo '</td>';
            echo '<td>';
            echo $table_data['amount'];
            echo '</td>';
            echo '<td>';
            echo $table_data['discount'];
            echo '</td>';
            echo '<td>';
            echo $table_data['charge'];
            echo '</td>';
        }
        echo '<td>';
        echo $table_data['payment'];
        echo '</td>';
        if (!$mobile) {
            echo '<td>';
            echo $table_data['complimentary'];
            echo '</td>';
        }
        echo '</tr>';

        $graph_restaurant_name = str_replace('\'', '', $restaurant_name);
        $graph['names'][] = $graph_restaurant_name;

        $rounded_number = $table_data[$graph_id];
        $rounded_number = str_replace(',', '', $rounded_number);
        //$rounded_number = str_replace('.', ',', $rounded_number);
        $rounded_number = round($rounded_number);
        $graph['results'][] = $rounded_number;

        $v += $drvs_r->visits;
        $g += $drvs_r->guestscount;
        $q += $drvs_r->quantity;
        $a += $drvs_r->pricesum;
        $p += $drvs_r->paysum;
        $d += $drvs_r->discounts;
        $c += $drvs_r->charges;
        $h += $drvs_r->complimentary;
    }
    if (!$r && $q) {
        echo '</tbody>';
        echo '<tfoot>';
        echo '<tr>';
        echo '<td>';
        echo $loc[$language]['table_total'] . ':';
        echo '</td>';
        echo '<td>';
        echo $g;
        echo '</td>';
        if (!$mobile) {
            echo '<td>';
            echo my_money($a / $g);
            echo '</td>';
            echo '<td>';
            echo my_money($a);
            echo '</td>';
            echo '<td>';
            echo my_money($d);
            echo '</td>';
            echo '<td>';
            echo my_money($c);
            echo '</td>';
        }
        echo '<td>';
        echo my_money($p);
        echo '</td>';
        if (!$mobile) {
            echo '<td style="padding-right:4px">';
            echo my_money($h);
            echo '&nbsp;';
            echo '</td>';
        }
        echo '</tr>';

        $current_payment = $p;
        $difference_color = 'black';
        $difference = $current_payment - $previous_payment;
        if ($previous_payment) {
            $difference_percent = round($difference / $previous_payment, 4) * 100 . '%';
            if ($difference > 0) {
                $difference_percent = '+' . $difference_percent;
                $difference_color = 'green';
            } else if ($difference < 0) {
                $difference_color = 'red';
            }
        }

        echo '<tr style="background: white">';
        echo '<td>';
        echo '&nbsp;';
        echo '</td>';
        echo '<td>';
        echo '&nbsp;';
        echo '</td>';
        if (!$mobile) {
            echo '<td>';
            echo '&nbsp;';
            echo '</td>';
            echo '<td>';
            echo '&nbsp;';
            echo '</td>';
            echo '<td>';
            echo '&nbsp;';
            echo '</td>';
            echo '<td>';
            echo '&nbsp;';
            echo '</td>';
        }
        echo '<td>';
        echo $loc[$language]['previous'];
        echo ': ';
        echo '<br>';
        echo '<span style="color:' . $difference_color . ';font-weight:600;">';
        echo $difference_percent;
        echo '</span>';
        echo '</td>';
        if (!$mobile) {
            echo '<td style="padding-right:4px">';
            echo '&nbsp;';
            echo '&nbsp;';
            echo '</td>';
        }
        echo '</tr>';

        echo '</tfoot>';
    }
    //echo "</table>";
    unset($drvs_rs);
}
db_close();

echo '</table>';

echo '<div class="gap gap-4"></div>';

echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';


if (!empty($graph['results'])) {
    $graph_sum = array_sum($graph['results']);
    $graph['percents'] = [];
    foreach ($graph['results'] as $result) {
        if ($graph_sum) {
            $graph['percents'][] = my_number(($result / $graph_sum) * 100, 2) . '';
        } else {
            $graph['percents'][] = 0;
        }
    }
    //print_r($graph);

    echo '<div class="index section background background-index">';
    echo '<div class="container">';
    echo '<div class="space space-top space-bottom">';

    echo '<div class="row row-center row-wrap">';
    echo '<div class="column column-1">';
    echo '<div class="gap gap-4"></div>';
    echo '<h5>' . $loc[$language]['graph'] . ': ' . $loc[$language]['table_' . $graph_id] . '</h5>';
    echo '<div class="gap gap-2"></div>';

    echo '<div class="row row-center">';
    echo '<div class="column column-1 column-small-2-3 column-medium-1-2 column-large-1-3">';
    echo '<div><canvas id="myChart" data-graph=\'' . json_encode($graph) . '\'></canvas></div>';
    echo '</div>';
    echo '</div>';

    echo '<div class="gap gap-4"></div>';
    echo '</div>';
    echo '</div>';

    echo '</div>';
    echo '</div>';
    echo '</div>';
}

include_once '../inc/footer.php';
