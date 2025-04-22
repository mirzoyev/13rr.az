<?php
$loc = [
    'en' => [
        'avg_bill' => 'Average bill',
        'by_amount' => 'Top 10 by amount',
        'boy_by_amount' => 'Top 10 by waiter',
        'compl' => 'Complimentary',
        'previous' => 'Previous',

        'language' => 'Language',
        'security' => 'Security',
        'interface' => 'Interface',
        'interface_mobile' => 'Mobile',
        'interface_desktop' => 'Desktop',
        'password_old' => 'Old password',
        'password_new' => 'New password',
        'password_confirm' => 'Confirm password',
        'password_send' => 'Send',

        'graph' => 'Graph',

        'total' => 'Sales totals',
        'restaurant' => 'Sales by categories',
        'category' => 'Sales by category',
        'payment' => 'Payments by method',
        'discount' => 'Discounts and charges',

        'table_total' => 'Total',
        'table_subtotal' => 'Subtotal',
        'table_restaurant' => 'Restaurant',
        'table_visits' => 'Visits',
        'table_guests' => 'Guests',
        'table_payment' => 'Payment',
        'table_title' => 'Title',
        'table_currency' => 'Currency',
        'table_quantity' => 'Quantity',
        'table_discount' => 'Discount',
        'table_charge' => 'Service charge',

        'table_' => '',
        'table_average' => 'Avg. price',
        'table_amount' => 'Amount',

        'time_from' => 'From',
        'time_to' => 'To',
        'time_day' => 'Yesterday',
        'time_week' => 'Week',
        'time_month' => 'Month',
        'time_year' => 'Year',
        'time_reload' => 'Reload'
    ],
    'ru' => [
        'avg_bill' => 'Средний чек',
        'by_amount' => 'Топ 10 по сумме',
        'boy_by_amount' => 'Топ 10 по официанту',
        'compl' => 'Комлимент',
        'previous' => 'Предыдущий',

        'language' => 'Язык',
        'security' => 'Безопасность',
        'interface' => 'Интерфейс',
        'interface_mobile' => 'Для мобильных',
        'interface_desktop' => 'Для десктопов',
        'password_old' => 'Старый пароль',
        'password_new' => 'Новый пароль',
        'password_confirm' => 'Подтвердить пароль',
        'password_send' => 'Отправить',

        'graph' => 'График',

        'total' => 'Общая продажа',
        'restaurant' => 'Продажи по категориям',
        'category' => 'Продажи по категории',
        'payment' => 'Методы оплаты',
        'discount' => 'Скидки и наценки',

        'table_total' => 'Итого',
        'table_subtotal' => 'Итог',
        'table_restaurant' => 'Ресторан',
        'table_visits' => 'Посещения',
        'table_guests' => 'Гости',
        'table_payment' => 'Оплата',
        'table_title' => 'Заголовок',
        'table_currency' => 'Валюта',
        'table_quantity' => 'Количество',
        'table_discount' => 'Скидка',
        'table_charge' => 'Наценка',
        'table_average' => 'Средняя цена',
        'table_amount' => 'Сумма',

        'time_from' => 'От',
        'time_to' => 'До',
        'time_day' => 'Вчера',
        'time_week' => 'Неделя',
        'time_month' => 'Месяц',
        'time_year' => 'Год',
        'time_reload' => 'Обновить'
    ],
    'az' => [
        'avg_bill' => 'Orta çek',
        'by_amount' => 'Top 10 məbləg',
        'boy_by_amount' => 'Top 10 oficiant',
        'compl' => 'Kompliment',
        'previous' => 'Evvelki',

        'language' => 'Dil',
        'security' => 'Təhlükəsizlik',
        'interface' => 'İnterfeys',
        'interface_mobile' => 'Mobil üçün',
        'interface_desktop' => 'Desktop üçün',
        'password_old' => 'Köhnə şifrə',
        'password_new' => 'Yeni şifrə',
        'password_confirm' => 'Şifrəni təsdiqləyin',
        'password_send' => 'Göndər',

        'graph' => 'Qrafik',

        'total' => 'Ümumi satış',//
        'restaurant' => 'Kateqoriyalara görə satış',//---
        'category' => 'Kateqoriyaya görə satış',//
        'payment' => 'Ödəniş üsulları',//
        'discount' => 'Endirimlər və əlavə ödənişlər',

        'table_total' => 'Ümumi',//
        'table_subtotal' => 'Ümumi',//
        'table_restaurant' => 'Restoran',//
        'table_visits' => 'Посещения',
        'table_guests' => 'Qonaqlar',//
        'table_payment' => 'Ödəniş',//
        'table_title' => 'Başlıq',//
        'table_currency' => 'Valyuta',//
        'table_quantity' => 'Miqdar',//
        'table_discount' => 'Endirim',//
        'table_charge' => 'Əlavə ödəniş',//
        'table_average' => 'Orta qiymet',
        'table_amount' => 'Məbləğ',

        'time_from' => 'From',
        'time_to' => 'To',
        'time_day' => 'Dünən',
        'time_week' => 'Həftə',
        'time_month' => 'Ay',
        'time_year' => 'İl',
        'time_reload' => 'Reload'
    ]
];

$language = 'en';
if (isset($_COOKIE['language'])) {
    $language = $_COOKIE['language'];
}
$language2 = $language;

$mobile = true;
if (isset($_COOKIE['interface'])) {
    $mobile = $_COOKIE['interface'];
}

//magic 6 hours
$baku = 60 * 60 * 5;

$now = time();
$timeFrom = $now;
if (isset($_COOKIE['dateFromUnix'])) {
    $timeFrom = intval($_COOKIE['dateFromUnix'] / 1000);
}
$timeFrom = $timeFrom + $baku;

$timeTo = $now;
if (isset($_COOKIE['dateToUnix'])) {
    $timeTo = intval($_COOKIE['dateToUnix'] / 1000);
}
$timeTo = $timeTo + $baku;

$now = time();
$timeFromPrev = $now;
if (isset($_COOKIE['dateFromUnixPrev'])) {
    $timeFromPrev = intval($_COOKIE['dateFromUnixPrev'] / 1000);
}
$timeFromPrev = $timeFromPrev + $baku;

$timeToPrev = $now;
if (isset($_COOKIE['dateToUnixPrev'])) {
    $timeToPrev = intval($_COOKIE['dateToUnixPrev'] / 1000);
}
$timeToPrev = $timeToPrev + $baku;

//calculate period
//set prev dates

$period = 1;
//$period = 7;
//$period = 30;
if (isset($_COOKIE['period'])) {
    $period = $_COOKIE['period'];
}

//$timePrevFrom = $timeFrom;
//$timePrevTo = $timeTo;

$prevYearStart = strtotime('first day of january previous year', $timeFrom);
$prevYearEnd = strtotime('last day of december previous year', $timeFrom);
$nextYearStart = strtotime('first day of january next year', $timeFrom);
$nextYearEnd = strtotime('last day of december next year', $timeFrom);

$prevMonthStart = strtotime('first day of previous month', $timeFrom);
$prevMonthEnd = strtotime('last day of previous month', $timeFrom);
$nextMonthStart = strtotime('first day of next month', $timeFrom);
$nextMonthEnd = strtotime('last day of next month', $timeFrom);

$prevWeekStart = strtotime('monday last week', $timeFrom);
$prevWeekEnd = strtotime('sunday last week', $timeFrom);
$nextWeekStart = strtotime('monday next week', $timeFrom);
$nextWeekEnd = strtotime('sunday next week', $timeFrom);

$prevDay = strtotime('yesterday', $timeFrom);
$nextDay = strtotime('tomorrow', $timeFrom);

if ($period == 365) {
    $timePrevFrom = $prevYearStart;
    $timePrevTo = $prevYearEnd;
    $timeNextFrom = $nextYearStart;
    $timeNextTo = $nextYearEnd;
} elseif ($period == 30) {
    $timePrevFrom = $prevMonthStart;
    $timePrevTo = $prevMonthEnd;
    $timeNextFrom = $nextMonthStart;
    $timeNextTo = $nextMonthEnd;
} elseif ($period == 7) {
    $timePrevFrom = $prevWeekStart;
    $timePrevTo = $prevWeekEnd;
    $timeNextFrom = $nextWeekStart;
    $timeNextTo = $nextWeekEnd;
} else {
    $timePrevFrom = $prevDay;
    $timePrevTo = $prevDay;
    $timeNextFrom = $nextDay;
    $timeNextTo = $nextDay;
}

if (0) {
    // testing time
    // testing prev period time (difference)

    $oneDay = 60 * 60 * 24;

    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '$timeFrom';
    echo '<br>';
    echo $timeFrom;
    echo ' - ';
    echo date('m/d/Y h:i:s', $timeFrom);
    echo '<br>';
    echo '$timeTo';
    echo '<br>';
    echo $timeTo;
    echo ' - ';
    echo date('m/d/Y h:i:s', $timeTo);
    echo '<br>';

    $timeDiff = $timeTo - $timeFrom;
    echo '$timeDiff';
    echo '<br>';
    echo $timeDiff / $oneDay;
    echo '<br>';
    echo '<br>';

    echo '$timeFromPrev';
    echo '<br>';
    echo $timeFromPrev;
    echo ' - ';
    echo date('m/d/Y h:i:s', $timeFromPrev);
    echo '<br>';
    echo '$timeToPrev';
    echo '<br>';
    echo $timeToPrev;
    echo ' - ';
    echo date('m/d/Y h:i:s', $timeToPrev);
    echo '<br>';

    $timeDiffPrev = $timeToPrev - $timeFromPrev;
    echo '$timeDiffPrev';
    echo '<br>';
    echo $timeDiffPrev / $oneDay;
    echo '<br>';
}

if (0) {
    // testing arrow time

    echo '<br>';
    echo '<br>';
    echo '<br>';

    echo $timePrevFrom;
    echo ' - ';
    echo date('m/d/Y h:i:s', $timePrevFrom);
    echo '<br>';
    echo $timePrevTo;
    echo ' - ';
    echo date('m/d/Y h:i:s', $timePrevTo);
    echo '<br>';
    echo '<br>';
    echo $timeNextFrom;
    echo ' - ';
    echo date('m/d/Y h:i:s', $timeNextFrom);
    echo '<br>';
    echo $timeNextTo;
    echo ' - ';
    echo date('m/d/Y h:i:s', $timeNextTo);
}

$d1 = date('Y-m-d', $timeFrom);
$d2 = date('Y-m-d', $timeTo);

$d1_prev = date('Y-m-d', $timeFromPrev);
$d2_prev = date('Y-m-d', $timeToPrev);

$html_navigation = '';
$html_navigation .= '<ul class="navigation row row-around">';
foreach ($navigation as $navigation_key => $navigation_value) {
    $navigation_classes = [];
    if (!empty($navigation_value['active'])) {
        $navigation_classes[] = 'active';
    }

    $new_window = '';
    if (!empty($navigation_value['target'])) {
        $new_window = ' target="_blank"';
    }

    $navigation_class = implode(' ', $navigation_classes);
    $html_navigation .= '<a href="' . $navigation_value['link'] . '" ' . $new_window . '>';
    $html_navigation .= '<li class="column column-auto">';
    $html_navigation .= '<i class="icon icon-' . $navigation_value['name'] . ' ' . $navigation_class . '"></i>';
    $html_navigation .= '</li>';
    $html_navigation .= '</a>';
}
$html_navigation .= '</ul>';
$html_navigation .= '';

?>
<!doctype html>
<html class="root" lang="en" prefix="og: http://ogp.me/ns#" dir="ltr" translate="no">
<head>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="width=device-width, initial-scale=1, viewport-fit=cover" name="viewport">
    <link href="/favicon.png" rel="icon" type="image/png">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="default" name="apple-mobile-web-app-status-bar-style">
    <meta content="none" name="msapplication-config">
    <link href="/assets/main.css?<?= VERSION ?>" rel="stylesheet">
    <title>BGReport</title>
    <meta name="description" content="BGReport">
    <meta content="no-cache, no-store, must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="Pragma">
    <meta content="0" http-equiv="Expires">
    <meta name="google" value="notranslate">
    <meta name="google" content="notranslate">
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>
<body class="background background-lines interface-<?= $mobile ?>" data-version="<?= VERSION ?>" id="up">
<div class="slideout-panel_ slideout-panel-left_" id="panel_">
    <?php
    if (!isset($login_page)) {
        ?>
        <div class="header">
            <div class="container">
                <?= $html_navigation ?>
            </div>
        </div>
        <?php
    }
    ?>
    <main class="content">
