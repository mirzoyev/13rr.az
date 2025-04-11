import {slideuptr} from "./animations";

const $expand_buttons = document.querySelectorAll('.js-expandtr-button');
$expand_buttons.forEach(($button) => {
    $button.style.cursor = 'row-resize';
    let name = $button.dataset.expandtr;
    let $content = document.querySelectorAll('.js-expandtr-content[data-expandtr=' + name + ']');
    slideuptr($button, $content);
});
