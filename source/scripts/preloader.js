import {fadeOut} from './animations';

function hidePreloader() {
    let $preloader = document.getElementById('preloader');
    setTimeout(function () {
        fadeOut($preloader, 600);
    }, 250);
}

window.addEventListener('DOMContentLoaded' , hidePreloader, false);
