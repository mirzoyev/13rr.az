<?php
include_once '../inc/predoc.php';
include_once '../inc/filter_get.php';

$r = 0;
if ($_GET['restaurant_id']) {
    $r = $_GET['restaurant_id'];
}

$graph_id = 'payment';
if (isset($_GET['graph_id'])) {
    $graph_id = $_GET['graph_id'];
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
    'link' => 'restaurant.php?restaurant_id=' . $r
];
$navigation[2] = [
    'name' => 'manat',
    'link' => 'payment.php?restaurant_id=' . $r
];
$navigation[3] = [
    'name' => 'plusminus',
    'link' => 'discount.php?restaurant_id=' . $r
];
$navigation[4] = [
    'name' => 'top10',
    'link' => 'category_top.php?restaurant_id=' . $r
];
$navigation[5] = [
    'name' => 'calendar',
    'link' => 'sales_stat.php?restaurant_id=' . $r,
    'active' => true
];

$months = [
    1 => 'January',
    2 => 'February',
    3 => 'March',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December'
];

include_once '../inc/header.php';

$dbh = db_connect();

$graph = [
    'names' => [],
    'results' => [],
    'title' => '&nbsp;' . $loc[$language]['table_' . $graph_id] . '' // (%)
];

// empty graph here

//echo "<h1>Sales statistics</h1>";
//echo "<h3>from: $d1 till: $d2 $r_name</h3>";

echo '<div class="index section background background-index">';
echo '<div class="container">';
echo '<div class="space space-top space-bottom">';
echo '<div class="row row-center row-wrap">';
echo '<div class="column column-1">';

echo '<div class="gap gap-4"></div>';

//temp phrase
$loc[$language]['restaurant'] = 'sales per month';
echo '<h5> ' . ucwords(strtolower($r_name)) . ': ' . $loc[$language]['restaurant'] . '</h5>';
echo '<div class="gap gap-2"></div>';

echo '<table class="data_table2">';
echo '<thead>';
echo '<tr class="invisible">';
if ($mobile) {
    //echo '<th style="width:50%">&nbsp;</th>';
    echo '<th style="width:25%">&nbsp;</th>';
    echo '<th style="width:25%">&nbsp;</th>';
} else {
    echo '<th style="width:20%">&nbsp;</th>';
    echo '<th style="width:16%">&nbsp;</th>';
    echo '<th style="width:16%">&nbsp;</th>';
    echo '<th style="width:16%">&nbsp;</th>';
    echo '<th style="width:16%">&nbsp;</th>';
    echo '<th style="width:16%">&nbsp;</th>';
}
echo '</tr>';
echo '<tr>';
//echo '<th>';
//echo $loc[$language]['table_title'];
//echo '</th>';
echo '<th>';
//temp table phrase
$loc[$language]['table_year'] = 'Month';
echo $loc[$language]['table_year'];
echo '</th>';
//echo '<th>';
////temp table phrase
//$loc[$language]['table_month'] = 'Month';
//echo $loc[$language]['table_month'];
//echo '</th>';
if (!$mobile) {
    echo '<th>';
    //echo '<a href="sales_stat.php?restaurant_id=' . $r . '&graph_id=amount">';
    echo $loc[$language]['table_amount'];
    //echo '</a>';
    echo '</th>';
    echo '<th>';
    //echo '<a href="sales_stat.php?restaurant_id=' . $r . '&graph_id=discount">';
    echo $loc[$language]['table_discount'];
    //echo '</a>';
    echo '</th>';
    echo '<th>';
    //echo '<a href="sales_stat.php?restaurant_id=' . $r . '&graph_id=charge">';
    echo $loc[$language]['table_charge'];
    //echo '</a>';
    echo '</th>';
}
echo '<th>';
//echo '<a href="sales_stat.php?restaurant_id=' . $r . '&graph_id=payment">';
echo $loc[$language]['table_payment'];
//echo '</a>';
echo '</th>';
if (!$mobile) {
    echo '<th>';
    //echo '<a href="sales_stat.php?restaurant_id=' . $r . '&graph_id=complimentary">';
    //temp table_name_fix
    $loc[$language]['table_complimentary'] = $loc[$language]['compl'];
    echo $loc[$language]['compl'];
    //echo '</a>';
    echo '</th>';
}
echo '</tr>';
echo '</thead>';
echo '<tbody>';

// temp end of table
//echo '</tbody>';
//echo "</table>";

$drspm_rs = $dbh->prepare("execute dbo.rep_stat_per_month :usr, :d1, :d2, :r");
$drspm_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drspm_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drspm_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drspm_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drspm_rs->execute();
if ($dbh->errorCode() == "00000") {
//echo "<table>";
//echo "<tr><th>restaurant_name</th><th>restaurant</th><th>y</th><th>m</th><th>tables</th><th>guestscount</th><th>pricesum</th><th>paysum</th><th>quantity</th><th>discounts</th><th>charges</th><th>complimentary</th></tr>";
//echo "<tr><th>y</th><th>m</th><th>guestscount</th><th>pricesum</th><th>discounts</th><th>charges</th><th>paysum</th><th>complimentary</th></tr>";

while ($drspm_r = $drspm_rs->fetchObject()) {
//echo "<tr>";
//echo "<td>".$drspm_r->restaurant_name."</td>";
//echo "<td>".$drspm_r->restaurant."</td>";
//echo "<td>".$drspm_r->y."</td>";
//echo "<td>".$drspm_r->m."</td>";
//echo "<td>".$drspm_r->tables."</td>";
//echo "<td>".$drspm_r->guestscount."</td>";
//echo "<td>".$drspm_r->pricesum."</td>";
//echo "<td>".$drspm_r->quantity."</td>";
//echo "<td>".$drspm_r->discounts."</td>";
//echo "<td>".$drspm_r->charges."</td>";
//echo "<td>".$drspm_r->paysum."</td>";
//echo "<td>".$drspm_r->complimentary."</td>";
//echo "</tr>";

    $table_data = [
        //'restaurant_name' => $drspm_r->restaurant_name,
        //'restaurant_id' => $drspm_r->restaurant,
        'year' => $drspm_r->y,
        'month' => $drspm_r->m,
        //'tables' => $drspm_r->tables,
        'guests' => $drspm_r->guestscount,
        'amount' => $drspm_r->pricesum,
        //'quantity' => $drspm_r->quantity,
        'discount' => $drspm_r->discounts,
        'charge' => $drspm_r->charges,
        'payment' => $drspm_r->paysum,
        'complimentary' => $drspm_r->complimentary
    ];

    echo '<tr>';
    echo '<td>';
    echo $months[$table_data['month']];
    echo ' ';
    echo $table_data['year'];
    echo '</td>';
//    echo '<td>';
//    echo $table_data['month'];
//    echo '</td>';
    if (!$mobile) {
        echo '<td class="numeric">';
        echo $table_data['amount'];
        echo '</td>';
        echo '<td class="numeric">';
        echo $table_data['discount'];
        echo '</td>';
        echo '<td class="numeric">';
        echo $table_data['charge'];
        echo '</td>';
    }
    echo '<td class="numeric">';
    echo $table_data['payment'];
    echo '</td>';
    if (!$mobile) {
        echo '<td class="numeric">';
        echo $table_data['complimentary'];
        echo '</td>';
    }
    echo '</tr>';


    $rounded_number = $table_data[$graph_id];
    $rounded_number = str_replace(',', '', $rounded_number);
    //$rounded_number = str_replace('.', ',', $rounded_number);
    $rounded_number = round($rounded_number);

    $graph['results'][] = $rounded_number;

    $graph_name = str_replace('\'', '', $months[$table_data['month']]);
    $graph['names'][] = $graph_name;
}

//echo "</table>";

    unset($drspm_rs);
}

echo '</table>';


echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="gap gap-4"></div>';

if (!empty($graph['results'])) {
    $graph_sum = array_sum($graph['results']);
    //$graph['percents'] = [];
    foreach ($graph['results'] as $result) {
        if ($graph_sum) {
            //$graph['percents'][] = my_number(($result / $graph_sum) * 100, 2) . '';
        } else {
            //$graph['percents'][] = 0;
        }
    }

    echo '<div class="index section background background-index">';
    echo '<div class="container">';
    echo '<div class="space space-top space-bottom">';

    echo '<div class="row row-center row-wrap">';
    echo '<div class="column column-1">';
    echo '<div class="gap gap-2"></div>';
    echo '<h5>' . $loc[$language]['graph'] . ': ' . $loc[$language]['table_' . $graph_id] . '</h5>';
    echo '<div class="gap gap-2"></div>';

    echo '<div class="row row-center">';
    echo '<div class="column column-1 column-medium-2-3 column-large-1-2">';
    echo '<div><canvas id="barChart" data-graph=\'' . json_encode($graph) . '\'></canvas></div>';
    echo '</div>';
    echo '</div>';

    echo '<div class="gap gap-4"></div>';
    echo '</div>';
    echo '</div>';

    echo '</div>';
    echo '</div>';
    echo '</div>';

    echo '<div class="gap gap-4"></div>';

    echo '<div class="index section background background-index">';
    echo '<div class="container">';
    echo '<div class="space space-top space-bottom">';

    echo '<div class="row row-center row-wrap">';
    echo '<div class="column column-1">';
    echo '<div class="gap gap-2"></div>';
    echo '<h5>' . $loc[$language]['graph'] . ': ' . $loc[$language]['table_' . $graph_id] . '</h5>';
    echo '<div class="gap gap-2"></div>';

    echo '<div class="row row-center">';
    echo '<div class="column column-1 column-medium-2-3 column-large-1-2">';
    echo '<div><canvas id="lineChart" data-graph=\'' . json_encode($graph) . '\'></canvas></div>';
    echo '</div>';
    echo '</div>';

    echo '<div class="gap gap-4"></div>';
    echo '</div>';
    echo '</div>';

    echo '</div>';
    echo '</div>';
    echo '</div>';

    echo '<div class="gap gap-4"></div>';
}

db_close();

include_once '../inc/footer.php';
