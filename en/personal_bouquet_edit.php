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
echo '<h5>__Bouquet\'s parameters editor</h5>';
echo '<div class="gap gap-2"></div>';

$dbh = db_connect();

function arr_dgb_restaurant_dritt_fill()
{
    global $dbh, $user_id;
    $res = array();
    $rs = $dbh->prepare('exec dbo.list_user_restaurants_only ' . $user_id);
    $rs->execute();
    if (($dbh->errorCode() == '00000') && ($rs->errorCode() == '00000')) while ($r = $rs->fetchObject()) $res[$r->id] = $r->title;
    unset($rs);

    return $res;
}

$arr_dgb_restaurant_dritt = arr_dgb_restaurant_dritt_fill();

function arr_dgb_restaurant_dritt_out($x)
{
    global $arr_dgb_restaurant_dritt;
    $r = '';
    foreach ($arr_dgb_restaurant_dritt as $a => $b) $r .= '<option' . (($a == $x) ? ' selected' : '') . ' value="' . $a . '">' . $b . '</option>';
    return $r;
}

function arr_dgb_grp_dcgitt_fill()
{
    global $dbh;
    $res = array();
    $rs = $dbh->prepare('select id, title from dbo.class_groups order by title');
    $rs->execute();
    if (($dbh->errorCode() == '00000') && ($rs->errorCode() == '00000')) while ($r = $rs->fetchObject()) $res[$r->id] = $r->title;
    unset($rs);

    return $res;
}

$arr_dgb_grp_dcgitt = arr_dgb_grp_dcgitt_fill();

function arr_dgb_grp_dcgitt_out($x)
{
    global $arr_dgb_grp_dcgitt;
    $r = '';
    foreach ($arr_dgb_grp_dcgitt as $a => $b) $r .= '<option' . (($a == $x) ? ' selected' : '') . ' value="' . $a . '">' . $b . '</option>';
    return $r;
}

$dgb_rs = $dbh->prepare('execute dbo.get_bouquets :id, :usr');
$dgb_rs->bindParam(':id', $id, PDO::PARAM_INT, 0);
$dgb_rs->bindParam(':usr', $user_id, PDO::PARAM_INT, 0);
$dgb_rs->execute();
if ($dbh->errorCode() == '00000') {
    echo '<form method="POST" action="personal_bouquet_save.php?id=' . $id . '"><table>';
    $dgb_restaurant = null;
    $dgb_grp = null;
    $dgb_description = null;
    $dgb_disp_order = null;
    if ($dgb_r = $dgb_rs->fetchObject()) {
        $dgb_restaurant = $dgb_r->restaurant;
        $dgb_grp = $dgb_r->grp;
        $dgb_description = $dgb_r->description;
        $dgb_disp_order = $dgb_r->disp_order;
    }
    echo '<tr><th>restaurant</th><td style="text-align: left"><select name="restaurant">' . arr_dgb_restaurant_dritt_out($dgb_restaurant) . '</select></td></tr>';
    echo '<tr><th>group</th><td style="text-align: left"><select name="grp">' . arr_dgb_grp_dcgitt_out($dgb_grp) . '</select></td></tr>';
    echo '<tr><th>description</th><td style="text-align: left"><input type="text" name="description" class="temp_input" value="' . $dgb_description . '"></td></tr>';
    echo '<tr><th>order</th><td style="text-align: left"><input type="text" name="disp_order" class="temp_input" value="' . $dgb_disp_order . '"></td></tr>';
    echo '<tr><td colspan="2"><input type="submit" class="temp_submit" value="save"></td></tr>';
    echo '</table></form>';
    unset($dgb_rs);
}

echo '<div class="gap gap-2"></div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

include_once '../inc/footer.php';
