export function ajax(url, method = 'GET', data = null) {
    url += '?' + new Date().getTime();
    if (method === 'GET') {
        url += '&data=' + encodeURIComponent(JSON.stringify(data));
        data = null
    } else {
        url += '?method=' + method;
        method = 'POST';
    }

    return new Promise(function(resolve, reject) {
        let request = new XMLHttpRequest();
        request.open(method, url);
        request.setRequestHeader("X-Requested-With", "XMLHttpRequest");

        request.onload = () => {
            if (request.status === 200) {
                let data = {};
                if (isJSON(request.responseText)) {
                    data = JSON.parse(request.responseText);
                }
                resolve(data);
            } else {
                let error = new Error(request.statusText);
                error.code = request.status;
                reject(error);
            }
        };

        request.onerror = () => {
            reject(new Error("Ajax Load Error"));
        };

        request.send(data);
    });
}

function isJSON(string) {
    //return true;
    try {
        return (JSON.parse(string) && !!string);
    } catch (e) {
        return false;
    }
}
