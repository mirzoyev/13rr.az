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

//if ($r_name) $r_name = "restaurant: ".$r_name;

//echo "<h1>Payments by type</h1>";
//echo "<h3>from: $d1 till: $d2 $r_name</h3>";

$graph = [
    'names' => [],
    'results' => [],
    'title' => '&nbsp;' . $loc[$language]['table_payment']
];

$dbh = db_connect();

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
    echo '<th style="width:50%">&nbsp;</th>';
    echo '<th style="width:25%">&nbsp;</th>';
    echo '<th style="width:25%">&nbsp;</th>';
} else {
    echo '<th style="width:25%">&nbsp;</th>';
    echo '<th style="width:12.5%">&nbsp;</th>';
    echo '<th style="width:12.5%">&nbsp;</th>';
    echo '<th style="width:12.5%">&nbsp;</th>';
    echo '<th style="width:12.5%">&nbsp;</th>';
    echo '<th style="width:12.5%">&nbsp;</th>';
}
echo '</tr>';
echo '<tr>';
echo '<th>';
echo 'Currency';
echo '</th>';
if (!$mobile) {
    echo '<th>';
    echo 'quantity';
    echo '</th>';
    echo '<th>';
    echo 'amount';
    echo '</th>';
}
echo '<th>';
echo $loc[$language]['table_discount'];
echo '</th>';
echo '<th>';
echo $loc[$language]['table_charge'];
echo '</th>';
echo '<th>';
echo $loc[$language]['table_payment'];
echo '</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

$drsbc_rs = $dbh->prepare("execute dbo.rep_sales_by_currency :usr, :d1, :d2, :r");
$drsbc_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$drsbc_rs->bindParam(":d1", $d1, PDO::PARAM_STR, 0);
$drsbc_rs->bindParam(":d2", $d2, PDO::PARAM_STR, 0);
$drsbc_rs->bindParam(":r", $r, PDO::PARAM_INT, 0);
$drsbc_rs->execute();
if ($dbh->errorCode() == "00000") {
// echo "<table class=\"data_table\">";
// echo "<tr><th>currency</th><th>quantity</th><th>amount</th><th>discount</th><th>charge</th><th>payment</th></tr>";
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
 while ($drsbc_r = $drsbc_rs->fetchObject()) {
  if (!$r && $x0 != $drsbc_r->r_id) {
   if ($x) {
//    echo "<tr class=\"subdetails\">";
//    echo "<td>subtotal:</td>";
//    echo "<td class=\"numeric\">".my_number($q, 4)."</td>";
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
   $x = 0;
  }

  if ($x != $drsbc_r->ct_id && true) {
      $currency_total = $drsbc_r->currency_type;

      echo "<tr><td colspan=\"5\" class=\"block_description\">".$x. ' _ '. $drsbc_r->ct_id . ' _ ' . $drsbc_r->currency_type."</td></tr>";


   if ($x && true) {


       if (false) {
           echo '<div class="row row-between table table-footer">';
           echo '<div class="column column-auto cell">' . $loc[$language]['table_subtotal'] . ':</div>';
           echo '<div class="column column-auto cell">' . my_money($d) . '</div>';
           echo '<div class="column column-auto cell">' . my_money($c) . '</div>';
           echo '<div class="column column-auto cell">' . my_money($p) . '</div>';
           echo '</div>';
       }

       //echo '</tbody>';
       //echo '<tfoot>';

       echo '<tr class="semifooter">';
       echo '<td>';
       echo $currency_total;
       echo '</td>';

       if (!$mobile) {
           echo '<td>';
           echo my_number($q, 2);
           echo '</td>';
           echo '<td>';
           echo my_money($a);
           echo '</td>';
       }

       echo '<td>';
       echo my_money($d);
       echo '</td>';
       echo '<td>';
       echo my_money($c);
       echo '</td>';
       echo '<td style="padding-right:4px">';
       echo my_money($p);
       echo '&nbsp;';
       echo '</td>';
       echo '</tr>';
       //echo '</tfoot>';
       //echo '</table>';

       //echo '<br>';

    $rounded_number = my_money($p);
    $rounded_number = str_replace(',', '', $rounded_number);
    //$rounded_number = str_replace('.', ',', $rounded_number);
    $rounded_number = round($rounded_number);

    $graph['results'][] = $rounded_number;

//    echo "<tr class=\"subdetails\">";
//    echo "<td>subtotal:</td>";
//    echo "<td class=\"numeric\">".my_number($q, 4)."</td>";
//    echo "<td class=\"numeric\">".my_money($a)."</td>";
//    echo "<td class=\"numeric\">".my_money($d)."</td>";
//    echo "<td class=\"numeric\">".my_money($c)."</td>";
//    echo "<td class=\"numeric\">".my_money($p)."</td>";
//    echo "</tr>";
   }
   $x = $drsbc_r->ct_id;
   $q = 0;
   $a = 0;
   $p = 0;
   $d = 0;
   $c = 0;

   //echo '<h6>' . $drsbc_r->currency_type . '</h6>';

//      echo '<tr>';
//      echo '<th>';
//      echo $drsbc_r->currency_type;
//      echo '</th>';
//      if (!$mobile) {
//          echo '<th>';
//          echo 'quantity';
//          echo '</th>';
//          echo '<th>';
//          echo 'amount';
//          echo '</th>';
//      }
//      echo '<th>';
//      echo $loc[$language]['table_discount'];
//      echo '</th>';
//      echo '<th>';
//      echo $loc[$language]['table_charge'];
//      echo '</th>';
//      echo '<th>';
//      echo $loc[$language]['table_payment'];
//      echo '</th>';
//      echo '</tr>';

      if (false) {
          echo '<div class="row row-between table table-header">';
          echo '<div class="column column-auto cell">' . $drsbc_r->currency_type . '</div>';
          echo '<div class="column column-auto cell">' . $loc[$language]['table_discount'] . '</div>';
          echo '<div class="column column-auto cell">' . $loc[$language]['table_charge'] . '</div>';
          echo '<div class="column column-auto cell">' . $loc[$language]['table_payment'] . '</div>';
          echo '</div>';
      }

   $graph['names'][] = $drsbc_r->currency_type;

    //echo "<tr><td colspan=\"5\" class=\"block_description\">".$drsbc_r->currency_type."</td></tr>";
  }

     echo '<tr class="invisible_">';
     echo '<td>';
     echo $drsbc_r->currency;
     echo '</td>';
     if (!$mobile) {
         echo '<td>';
         echo my_number($drsbc_r->quantity, 2);
         echo '</td>';
         echo '<td>';
         echo my_money($drsbc_r->amount);
         echo '</td>';
     }
     echo '<td>';
     echo my_money($drsbc_r->discount);
     echo '</td>';
     echo '<td>';
     echo my_money($drsbc_r->charge);
     echo '</td>';
     echo '<td>';
     echo my_money($drsbc_r->payment);
     echo '</td>';
     echo '</tr>';

  if (false) {
      echo '<div class="row row-between table">';
      echo '<div class="column column-auto cell">' . $drsbc_r->currency . '</div>';
      echo '<div class="column column-auto cell">' . my_money($drsbc_r->discount) . '</div>';
      echo '<div class="column column-auto cell">' . my_money($drsbc_r->charge) . '</div>';
      echo '<div class="column column-auto cell">' . my_money($drsbc_r->payment) . '</div>';
      echo '</div>';
  }

//  echo "<tr>";
//  echo "<td>".$drsbc_r->currency."</td>";
//  echo "<td class=\"numeric\">".my_number($drsbc_r->quantity, 4)."</td>";
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
 }
 if ($q && false) {
     //final??
     echo '</tbody>';
     echo '<tfoot>';
     echo '<tr>';
     echo '<td>';
     echo $loc[$language]['table_subtotal'] . ':';
     //echo $currency_total;
     echo '</td>';

     if (!$mobile) {
         echo '<td>';
         echo my_number($q, 2);
         echo '</td>';
         echo '<td>';
         echo my_money($a);
         echo '</td>';
     }

     echo '<td>';
     echo my_money($d);
     echo '</td>';
     echo '<td>';
     echo my_money($c);
     echo '</td>';
     echo '<td style="padding-right:4px">';
     echo my_money($p);
     echo '&nbsp;';
     echo '</td>';
     echo '</tr>';
     echo '</tfoot>';
     echo '</table>';

     if (false) {
         echo '<div class="row row-between table table-footer">';
         echo '<div class="column column-auto cell">' . $loc[$language]['table_subtotal'] . ':</div>';
         echo '<div class="column column-auto cell">' . my_money($d) . '</div>';
         echo '<div class="column column-auto cell">' . my_money($c) . '</div>';
         echo '<div class="column column-auto cell">' . my_money($p) . '</div>';
         echo '</div>';
     }

     //echo '<br>';


  $rounded_number = my_money($p);
  $rounded_number = str_replace(',', '', $rounded_number);
  //$rounded_number = str_replace('.', ',', $rounded_number);
  $rounded_number = round($rounded_number);

  $graph['results'][] = $rounded_number;



//  echo "<tr class=\"subdetails\">";
//  echo "<td>subtotal:</td>";
//  echo "<td class=\"numeric\">".my_number($q, 4)."</td>";
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
//  echo "<td class=\"numeric\">".my_money($a0)."</td>";
//  echo "<td class=\"numeric\">".my_money($d0)."</td>";
//  echo "<td class=\"numeric\">".my_money($c0)."</td>";
//  echo "<td class=\"numeric\">".my_money($p0)."</td>";
//  echo "</tr>";
 }
 if ($q1 && false) {
  //echo '<h6>Totals:</h6>';

     echo '<table>';
     echo '<thead>';
     echo '<tr class="invisible">';
     if ($mobile) {
         echo '<th style="width:50%">&nbsp;</th>';
         echo '<th style="width:25%">&nbsp;</th>';
         echo '<th style="width:25%">&nbsp;</th>';
     } else {
         echo '<th style="width:25%">&nbsp;</th>';
         echo '<th style="width:12.5%">&nbsp;</th>';
         echo '<th style="width:12.5%">&nbsp;</th>';
         echo '<th style="width:12.5%">&nbsp;</th>';
         echo '<th style="width:12.5%">&nbsp;</th>';
         echo '<th style="width:12.5%">&nbsp;</th>';
     }
     echo '</tr>';
     echo '<tr>';
     echo '<th>';
     echo $loc[$language]['total'];
     echo '</th>';
     if (!$mobile) {
         echo '<th>';
         echo 'quantity';
         echo '</th>';
         echo '<th>';
         echo 'amount';
         echo '</th>';
     }
     echo '<th>';
     echo $loc[$language]['table_discount'];
     echo '</th>';
     echo '<th>';
     echo $loc[$language]['table_charge'];
     echo '</th>';
     echo '<th>';
     echo $loc[$language]['table_payment'];
     echo '</th>';
     echo '</tr>';
     echo '</thead>';

//     echo '<tbody>';
//     echo '</tbody>';

     echo '<tfoot>';
     echo '<tr>';
     echo '<td>';
     echo $loc[$language]['table_total'] . ':';
     echo '</td>';

     if (!$mobile) {
         echo '<td>';
         echo my_number($q1, 2);
         echo '</td>';
         echo '<td>';
         echo my_money($a1);
         echo '</td>';
     }

     echo '<td>';
     echo my_money($d1);
     echo '</td>';
     echo '<td>';
     echo my_money($c1);
     echo '</td>';
     echo '<td style="padding-right:4px">';
     echo my_money($p1);
     echo '&nbsp;';
     echo '</td>';
     echo '</tr>';
     echo '</tfoot>';
     echo '</table>';


     if (false) {
         echo '<div class="row row-between table table-header">';
         echo '<div class="column column-auto cell">' . $loc[$language]['total'] . '</div>';
         echo '<div class="column column-auto cell">' . $loc[$language]['table_discount'] . '</div>';
         echo '<div class="column column-auto cell">' . $loc[$language]['table_charge'] . '</div>';
         echo '<div class="column column-auto cell">' . $loc[$language]['table_payment'] . '</div>';
         echo '</div>';

         echo '<div class="row row-between table table-footer">';
         echo '<div class="column column-auto cell">' . $loc[$language]['table_total'] . ':</div>';
         echo '<div class="column column-auto cell">' . my_money($d1) . '</div>';
         echo '<div class="column column-auto cell">' . my_money($c1) . '</div>';
         echo '<div class="column column-auto cell">' . my_money($p1) . '</div>';
         echo '</div>';

     }

//  echo "<tr class=\"block_footer\">";
//  echo "<td>totals:</td>";
//  echo "<td class=\"numeric\">".my_number($q1, 4)."</td>";
//  echo "<td class=\"numeric\">".my_money($a1)."</td>";
//  echo "<td class=\"numeric\">".my_money($d1)."</td>";
//  echo "<td class=\"numeric\">".my_money($c1)."</td>";
//  echo "<td class=\"numeric\">".my_money($p1)."</td>";
//  echo "</tr>";
 }
// echo "</table>";
 unset($drsbc_rs);
}

echo '</table>';
echo '<div class="gap gap-4"></div>';

echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

if (!empty($graph['results'])) {
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
