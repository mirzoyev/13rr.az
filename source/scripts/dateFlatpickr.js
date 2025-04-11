import Cookies from "js-cookie";
import flatpickr from "flatpickr";

import { Azeri } from "flatpickr/dist/l10n/az"
import { Russian } from "flatpickr/dist/l10n/ru"

let currentLanguage = Cookies.get('language');
if (!currentLanguage) {
    currentLanguage = 'en';
}
let currentLocale;
if (currentLanguage === 'ru') {
    currentLocale = Russian;
} else {
    currentLocale = {
        firstDayOfWeek: 1
    };
}

function changePrevDates(calendarToPrev, calendarFromPrev) {
    //limit to current day
    let dateTodayClass = new Date();
    let dateTodayUnix = dateTodayClass.getTime();

    let dateFrom = Cookies.get('dateFromUnix');
    let dateTo = Cookies.get('dateToUnix');
    if (dateTo > dateTodayUnix) {
        dateTo = dateTodayUnix;
    }
    let dateDiff = dateTo - dateFrom;

    let dateTempTo = Cookies.get('dateFromUnix');
    dateTempTo = dateTempTo - msinDay;
    let dateTempToClass = new Date(+dateTempTo);
    calendarToPrev.setDate(dateTempToClass);
    Cookies.set('dateToUnixPrev', dateTempTo, {path: '/'});

    let dateTempFrom = Cookies.get('dateFromUnix');
    dateTempFrom = dateTempFrom - msinDay - dateDiff;
    let dateTempFromClass = new Date(+dateTempFrom);
    calendarFromPrev.setDate(dateTempFromClass);
    Cookies.set('dateFromUnixPrev', dateTempFrom, {path: '/'});
}

let msinDay = 86400 * 1000;

let $dateFrom = document.querySelector('.js-date-from');
let $dateTo = document.querySelector('.js-date-to');

let $dateFromPrev = document.querySelector('.js-date-from_prev');
let $dateToPrev = document.querySelector('.js-date-to_prev');

let $dateFromHuman = document.querySelector('.dateFromHuman');
let $dateToHuman = document.querySelector('.dateToHuman');
let $dateDefis = document.querySelector('.dateDefis');

let $filters = document.getElementsByClassName('js-filter');
let $filterDay = document.querySelector('.js-filter-day');
let $filterWeek = document.querySelector('.js-filter-week');
let $filterMonth = document.querySelector('.js-filter-month');

let $periodPrev = document.querySelector('.js-period-prev');
let $periodNext = document.querySelector('.js-period-next');

let bakuhours = 60 * 60 * 5 * 1000;

//const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

function getFirstDayOfLastMonth(yourDate) {
    //current month  + 1
    return new Date(yourDate.getFullYear(), yourDate.getMonth() - 1 + 1, 1);
}

function getLastDayOfLastMonth(yourDate) {
    //current month  + 1
    yourDate.setMonth(yourDate.getMonth() + 1);
    yourDate.setDate(1);
    yourDate.setHours(-12);
    return yourDate;
}

function getFirstDayOfLastWeek() {
    //current week  + 7
    const now = new Date();
    const dayOfWeek = now.getDay(); // Sunday - 0, Monday - 1, etc.
    const diffToMonday = dayOfWeek === 0 ? 6 : dayOfWeek - 1; // If today is Sunday, diff to last Monday is 6 days

    const lastMonday = new Date(now);
    lastMonday.setDate(now.getDate() - diffToMonday - 7 + 7); // Subtract to get to last week's Monday
    lastMonday.setHours(12, 0, 0, 0); // Set time to start of the day

    return lastMonday;
}

function getLastDayOfLastWeek() {
    //current week
    const now = new Date();
    const dayOfWeek = now.getDay(); // Sunday - 0, Monday - 1, etc.

    const lastSunday = new Date(now);
    lastSunday.setDate(now.getDate() - dayOfWeek + 7); // Subtract to get to last Sunday
    lastSunday.setHours(12, 59, 59, 999); // Set time to end of the day

    return lastSunday;
}

function hideShowHumanDate(from, to) {
    if (from == to) {
        $dateToHuman.classList.add('hidden_date');
        $dateDefis.classList.add('hidden_date');
    } else {
        $dateToHuman.classList.remove('hidden_date');
        $dateDefis.classList.remove('hidden_date');
    }
}

let $expandButton = document.querySelector('.js-expand-button');
if ($expandButton) {
    $expandButton.addEventListener('click', function (event) {
        $periodPrev.style.display = 'none';
        $periodNext.style.display = 'none';
        if ($expandButton.classList.contains('open')) {
            window.location.reload(true);
        }
    });
}

let $reloadButton = document.querySelector('.js-reload');
if ($reloadButton) {
    $reloadButton.addEventListener('click', function (event) {
        window.location.reload(true);
    });
}

if ($dateFrom && $dateTo && $dateFromPrev && $dateToPrev && $periodPrev && $periodNext) {
    let fromTime = Cookies.get('dateFromUnix');
    let fromTimeClass;
    if (fromTime) {
        fromTimeClass = new Date(+fromTime);
    } else {
        fromTimeClass = new Date();
    }
    let toTime = Cookies.get('dateToUnix');
    let toTimeClass;
    if (toTime) {
        toTimeClass = new Date(+toTime);
    } else {
        toTimeClass = new Date();
    }

    $periodPrev.addEventListener('click', function (event) {
        $expandButton.style.pointerEvents = 'none';
        $periodNext.style.pointerEvents = 'none';
        $periodPrev.style.pointerEvents = 'none';

        let dateFrom = $periodPrev.dataset.timefrom * 1000 - bakuhours;
        let dateTo = $periodPrev.dataset.timeto * 1000 - bakuhours;
        Cookies.set('dateFromUnix', dateFrom, {path: '/'});
        Cookies.set('dateToUnix', dateTo, {path: '/'});

        // let dateDayFromClass = fromTimeClass.fp_incr(-1);
        // let dateFromUnix = dateDayFromClass.getTime();
        // Cookies.set('dateFromUnix', dateFromUnix, {path: '/'});
        // let dateDayFromString = months[dateDayFromClass.getMonth()] + ' ' + dateDayFromClass.getDate() + ', ' + dateDayFromClass.getFullYear();
        // $dateFromHuman.innerText = dateDayFromString;
        // calendarFrom.setDate(dateDayFromClass);
        //
        // let dateDayToClass = toTimeClass.fp_incr(-1);
        // let dateToUnix = dateDayToClass.getTime();
        // Cookies.set('dateToUnix', dateToUnix, {path: '/'});
        // let dateDayToString = months[dateDayToClass.getMonth()] + ' ' + dateDayToClass.getDate() + ', ' + dateDayToClass.getFullYear();
        // $dateToHuman.innerText = dateDayToString;
        // calendarTo.setDate(dateDayToClass);
        //
        // hideShowHumanDate(dateDayFromString, dateDayToString);

        changePrevDates(calendarToPrev, calendarFromPrev);

        window.location.reload(true);
    }, false);

    $periodNext.addEventListener('click', function (event) {
        $expandButton.style.pointerEvents = 'none';
        $periodNext.style.pointerEvents = 'none';
        $periodPrev.style.pointerEvents = 'none';

        let dateFrom = $periodNext.dataset.timefrom * 1000 - bakuhours;
        let dateTo = $periodNext.dataset.timeto * 1000 - bakuhours;
        Cookies.set('dateFromUnix', dateFrom, {path: '/'});
        Cookies.set('dateToUnix', dateTo, {path: '/'});

        // let dateDayFromClass = fromTimeClass.fp_incr(1);
        // let dateFromUnix = dateDayFromClass.getTime();
        // Cookies.set('dateFromUnix', dateFromUnix, {path: '/'});
        // let dateDayFromString = months[dateDayFromClass.getMonth()] + ' ' + dateDayFromClass.getDate() + ', ' + dateDayFromClass.getFullYear();
        // $dateFromHuman.innerText = dateDayFromString;
        // calendarFrom.setDate(dateDayFromClass);
        //
        // let dateDayToClass = toTimeClass.fp_incr(1);
        // let dateToUnix = dateDayToClass.getTime();
        // Cookies.set('dateToUnix', dateToUnix, {path: '/'});
        // let dateDayToString = months[dateDayToClass.getMonth()] + ' ' + dateDayToClass.getDate() + ', ' + dateDayToClass.getFullYear();
        // $dateToHuman.innerText = dateDayToString;
        // calendarTo.setDate(dateDayToClass);
        //
        // hideShowHumanDate(dateDayFromString, dateDayToString);

        changePrevDates(calendarToPrev, calendarFromPrev);

        window.location.reload(true);
    }, false);

    $filterDay.addEventListener('click', function (event) {
        Cookies.set('period', 1, {path: '/'});

        let dateDayFromClass = new Date().fp_incr(-1);
        let dateFromUnix = dateDayFromClass.getTime();
        Cookies.set('dateFromUnix', dateFromUnix, {path: '/'});
        let dateDayFromString = months[dateDayFromClass.getMonth()] + ' ' + dateDayFromClass.getDate() + ', ' + dateDayFromClass.getFullYear();
        $dateFromHuman.innerText = dateDayFromString;
        calendarFrom.setDate(dateDayFromClass);

        let dateDayToClass = new Date().fp_incr(-1);
        let dateToUnix = dateDayToClass.getTime();
        Cookies.set('dateToUnix', dateToUnix, {path: '/'});
        let dateDayToString = months[dateDayToClass.getMonth()] + ' ' + dateDayToClass.getDate() + ', ' + dateDayToClass.getFullYear();
        $dateToHuman.innerText = dateDayToString;
        calendarTo.setDate(dateDayToClass);

        hideShowHumanDate(dateDayFromString, dateDayToString);

        changePrevDates(calendarToPrev, calendarFromPrev);
    }, false);

    $filterWeek.addEventListener('click', function (event) {
        Cookies.set('period', 7, {path: '/'});

        //let dateWeekFromClass = new Date().fp_incr(-7);
        let dateWeekFromClass = getFirstDayOfLastWeek(new Date());
        let dateFromUnix = dateWeekFromClass.getTime();
        Cookies.set('dateFromUnix', dateFromUnix, {path: '/'});
        let dateWeekFromString = months[dateWeekFromClass.getMonth()] + ' ' + dateWeekFromClass.getDate() + ', ' + dateWeekFromClass.getFullYear();
        $dateFromHuman.innerText = dateWeekFromString;
        calendarFrom.setDate(dateWeekFromClass);

        //let dateWeekToClass = new Date().fp_incr(-1);
        let dateWeekToClass = getLastDayOfLastWeek(new Date());
        let dateToUnix = dateWeekToClass.getTime();
        Cookies.set('dateToUnix', dateToUnix, {path: '/'});
        let dateWeekToString = months[dateWeekToClass.getMonth()] + ' ' + dateWeekToClass.getDate() + ', ' + dateWeekToClass.getFullYear();
        $dateToHuman.innerText = dateWeekToString;
        calendarTo.setDate(dateWeekToClass);

        hideShowHumanDate(dateWeekFromString, dateWeekToString);

        changePrevDates(calendarToPrev, calendarFromPrev);
    }, false);

    $filterMonth.addEventListener('click', function (event) {
        Cookies.set('period', 30, {path: '/'});

        //let dateMonthFromClass = new Date().fp_incr(-31);
        let dateMonthFromClass = getFirstDayOfLastMonth(new Date());
        let dateFromUnix = dateMonthFromClass.getTime();
        Cookies.set('dateFromUnix', dateFromUnix, {path: '/'});
        let dateMonthFromString = months[dateMonthFromClass.getMonth()] + ' ' + dateMonthFromClass.getDate() + ', ' + dateMonthFromClass.getFullYear();
        $dateFromHuman.innerText = dateMonthFromString;
        calendarFrom.setDate(dateMonthFromClass);

        //let dateMonthToClass = new Date().fp_incr(-1);
        let dateMonthToClass = getLastDayOfLastMonth(new Date());
        let dateToUnix = dateMonthToClass.getTime();
        Cookies.set('dateToUnix', dateToUnix, {path: '/'});
        let dateMonthToString = months[dateMonthToClass.getMonth()] + ' ' + dateMonthToClass.getDate() + ', ' + dateMonthToClass.getFullYear();
        $dateToHuman.innerText = dateMonthToString;
        calendarTo.setDate(dateMonthToClass);

        hideShowHumanDate(dateMonthFromString, dateMonthToString);

        changePrevDates(calendarToPrev, calendarFromPrev);
    }, false);

    let dateDefaultFrom = Cookies.get('dateFromUnix');
    if (dateDefaultFrom) {
        dateDefaultFrom = dateDefaultFrom * 1;

        for (let $currentFilter of $filters) {
            $currentFilter.classList.remove('filter-current');
        }
    } else {
        dateDefaultFrom = new Date().fp_incr(-2);
    }
    let calendarFrom = flatpickr($dateFrom, {
        locale: currentLocale,
        disableMobile: "true",
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        defaultDate: dateDefaultFrom,
        onChange: (selectedDates, dateStr, instance) => {
            let dateClass = new Date(dateStr);
            let dateFromUnix = dateClass.getTime();
            Cookies.set('dateFromUnix', dateFromUnix, {path: '/'});

            let [month, day, year] = [
                dateClass.getMonth(),
                dateClass.getDate(),
                dateClass.getFullYear(),
            ];
            let dateFromString = months[month] + ' ' + day + ', ' + year;
            $dateFromHuman.innerText = dateFromString;

            let dateToString = $dateToHuman.innerText;
            hideShowHumanDate(dateFromString, dateToString);

            changePrevDates(calendarToPrev, calendarFromPrev);
        }
    });

    let dateDefaultTo = Cookies.get('dateToUnix');
    if (dateDefaultTo) {
        dateDefaultTo = dateDefaultTo * 1;

        for (let $currentFilter of $filters) {
            $currentFilter.classList.remove('filter-current');
        }
    } else {
        dateDefaultTo = new Date().fp_incr(-1);
    }
    let calendarTo = flatpickr($dateTo, {
        locale: currentLocale,
        disableMobile: "true",
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        defaultDate: dateDefaultTo,
        onChange: (selectedDates, dateStr, instance) => {
            let dateClass = new Date(dateStr);
            let dateToUnix = dateClass.getTime();
            Cookies.set('dateToUnix', dateToUnix, {path: '/'});

            let [month, day, year] = [
                dateClass.getMonth(),
                dateClass.getDate(),
                dateClass.getFullYear(),
            ];
            let dateToString = months[month] + ' ' + day + ', ' + year;
            $dateToHuman.innerText = dateToString;

            let dateFromString = $dateFromHuman.innerText;
            hideShowHumanDate(dateFromString, dateToString);

            changePrevDates(calendarToPrev, calendarFromPrev);
        }
    });

    let dateDefaultFromPrev = Cookies.get('dateFromUnixPrev');
    if (dateDefaultFromPrev) {
        dateDefaultFromPrev = dateDefaultFromPrev * 1;

        for (let $currentFilter of $filters) {
            $currentFilter.classList.remove('filter-current');
        }
    } else {
        dateDefaultFromPrev = new Date().fp_incr(-2);
    }
    let calendarFromPrev = flatpickr($dateFromPrev, {
        locale: currentLocale,
        disableMobile: "true",
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        defaultDate: dateDefaultFromPrev,
        onChange: (selectedDates, dateStr, instance) => {
            let dateClass = new Date(dateStr);
            let dateFromUnixPrev = dateClass.getTime();
            Cookies.set('dateFromUnixPrev', dateFromUnixPrev, {path: '/'});
        }
    });

    let dateDefaultToPrev = Cookies.get('dateToUnixPrev');
    if (dateDefaultToPrev) {
        dateDefaultToPrev = dateDefaultToPrev * 1;

        for (let $currentFilter of $filters) {
            $currentFilter.classList.remove('filter-current');
        }
    } else {
        dateDefaultToPrev = new Date().fp_incr(-1);
    }
    let calendarToPrev = flatpickr($dateToPrev, {
        locale: currentLocale,
        disableMobile: "true",
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        defaultDate: dateDefaultToPrev,
        onChange: (selectedDates, dateStr, instance) => {
            let dateClass = new Date(dateStr);
            let dateToUnixPrev = dateClass.getTime();
            Cookies.set('dateToUnixPrev', dateToUnixPrev, {path: '/'});
        }
    });

    calendarFrom.config.onChange.push(function () {
        for (let $currentFilter of $filters) {
            $currentFilter.classList.remove('filter-current');
        }
        //change prev
    });
    calendarTo.config.onChange.push(function () {
        for (let $currentFilter of $filters) {
            $currentFilter.classList.remove('filter-current');
        }
        //change prev
    });
    for (let $filter of $filters) {
        $filter.addEventListener('click', function (event) {
            event.preventDefault();
            for (let $currentFilter of $filters) {
                $currentFilter.classList.remove('filter-current');
            }
            $filter.classList.add('filter-current');
        }, false);
    }
}
