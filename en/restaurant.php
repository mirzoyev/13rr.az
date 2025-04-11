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
    'link' => '',
    'active' => true
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

include_once '../inc/header.php';

//if ($r_name) $r_name = "restaurant: ".$r_name;

//echo '<h4> ' . $r_name . ' sales totals</h4>';
//echo "<h3>from: $d1 till: $d2 $r_name</h3>";

$dbh = db_connect();

$graph = [
    'names' => [],
    'results' => [],
    'title' => '&nbsp;' . $loc[$language]['table_payment'] . ' (%)'
];

echo '<div class="index section background background-index">';
echo '<div class="container">';
echo '<div class="space space-top space-bottom">';
echo '<div class="row row-center row-wrap">';
echo '<div class="column column-1">';

echo '<div class="gap gap-4"></div>';
echo '<h5> ' . ucwords(strtolower($r_name)) . ': ' . $loc[$language]['restaurant'] . '</h5>';
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

$drsbc_rs = $dbh->prepare("execute dbo.rep_sales_by_category :usr, :d1, :d2, :r");
$drsbc_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drsbc_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drsbc_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drsbc_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drsbc_rs->execute();
if ($dbh->errorCode() == "00000") {
    // create data array
    $data = [];
    $group_names = [];
    $category_names = [];
    while ($drsbc_r = $drsbc_rs->fetchObject()) {
        $dish = (array)$drsbc_r;
        $group_name = $dish['g_bouquet'];
        if (!in_array($group_name, $group_names)) {
            $group_names[] = $group_name;
            $data[$group_name] = [];
            $data[$group_name]['categories'] = [];
        }
        $category_name = $dish['class_group'];
        if (!in_array($category_name, $category_names)) {
            //$category_names[] = $category_name;
            $category_names[$dish['cg_id']] = $category_name;
            $data[$group_name]['categories'][$category_name] = [];
        }
        $data[$group_name]['categories'][$category_name]['dishes'][] = $dish;
    }
    unset($drsbc_rs);

    // calculate sums
    $fields = [
        'quantity' => 0,
        //'avg_price' => 0,
        'amount' => 0,
        'payment' => 0,
        'discount' => 0,
        'charge' => 0
    ];
    $total_sums = $fields;
    foreach ($data as $group_name => $group_data) {
        $group_sums = $fields;

        foreach ($group_data['categories'] as $category_name => $category_data) {
            $category_sums = $fields;

            foreach ($category_data['dishes'] as $dish) {
                foreach ($fields as $field_name => $field_value) {
                    $total_sums[$field_name] += $dish[$field_name];
                    $group_sums[$field_name] += $dish[$field_name];
                    $category_sums[$field_name] += $dish[$field_name];
                }
            }

            $data[$group_name]['categories'][$category_name]['sums'] = $category_sums;
        }

        $data[$group_name]['sums'] = $group_sums;
    }
    //print_r($data);

    // table output
    foreach ($data as $group_name => $group_data) {
        if ($group_name) {
            echo '<tr style="background: #3fed98">';
            echo '<td class="js-expandtr-button" data-expandtr="group_' . htmlentities(str_replace(' ', '', $group_name)) . '">';
            echo $group_name;
            echo '</td>';
            echo '<td>';
            echo my_number($group_data['sums']['quantity'], 0);
            echo '</td>';

            if (!$mobile) {
                echo '<td>';
                echo my_money($group_data['sums']['amount'] / $group_data['sums']['quantity']);
                echo '</td>';
                echo '<td>';
                echo my_money($group_data['sums']['amount']);
                echo '</td>';
                echo '<td>';
                echo my_money($group_data['sums']['discount']);
                echo '</td>';
                echo '<td>';
                echo my_money($group_data['sums']['charge']);
                echo '</td>';
            }

            echo '<td>';
            echo my_money($group_data['sums']['payment']);
            echo '</td>';
            echo '</tr>';
        }

        if ($group_name) {
            $graph['names'][] = $group_name;

            $rounded_number = my_money($group_data['sums']['payment']);
            $rounded_number = str_replace(',', '', $rounded_number);
            //$rounded_number = str_replace('.', ',', $rounded_number);
            $rounded_number = round($rounded_number);

            $graph['results'][] = $rounded_number;
        }

        foreach ($group_data['categories'] as $category_name => $category_data) {
            $category_id = array_search($category_name, $category_names);
            if ($group_name) {
                echo '<tr style="background: #cffae5" class="collapsed js-expandtr-content" data-expandtr="group_' . htmlentities(str_replace(' ', '', $group_name)) . '">';
            } else {
                echo '<tr>';
            }
            echo '<td>';
            echo '<a href="category.php?restaurant_id=' . $r . '&category_id=' . $category_id . '">' . $category_name . '</a>';
            echo '</td>';
            echo '<td>';
            echo my_number($group_data['categories'][$category_name]['sums']['quantity'], 0);
            echo '</td>';

            if (!$mobile) {
                echo '<td>';
                echo my_money($group_data['categories'][$category_name]['sums']['amount'] / $group_data['categories'][$category_name]['sums']['quantity']);
                echo '</td>';
                echo '<td>';
                echo my_money($group_data['categories'][$category_name]['sums']['amount']);
                echo '</td>';
                echo '<td>';
                echo my_money($group_data['categories'][$category_name]['sums']['discount']);
                echo '</td>';
                echo '<td>';
                echo my_money($group_data['categories'][$category_name]['sums']['charge']);
                echo '</td>';
            }

            echo '<td>';
            echo my_money($group_data['categories'][$category_name]['sums']['payment']);
            echo '</td>';
            echo '</tr>';

            if (!$group_name) {
                $graph['names'][] = $category_name;

                $rounded_number = my_money($group_data['categories'][$category_name]['sums']['payment']);
                $rounded_number = str_replace(',', '', $rounded_number);
                //$rounded_number = str_replace('.', ',', $rounded_number);
                $rounded_number = round($rounded_number);

                $graph['results'][] = $rounded_number;
            }
        }
    }

    echo '</tbody>';
    echo '<tfoot>';
    echo '<tr>';
    echo '<td>';
    echo $loc[$language]['table_total'] . ':';
    echo '</td>';
    echo '<td>';
    echo my_number($total_sums['quantity'], 0);
    echo '</td>';
    if (!$mobile) {
        echo '<td>';
        echo my_money($total_sums['amount'] / $total_sums['quantity']);
        echo '</td>';
        echo '<td>';
        echo my_money($total_sums['amount']);
        echo '</td>';
        echo '<td>';
        echo my_money($total_sums['discount']);
        echo '</td>';
        echo '<td>';
        echo my_money($total_sums['charge']);
        echo '</td>';
    }
    echo '<td style="padding-right:4px">';
    echo my_money($total_sums['payment']);
    echo '&nbsp;';
    echo '</td>';
    echo '</tr>';


    $current_payment = $total_sums['payment'];
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

    echo '</tr>';


    echo '</tfoot>';

    //print_r($total_sums);
    //echo '<hr>';
}

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
        $graph['percents'][] = my_number(($result / $graph_sum) * 100, 2) . '';
    }

    echo '<div class="index section background background-index">';
    echo '<div class="container">';
    echo '<div class="space space-top space-bottom">';

    echo '<div class="row row-center row-wrap">';
    echo '<div class="column column-1">';
    echo '<div class="gap gap-4"></div>';
    echo '<h5>' . $loc[$language]['graph'] . '</h5>';
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

db_close();

include_once '../inc/footer.php';
?>
