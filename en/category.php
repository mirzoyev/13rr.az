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

$collapse = 0;

$graph = [
    'names' => [],
    'results' => [],
    'title' => '&nbsp;Payments Total'
];

$html = '';
$html .= '<div class="index section background background-index">';
$html .= '<div class="container">';
$html .= '<div class="space space-top space-bottom">';
$html .= '<div class="row row-center row-wrap">';
$html .= '<div class="column column-1">';

$html .= '<div class="gap gap-4"></div>';
$html .= '<h5>' . $loc[$language]['category'] . '</h5>';
$html .= '<div class="gap gap-2"></div>';

$html .= '<table class="data_table2">';
$html .= '<thead>';
$html .= '<tr class="invisible">';
if ($mobile) {
    $html .= '<th style="width:50%">&nbsp;</th>';
    $html .= '<th style="width:25%">&nbsp;</th>';
    $html .= '<th style="width:25%">&nbsp;</th>';
} else {
    $html .= '<th style="width:22%">&nbsp;</th>';
    $html .= '<th style="width:13%">&nbsp;</th>';
    $html .= '<th style="width:13%">&nbsp;</th>';
    $html .= '<th style="width:13%">&nbsp;</th>';
    $html .= '<th style="width:13%">&nbsp;</th>';
    $html .= '<th style="width:13%">&nbsp;</th>';
    $html .= '<th style="width:13%">&nbsp;</th>';
}
$html .= '</tr>';
$html .= '<tr>';
$html .= '<th>';
$html .= $loc[$language]['table_title'];
$html .= '</th>';
$html .= '<th>';
$html .= $loc[$language]['table_quantity'];
$html .= '</th>';
if (!$mobile) {
    $html .= '<th>';
    $html .= $loc[$language]['table_average'];
    $html .= '</th>';
    $html .= '<th>';
    $html .= $loc[$language]['table_amount'];
    $html .= '</th>';
    $html .= '<th>';
    $html .= $loc[$language]['table_discount'];
    $html .= '</th>';
    $html .= '<th>';
    $html .= $loc[$language]['table_charge'];
    $html .= '</th>';
}
$html .= '<th>';
$html .= $loc[$language]['table_payment'];
$html .= '</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';
echo $html;

$html = '';
$drsbc_rs = $dbh->prepare("execute dbo.rep_sales_by_category :usr, :d1, :d2, :r");
$drsbc_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drsbc_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drsbc_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drsbc_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drsbc_rs->execute();
if ($dbh->errorCode() == "00000") {
    $x0 = 0;
    $x1 = 0;
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
    $b = 0;

    $last_b = 0;
    $b_q = 0;
    $b_a = 0;
    $b_d = 0;
    $b_c = 0;
    $b_p = 0;

// echo "<table class=\"data_table\">";
// echo "<tr><th>dish</th><th>quantity</th><th>avg&nbsp;price</th><th>amount</th><th>discount</th><th>charge</th><th>payment</th></tr>";
    while ($drsbc_r = $drsbc_rs->fetchObject()) {
        if ($drsbc_r->cg_id == $_GET['category_id']) {

            if (!$r && $x0 != $drsbc_r->r_id) {
                if ($x1) {
//    echo "<tr class=\"subdetails\">";
//    echo "<td>subtotal:</td>";
//    echo "<td class=\"numeric\">".my_number($q, 4)."</td>";
//    echo "<td class=\"numeric\">".my_money($a / $q)."</td>";
//    echo "<td class=\"numeric\">".my_money($a)."</td>";
//    echo "<td class=\"numeric\">".my_money($d)."</td>";
//    echo "<td class=\"numeric\">".my_money($c)."</td>";
//    echo "<td class=\"numeric\">".my_money($p)."</td>";
//    echo "</tr>";
                }
                if ($x0) {
//    echo "<tr class=\"subdetails\">";
//    echo "<td>$pr:</td>";
//    echo "<td class=\"numeric\">".my_number($q0, 4)."</td>";
//    echo "<td class=\"numeric\">".my_money($a0 / $q0)."</td>";
//    echo "<td class=\"numeric\">".my_money($a0)."</td>";
//    echo "<td class=\"numeric\">".my_money($d0)."</td>";
//    echo "<td class=\"numeric\">".my_money($c0)."</td>";
//    echo "<td class=\"numeric\">".my_money($p0)."</td>";
//    echo "</tr>";
                }
                //echo "<tr><td colspan=\"6\" class=\"block_description\">".$drsbc_r->restaurant."</td></tr>";
                $q0 = 0;
                $a0 = 0;
                $p0 = 0;
                $d0 = 0;
                $c0 = 0;
                $x0 = $drsbc_r->r_id;
                $pr = $drsbc_r->restaurant;
                $x1 = 0;
            }


            if ($x1 != $drsbc_r->cg_id) {
                if ($x1) {
//    echo "<tr class=\"subdetails\">";
//    echo "<td>subtotal:</td>";
//    echo "<td class=\"numeric\">".my_number($q, 4)."</td>";
//    echo "<td class=\"numeric\">".my_money($a / $q)."</td>";
//    echo "<td class=\"numeric\">".my_money($a)."</td>";
//    echo "<td class=\"numeric\">".my_money($d)."</td>";
//    echo "<td class=\"numeric\">".my_money($c)."</td>";
//    echo "<td class=\"numeric\">".my_money($p)."</td>";
//    echo "</tr>";
                }
                $x1 = $drsbc_r->cg_id;
                $q = 0;
                $a = 0;
                $p = 0;
                $d = 0;
                $c = 0;
                //echo "<tr><td colspan=\"6\" class=\"block_description\">".$drsbc_r->class_group."</td><tr>";
            }

            if ($b != $drsbc_r->b_id) {
                if (!$b) {
                    //echo '<tr><td colspan="6" class="block_description">New group?</td><td class="block_description" style="text-align:right">|||</td><tr>';
                }
                $b = $drsbc_r->b_id;
                if ($b) {
                    if ($last_b != $b) {
                        // new group?
                        $html = str_replace('[b' . $last_b . '_q]', $b_q, $html);
                        $html = str_replace('[b' . $last_b . '_avg]', my_money($b_a / $b_q), $html);
                        $html = str_replace('[b' . $last_b . '_a]', my_money($b_a), $html);
                        $html = str_replace('[b' . $last_b . '_d]', my_money($b_d), $html);
                        $html = str_replace('[b' . $last_b . '_c]', my_money($b_c), $html);
                        $html = str_replace('[b' . $last_b . '_p]', my_money($b_p), $html);

                        $b_q = 0;
                        $b_a = 0;
                        $b_d = 0;
                        $b_c = 0;
                        $b_p = 0;
                        $last_b = 0;
                    }

                    $html .= '<tr style="background: #3fed98">';

                    $html .= '<td class="js-expandtr-button" data-expandtr="test_' . $b . '">';
                    $html .= $drsbc_r->bouquet;
                    $html .= '</td>';

                    $html .= '<td>';
                    $html .= '[b' . $b . '_q]';
                    $html .= '</td>';

                    if (!$mobile) {
                        $html .= '<td>';
                        $html .= '[b' . $b . '_avg]';
                        $html .= '</td>';
                        $html .= '<td>';
                        $html .= '[b' . $b . '_a]';
                        $html .= '</td>';
                        $html .= '<td>';
                        $html .= '[b' . $b . '_d]';
                        $html .= '</td>';
                        $html .= '<td>';
                        $html .= '[b' . $b . '_c]';
                        $html .= '</td>';
                    }

                    $html .= '<td>';
                    $html .= '[b' . $b . '_p]';
                    $html .= '</td>';

                    $html .= '<tr>';

                    $collapse = 1;

                    $last_b = $b;
                } else {
                    //echo '<tr><td colspan="6" class="block_description">' . $last_b . '</td><td class="block_description" style="text-align:right">|||</td><tr>';

                    $collapse = 0;

                    // new group?
                    $html = str_replace('[b' . $last_b . '_q]', $b_q, $html);
                    $html = str_replace('[b' . $last_b . '_avg]', my_money($b_a / $b_q), $html);
                    $html = str_replace('[b' . $last_b . '_a]', my_money($b_a), $html);
                    $html = str_replace('[b' . $last_b . '_d]', my_money($b_d), $html);
                    $html = str_replace('[b' . $last_b . '_c]', my_money($b_c), $html);
                    $html = str_replace('[b' . $last_b . '_p]', my_money($b_p), $html);

                    $b_q = 0;
                    $b_a = 0;
                    $b_d = 0;
                    $b_c = 0;
                    $b_p = 0;
                    $last_b = 0;
                    // no group?
                    //echo '<tr><td colspan="6" class="block_description">No group?</td><td class="block_description" style="text-align:right">|||</td><tr>';
                }
            }

            if ($collapse) {
                $html .= '<tr class="collapsed js-expandtr-content" data-expandtr="test_' . $b . '">';
            } else {
                $html .= '<tr>';
            }
            $html .= '<td>';
            $html .= $drsbc_r->dish;
            $html .= '</td>';
            $html .= '<td>';
            $html .= my_number($drsbc_r->quantity, 0);
            $html .= '</td>';

            if (!$mobile) {
                $html .= '<td>';
                $html .= my_money($drsbc_r->avg_price);
                $html .= '</td>';
                $html .= '<td>';
                $html .= my_money($drsbc_r->amount);
                $html .= '</td>';
                $html .= '<td>';
                $html .= my_money($drsbc_r->discount);
                $html .= '</td>';
                $html .= '<td>';
                $html .= my_money($drsbc_r->charge);
                $html .= '</td>';
            }

            $html .= '<td>';
            $html .= my_money($drsbc_r->payment);
            $html .= '</td>';
            $html .= '</tr>';

//  echo "<tr>";
//  echo "<td>".$drsbc_r->dish."</td>";
//  echo "<td class=\"numeric\">".my_number($drsbc_r->quantity, 4)."</td>";
//  echo "<td class=\"numeric\">".my_money($drsbc_r->avg_price)."</td>";
//  echo "<td class=\"numeric\">".my_money($drsbc_r->amount)."</td>";
//  echo "<td class=\"numeric\">".my_money($drsbc_r->discount)."</td>";
//  echo "<td class=\"numeric\">".my_money($drsbc_r->charge)."</td>";
//  echo "<td class=\"numeric\">".my_money($drsbc_r->payment)."</td>";
//  echo "</tr>";

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


            $b_q += $drsbc_r->quantity;
            $b_a += $drsbc_r->amount;
            $b_d += $drsbc_r->discount;
            $b_c += $drsbc_r->charge;
            $b_p += $drsbc_r->payment;
        }
    }


    //last subtotal?
    if ($q) {

        $html .= '</tbody>';
        $html .= '<tfoot>';
        $html .= '<tr>';
        $html .= '<td>';
        $html .= $loc[$language]['table_total'] . ':';
        $html .= '</td>';
        $html .= '<td>';
        $html .= my_number($q, 0);
        $html .= '</td>';
        if (!$mobile) {
            $html .= '<td>';
            $html .= my_money($a / $q);
            $html .= '</td>';
            $html .= '<td>';
            $html .= my_money($a);
            $html .= '</td>';
            $html .= '<td>';
            $html .= my_money($d);
            $html .= '</td>';
            $html .= '<td>';
            $html .= my_money($c);
            $html .= '</td>';
        }
        $html .= '<td style="padding-right:4px">';
        $html .= my_money($p);
        $html .= '&nbsp;';
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '</tfoot>';


//  echo "<tr class=\"subdetails\">";
//  echo "<td>subtotal:</td>";
//  echo "<td class=\"numeric\">".my_number($q, 4)."</td>";
//  echo "<td class=\"numeric\">".my_money($a / $q)."</td>";
//  echo "<td class=\"numeric\">".my_money($a)."</td>";
//  echo "<td class=\"numeric\">".my_money($d)."</td>";
//  echo "<td class=\"numeric\">".my_money($c)."</td>";
//  echo "<td class=\"numeric\">".my_money($p)."</td>";
//  echo "</tr>";
    }

    if (!$r && $q0) {
//  echo "<tr class=\"subdetails\">";
//  echo "<td>$pr:</td>";
//  echo "<td class=\"numeric\">".my_number($q0, 4)."</td>";
//  echo "<td class=\"numeric\">".my_money($a0 / $q0)."</td>";
//  echo "<td class=\"numeric\">".my_money($a0)."</td>";
//  echo "<td class=\"numeric\">".my_money($d0)."</td>";
//  echo "<td class=\"numeric\">".my_money($c0)."</td>";
//  echo "<td class=\"numeric\">".my_money($p0)."</td>";
//  echo "</tr>";
    }
    if ($q1) {
//  echo "<tr class=\"block_footer\">";
//  echo "<td>total:</td>";
//  echo "<td class=\"numeric\">".my_number($q1, 4)."</td>";
//  echo "<td class=\"numeric\">".my_money($a1 / $q1)."</td>";
//  echo "<td class=\"numeric\">".my_money($a1)."</td>";
//  echo "<td class=\"numeric\">".my_money($d1)."</td>";
//  echo "<td class=\"numeric\">".my_money($c1)."</td>";
//  echo "<td class=\"numeric\">".my_money($p1)."</td>";
//  echo "</tr>";
    }
    //echo "</table>";

    unset($drsbc_rs);
}

$html .= '</table>';
$html .= '<div class="gap gap-4"></div>';

$html .= '</div>';
$html .= '</div>';
$html .= '</div>';
$html .= '</div>';
$html .= '</div>';

echo $html;


db_close();

include_once '../inc/footer.php';
