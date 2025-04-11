import Cookies from "js-cookie";

let languages = {
    0: 'en',
    1: 'en',
    2: 'ru',
    3: 'az',
};

let $languages = document.querySelectorAll('.js-language');
let previous_language = null;
for (let $language of $languages) {
    $language.addEventListener('change' , function() {
        if (this !== previous_language) {
            previous_language = this;
        }
        let language = languages[this.value];
        Cookies.set('language', language, { expires: 365, path: '/' });
        window.location.reload(true);
    }, false);
}

let $interfaces = document.querySelectorAll('.js-interface');
let previous_interface = null;
for (let $interface of $interfaces) {
    $interface.addEventListener('change' , function() {
        if (this !== previous_interface) {
            previous_interface = this;
        }
        let interface_ = this.value;
        Cookies.set('interface', interface_, { expires: 365, path: '/' });
        window.location.reload(true);
    }, false);
}
