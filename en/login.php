<?php
$login_page = 1;
include_once '../inc/predoc.php';
include_once '../inc/filter_get.php';

$r = 0;
if (isset($_GET['restaurant_id'])) {
    $r = $_GET['restaurant_id'];
}

if ($r) {
    $r_name = restaurant_name($r);
} else $r_name = "";

$navigation = [
    0 => [
        'name' => '',
        'link' => ''
    ],
    1 => [
        'name' => '',
        'link' => ''
    ],
    2 => [
        'name' => '',
        'link' => ''
    ],
    3 => [
        'name' => '',
        'link' => ''
    ],
    4 => [
        'name' => '',
        'link' => ''
    ]
];

include_once '../inc/header.php';

echo '<div class="index section background background-index">';
echo '<div class="container">';
echo '<div class="space space-top space-bottom">';
echo '<div class="row row-center row-wrap">';
echo '<div class="column column-1">';
echo '<div class="gap gap-4"></div>';
echo '<h5>Log In</h5>';
echo '<div class="gap gap-2"></div>';
?>

    <form method="POST" action="do_login.php" class="form">
        <div class="row row-wrap">
            <div class="column column-1 column-large-1">
                <div class="cell cell-narrow">
                    <label class="label"><strong>Username:</strong><br>
                        <input type="text" name="login" value="<?php echo $_COOKIE['login'] ?>" size="24">
                    </label>
                </div>
            </div>
            <div class="column column-1 column-large-1">
                <div class="cell cell-narrow">
                    <label class="label"><strong>Password:</strong><br>
                        <input type="password" name="password" value="" size="24">
                    </label>
                </div>
            </div>
            <div class="column column-1 column-large-1">
                <div class="cell">
                    <input type="submit" name="submit" class="send" value="Log In">
                </div>
            </div>
        </div>
    </form>

<?php
echo '<div class="gap gap-4"></div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

include_once '../inc/footer.php';
