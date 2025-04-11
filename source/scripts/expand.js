import {slideup} from "./animations";

const $expand_buttons = document.querySelectorAll('.js-expand-button');
$expand_buttons.forEach(($button) => {
    let name = $button.dataset.expand;
    let $content = document.querySelector('.js-expand-content[data-expand=' + name + ']');
    slideup($button, $content);
});
