</main>

<?php
if (!isset($login_page)) {
    ?>
    <div class="footer">
        <div class="container">
            <div class="timebutton timebutton-left js-period-prev" data-timefrom="<?= $timePrevFrom ?>" data-timeto="<?= $timePrevTo ?>">
                <i class="icon icon-left"></i>
            </div>
            <div class="timebutton timebutton-right js-period-next" data-timefrom="<?= $timeNextFrom ?>" data-timeto="<?= $timeNextTo ?>">
                <i class="icon icon-right"></i>
            </div>
            <div class="js-expand-button" data-expand="footer_date">
                <div class="maindate align-center">
                    <?php

                    echo '<span class="dateFromHuman">';
                    echo date('M j, Y', $timeFrom);
                    echo '</span>';

                    $css_samedate = '';
                    if ($timeFrom == $timeTo) {
                        $css_samedate = 'hidden_date';
                    }
                    echo '<span class="dateDefis ' . $css_samedate . '">';
                    echo ' - ';
                    echo '</span>';

                    echo '<span class="dateToHuman ' . $css_samedate . '">';
                    echo date('M j, Y', $timeTo);
                    echo '</span>';
                    ?>
                </div>
            </div>
        </div>
        <div class="js-expand-content" data-expand="footer_date">
            <div class="align-center">
                <div class="gap gap-2"></div>
                <button class="button filter filter-current js-filter js-filter-day"><?= $loc[$language2]['time_day'] ?></button>
                <button class="button filter js-filter js-filter-week"><?= $loc[$language2]['time_week'] ?></button>
                <button class="button filter js-filter js-filter-month"><?= $loc[$language2]['time_month'] ?></button>
                <button class="button filter js-filter js-filter-year"><?= $loc[$language2]['time_year'] ?></button>
                <div class="gap gap-2"></div>
                <div class="row row-center">
                    <div class="column">
                        <div class="inputbox align-left">
                            <?= $loc[$language2]['time_from'] ?>:<br>
                            <input class="date js-date-from" value="">
                        </div>
                    </div>
                    <div class="column align-left">
                        <div class="inputbox align-left">
                            <?= $loc[$language2]['time_to'] ?>:<br>
                            <input class="date js-date-to" value="">
                        </div>
                    </div>
                </div>
                <div class="gap gap-2"></div>
                <div class="row row-center">
                    <div class="column">
                        <div class="inputbox align-left">
                            <?= $loc[$language2]['time_from'] ?>:<br>
                            <input class="date js-date-from_prev" value="">
                        </div>
                    </div>
                    <div class="column align-left">
                        <div class="inputbox align-left">
                            <?= $loc[$language2]['time_to'] ?>:<br>
                            <input class="date js-date-to_prev" value="">
                        </div>
                    </div>
                </div>
                <div class="gap gap-2"></div>
                <div class="row row-center">
                    <div class="column">
                        <button class="button filter js-reload js-expand-button"
                                data-expand="footer_date"><?= $loc[$language2]['time_reload'] ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<div id="preloader" class="preloader"></div>
<script src="/assets/main.js?<?= VERSION ?>"></script>
</body>
</html>
