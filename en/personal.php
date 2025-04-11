<?php
include_once '../inc/predoc.php';
include_once '../inc/filter_get.php';

$r = 0;
if (isset($_GET['restaurant_id'])) {
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
    'name' => 'layers',
    'link' => 'personal_grp_bouquets.php'
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

$az_checked = '';
$en_checked = '';
$ru_checked = '';
if ($language == 'en') {
    $en_checked = ' checked';
} elseif ($language == 'ru') {
    $ru_checked = ' checked';
} elseif ($language == 'az') {
    $az_checked = ' checked';
}
echo '<h5>' . $loc[$language]['language'] . '</h5>';
echo '<div class="gap gap-2"></div>';
?>

    <label class="label_radio"><input type="radio" name="radio_language" value="3"
                                      class="js-language"<?= $az_checked ?>><span>Azərbaycan</span></label><br>
    <label class="label_radio"><input type="radio" name="radio_language" value="1"
                                      class="js-language"<?= $en_checked ?>><span>English</span></label><br>
    <label class="label_radio"><input type="radio" name="radio_language" value="2"
                                      class="js-language"<?= $ru_checked ?>><span>Русский</span></label>

<?php
$mobile_checked = '';
$desktop_checked = '';
if ($mobile) {
    $mobile_checked = ' checked';
} else {
    $desktop_checked = ' checked';
}
echo '<div class="gap gap-4"></div>';
echo '<h5>' . $loc[$language]['interface'] . '</h5>';
echo '<div class="gap gap-2"></div>';
?>

    <label class="label_radio"><input type="radio" name="radio_interface" value="1"
                                      class="js-interface"<?= $mobile_checked ?>><span><?= $loc[$language]['interface_mobile'] ?></span></label>
    <br>
    <label class="label_radio"><input type="radio" name="radio_interface" value="0"
                                      class="js-interface"<?= $desktop_checked ?>><span><?= $loc[$language]['interface_desktop'] ?></span></label>

<?php
echo '<div class="gap gap-4"></div>';
echo '<h5>' . $loc[$language]['security'] . '</h5>';
echo '<div class="gap gap-2"></div>';
?>

    <form method="POST" action="personal_save.php" class="form">
        <div class="row row-wrap">
            <div class="column column-1 column-large-1">
                <div class="cell cell-narrow">
                    <label class="label"><strong><?= $loc[$language]['password_old'] ?>:</strong><br>
                        <input type="password" name="password" value="" size="24">
                    </label>
                </div>
            </div>
            <div class="column column-1 column-large-1">
                <div class="cell cell-narrow">
                    <label class="label"><strong><?= $loc[$language]['password_new'] ?>:</strong><br>
                        <input type="password" name="password1" value="" size="24">
                    </label>
                </div>
            </div>
            <div class="column column-1 column-large-1">
                <div class="cell cell-narrow">
                    <label class="label"><strong><?= $loc[$language]['password_confirm'] ?>:</strong><br>
                        <input type="password" name="password2" value="" size="24">
                    </label>
                </div>
            </div>
            <div class="column column-1 column-large-1">
                <div class="cell">
                    <input type="submit" name="submit" class="send" value="<?= $loc[$language]['password_send'] ?>">
                </div>
            </div>
        </div>
    </form>

<?php
echo '<div class="gap gap-2"></div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

include_once '../inc/footer.php';

