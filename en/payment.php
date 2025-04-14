<?php
include_once '../inc/predoc.php';
include_once '../inc/filter_get.php';

$r = 0;
if ($_GET['restaurant_id']) {
    $r = $_GET['restaurant_id'];
}

if ($r) {
    $r_name = restaurant_name($r);
} else $r_name = '';

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
    'link' => '',
    'active' => true
];
$navigation[3] = [
    'name' => 'plusminus',
    'link' => 'discount.php?restaurant_id=' . $r
];

$navigation[4] = [
    'name' => '',
    'link' => ''
];

include_once '../inc/header.php';

//if ($r_name) $r_name = 'restaurant: '.$r_name;

//echo '<h1>Payments by type</h1>';
//echo '<h3>from: $d1 till: $d2 $r_name</h3>';

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
echo '<h5> ' . ucwords(strtolower($r_name)) . ': ' . $loc[$language]['payment'] . '</h5>';
echo '<div class="gap gap-2"></div>';

echo '<table>';
echo '<thead>';
echo '<tr class="invisible">';
if ($mobile) {
    echo '<th style="width:40%">&nbsp;</th>';
    echo '<th style="width:30%">&nbsp;</th>';
    //echo '<th style="width:30%">&nbsp;</th>';
} else {
    echo '<th style="width:25%">&nbsp;</th>';
    //echo '<th style="width:15%">&nbsp;</th>';
    echo '<th style="width:15%">&nbsp;</th>';
    echo '<th style="width:15%">&nbsp;</th>';
    echo '<th style="width:15%">&nbsp;</th>';
    echo '<th style="width:15%">&nbsp;</th>';
}
echo '</tr>';
echo '<tr>';
echo '<th>';
echo $loc[$language]['table_currency'];
echo '</th>';
//echo '<th>';
//echo 'Quantity';
//echo '</th>';
if (!$mobile) {
    echo '<th>';
    echo '<a href="payment.php?restaurant_id=' . $r . '&graph_id=amount">';
    echo $loc[$language]['table_amount'];
    echo '</a>';
    echo '</th>';
    echo '<th>';
    echo '<a href="payment.php?restaurant_id=' . $r . '&graph_id=discount">';
    echo $loc[$language]['table_discount'];
    echo '</a>';
    echo '</th>';
    echo '<th>';
    echo '<a href="payment.php?restaurant_id=' . $r . '&graph_id=charge">';
    echo $loc[$language]['table_charge'];
    echo '</a>';
    echo '</th>';
}
echo '<th>';
echo '<a href="payment.php?restaurant_id=' . $r . '&graph_id=payment">';
echo $loc[$language]['table_payment'];
echo '</a>';
echo '</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';


$drsbc_rs = $dbh->prepare('execute dbo.rep_sales_by_currency :usr, :d1, :d2, :r');
$drsbc_rs->bindParam(':usr', $user_id, PDO::PARAM_INT, 0);
$drsbc_rs->bindParam(':d1', $d1, PDO::PARAM_STR, 0);
$drsbc_rs->bindParam(':d2', $d2, PDO::PARAM_STR, 0);
$drsbc_rs->bindParam(':r', $r, PDO::PARAM_INT, 0);
$drsbc_rs->execute();
if ($dbh->errorCode() == '00000') {
    //echo '<table class="data_table">';
    //echo '<tr><th>currency</th><th>quantity</th><th>amount</th><th>discount</th><th>charge</th><th>payment</th></tr>';
    $x = 0;
    $x0 = 0;
    $q = 0;
    $a = 0;
    $p = 0;
    $d = 0;
    $c = 0;
    $q0 = 0;
    $a0 = 0;
    $p0 = 0;
    $d0 = 0;
    $c0 = 0;
    $q1 = 0;
    $a1 = 0;
    $p1 = 0;
    $d1 = 0;
    $c1 = 0;
    $pr = '';

    $temp_currency = '';
    $temp_id = 0;
    $new = 1;
    while ($drsbc_r = $drsbc_rs->fetchObject()) {
        if ($new) {
            $temp_currency = $drsbc_r->currency_type;
            $temp_id++;
            $new = 0;
        }
        //echo '<tr><td colspan="5" class="block_description">' . $drsbc_r->currency_type . '</td></tr>';

        if (!$r && $x0 != $drsbc_r->r_id && false) {
            if ($x) {
                echo '<tr class="semifooter">';
                echo '<td>' . $loc[$language]['table_subtotal'] . ':</td>';
                echo '<td class="numeric">' . my_number($q, 2) . '</td>';
                if (!$mobile) {
                    echo '<td class="numeric">' . my_money($a) . '</td>';
                    echo '<td class="numeric">' . my_money($d) . '</td>';
                    echo '<td class="numeric">' . my_money($c) . '</td>';
                }
                echo '<td class="numeric">' . my_money($p) . '</td>';
                echo '</tr>';
            }
            if ($x0) {
                echo '<tr class="subdetails">';
                echo '<td>$pr:</td>';
                echo '<td class="numeric">' . my_number($q0, 2) . '</td>';
                if (!$mobile) {
                    echo '<td class="numeric">' . my_money($a0) . '</td>';
                    echo '<td class="numeric">' . my_money($d0) . '</td>';
                    echo '<td class="numeric">' . my_money($c0) . '</td>';
                }
                echo '<td class="numeric">' . my_money($p0) . '</td>';
                echo '</tr>';
            }
            echo '<tr><td colspan="6" class="block_description">' . $drsbc_r->restaurant . '</td></tr>';
            $q0 = 0;
            $a0 = 0;
            $p0 = 0;
            $d0 = 0;
            $c0 = 0;
            $x0 = $drsbc_r->r_id;
            $pr = $drsbc_r->restaurant;
            $x = 0;
        }
        if ($x != $drsbc_r->ct_id) {
            //echo '<tr><td colspan="5" class="block_description">' . $drsbc_r->currency_type . '</td></tr>';

            if ($x) {
                $table_data = [
                    'amount' => my_money($a),
                    'discount' => my_money($d),
                    'charge' => my_money($c),
                    'payment' => my_money($p)
                ];

                echo '<tr class="semifooter">';
                //echo '<td>subtotal:</td>';
                echo '<td class="js-expandtr-button" data-expandtr="test_' . $temp_id . '">' . $temp_currency . '</td>';
                //echo '<td class="numeric">' . my_number($q, 2) . '</td>';
                if (!$mobile) {
                    echo '<td class="numeric">' . $table_data['amount'] . '</td>';
                    echo '<td class="numeric">' . $table_data['discount'] . '</td>';
                    echo '<td class="numeric">' . $table_data['charge'] . '</td>';
                }
                echo '<td class="numeric">' . $table_data['payment'] . '</td>';
                echo '</tr>';

                $rounded_number = $table_data[$graph_id];
                $rounded_number = str_replace(',', '', $rounded_number);
                //$rounded_number = str_replace('.', ',', $rounded_number);
                $rounded_number = round($rounded_number);

                $graph['results'][] = $rounded_number;

                $graph_name = str_replace('\'', '', $temp_currency);
                $graph['names'][] = $graph_name;

                $temp_currency = $drsbc_r->currency_type;
                $temp_id++;
            }
            $x = $drsbc_r->ct_id;
            $q = 0;
            $a = 0;
            $p = 0;
            $d = 0;
            $c = 0;


        }
        echo '<tr class="collapsed js-expandtr-content" data-expandtr="test_' . $temp_id . '">';
        echo '<td>' . $drsbc_r->currency . '</td>';
        //echo '<td class="numeric">' . my_number($drsbc_r->quantity, 2) . '</td>';
        if (!$mobile) {
            echo '<td class="numeric">' . my_money($drsbc_r->amount) . '</td>';
            echo '<td class="numeric">' . my_money($drsbc_r->discount) . '</td>';
            echo '<td class="numeric">' . my_money($drsbc_r->charge) . '</td>';
        }
        echo '<td class="numeric">' . my_money($drsbc_r->payment) . '</td>';
        echo '</tr>';
        $q += $drsbc_r->quantity;
        $a += $drsbc_r->amount;
        $p += $drsbc_r->payment;
        $d += $drsbc_r->discount;
        $c += $drsbc_r->charge;
        $q0 += $drsbc_r->quantity;
        $a0 += $drsbc_r->amount;
        $p0 += $drsbc_r->payment;
        $d0 += $drsbc_r->discount;
        $c0 += $drsbc_r->charge;
        $q1 += $drsbc_r->quantity;
        $a1 += $drsbc_r->amount;
        $p1 += $drsbc_r->payment;
        $d1 += $drsbc_r->discount;
        $c1 += $drsbc_r->charge;
    }
    if ($q) {
        //last?

        $table_data = [
            'amount' => my_money($a),
            'discount' => my_money($d),
            'charge' => my_money($c),
            'payment' => my_money($p)
        ];

        echo '<tr class="semifooter">';
        echo '<td class="js-expandtr-button" data-expandtr="test_' . $temp_id . '">' . $temp_currency . ':</td>';
        //echo '<td>subtotal:</td>';
        //echo '<td class="numeric">' . my_number($q, 2) . '</td>';
        if (!$mobile) {
            echo '<td class="numeric">' . $table_data['amount'] . '</td>';
            echo '<td class="numeric">' . $table_data['discount'] . '</td>';
            echo '<td class="numeric">' . $table_data['charge'] . '</td>';
        }
        echo '<td class="numeric">' . $table_data['payment'] . '</td>';
        echo '</tr>';

        $rounded_number = $table_data[$graph_id];
        $rounded_number = str_replace(',', '', $rounded_number);
        //$rounded_number = str_replace('.', ',', $rounded_number);
        $rounded_number = round($rounded_number);

        $graph['results'][] = $rounded_number;
        $graph['names'][] = $temp_currency;
    }
    if (!$r && $q0 && false) {
        echo '<tr class="subdetails">';
        echo '<td>$pr:</td>';
        echo '<td class="numeric">' . my_number($q0, 2) . '</td>';
        echo '<td class="numeric">' . my_money($a0) . '</td>';
        echo '<td class="numeric">' . my_money($d0) . '</td>';
        echo '<td class="numeric">' . my_money($c0) . '</td>';
        echo '<td class="numeric">' . my_money($p0) . '</td>';
        echo '</tr>';
    }
    if ($q1) {
        echo '<tr class="semifooter semifooter-big">';
        echo '<td>' . $loc[$language]['table_total'] . ':</td>';
        //echo '<td class="numeric">' . my_number($q1, 2) . '</td>';
        if (!$mobile) {
            echo '<td class="numeric">' . my_money($a1) . '</td>';
            echo '<td class="numeric">' . my_money($d1) . '</td>';
            echo '<td class="numeric">' . my_money($c1) . '</td>';
        }
        echo '<td class="numeric">' . my_money($p1) . '</td>';
        echo '</tr>';
    }
    //echo '</table>';
    unset($drsbc_rs);
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
