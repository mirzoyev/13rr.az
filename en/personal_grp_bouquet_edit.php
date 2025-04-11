<?php
include_once '../inc/predoc.php';
//include_once 'inc/personal.php';

$navigation[0] = [
    'name' => 'back',
    'link' => 'personal_grp_bouquets.php'
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
echo '<h5>__Group bouquet\'s parameters editor</h5>';
echo '<div class="gap gap-2"></div>';

$dbh = db_connect();

function arr_dggb_restaurant_dritt_fill()
{
    global $dbh, $user_id;
    $res = array();
    $rs = $dbh->prepare("exec dbo.list_user_restaurants_only " . $user_id);
    $rs->execute();
    if (($dbh->errorCode() == "00000") && ($rs->errorCode() == "00000")) while ($r = $rs->fetchObject()) $res[$r->id] = $r->title;
    unset($rs);

    return $res;
}

$arr_dggb_restaurant_dritt = arr_dggb_restaurant_dritt_fill();

function arr_dggb_restaurant_dritt_out($x)
{
    global $arr_dggb_restaurant_dritt;
    $r = '';
    foreach ($arr_dggb_restaurant_dritt as $a => $b) $r .= '<option' . (($a == $x) ? ' selected' : '') . ' value="' . $a . '">' . $b . '</option>';
    return $r;
}

$checked = array('', ' checked');

$dggb_rs = $dbh->prepare("execute dbo.get_grp_bouquets :id, :usr");
$dggb_rs->bindParam(":id", $id, PDO::PARAM_INT, 0);
$dggb_rs->bindParam(":usr", $user_id, PDO::PARAM_INT, 0);
$dggb_rs->execute();
if ($dbh->errorCode() == "00000") {
    echo '<form method="POST" action="personal_grp_bouquet_save.php?id=' . $id . '"><table style="width:auto;">';
    $dggb_restaurant = null;
    $dggb_description = null;
    $dggb_disp_order = null;
    if ($dggb_r = $dggb_rs->fetchObject()) {
        $dggb_restaurant = $dggb_r->restaurant;
        $dggb_description = $dggb_r->description;
        $dggb_disp_order = $dggb_r->disp_order;
    }

    echo '<tr><th>restaurant</th><td style="text-align: left"><select name="restaurant">' . arr_dggb_restaurant_dritt_out($dggb_restaurant) . '</select></td></tr>';
    echo '<tr><th>description</th><td style="text-align: left"><input type="text" name="description" class="temp_input" value="' . $dggb_description . '"></td></tr>';
    echo '<tr><th>order</th><td style="text-align: left"><input type="text" name="disp_order" class="temp_input" value="' . $dggb_disp_order . '"></td></tr>';
    $dlugbp_rs = $dbh->prepare("execute dbo.list_user_grp_bouquet_possibility :bouquet");
    $dlugbp_rs->bindParam(":bouquet", $id, PDO::PARAM_INT, 0);
    $dlugbp_rs->execute();
    if ($dbh->errorCode() == "00000") {
        while ($dlugbp_r = $dlugbp_rs->fetchObject()) {
            echo '<tr style="border-bottom: 0;">';
            echo '<td colspan="2" style="text-align: left"><input type="hidden" name="unchecked[]" value="' . $dlugbp_r->grp . '">';
            echo '<input id="checkbox_' . $dlugbp_r->grp . '" type="checkbox" name="checked[]" value="' . $dlugbp_r->grp . '"' . $checked[$dlugbp_r->checked] . '>';
            echo '<label for="checkbox_' . $dlugbp_r->grp . '" style="display:inline-block;padding-left:8px;transform:translateY(-1px)">' . $dlugbp_r->title . '</label>';
            echo '</td>';
            echo '</tr>';
        }
        unset($dlugbp_rs);
    }
    echo '<tr style="border-top: 1px solid #0f9d5870;padding:8px;"><td colspan="2" style="padding:12px;"><input type="submit" class="temp_submit" value="Save" style="border:1px solid #0f9d5870"></td></tr>';
    echo '</table></form>';
    unset($dggb_rs);
}

db_close();

include_once '../inc/footer.php';
