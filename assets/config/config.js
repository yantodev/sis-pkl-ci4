let baseUrl = '';

function config(url) {
    baseUrl = url;
}

async function fetchingData(url = '', data = {}) {
    return fetch(baseUrl + url, {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
        redirect: 'follow',
        referrerPolicy: 'no-referrer',
        body: data ? JSON.stringify(data) : ''
    }).then(response => {
        return response.json()
    }).catch(error => {
        console.log(error)
    })
}