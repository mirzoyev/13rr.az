import {ajax} from './ajax';

const origin = document.location.origin;
//const path = window.location.pathname;


function loadVersion() {
    return ajax(origin + '/API/version.php', 'GET').then(data => {
        return data.version;
    });
}

loadVersion().then(APIversion => {
    let HTMLVersion = document.body.dataset.version;
    if (HTMLVersion) {
        if (Number(HTMLVersion) !== Number(APIversion)) {
			console.log('HTMLVersion: ', HTMLVersion);
			console.log('APIversion: ', APIversion);
        }
    }
});
