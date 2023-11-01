export async function cargarDatos(url) {
    try {
        return await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
        }).then((res) => {
            if (res.status == 200) {
                console.log('json', res);
                return res.json();
            }else{
                console.log('text', res);
                return res.text();
            }
        }).catch((res) => {
            console.error('aca entro', res);
            return [];
        })
    } catch (error) {
        console.error(error);
        return false;
    }
}

export async function enviarData(url, data) {
    try {
        return await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then((res) => {
            console.log(res);
            if (res.status == 200) {
                return res.json();
            }else{
                return res.text();
            }
        }).catch((res) => {
            console.error('aca entro', res);
            return res;
        })
    } catch (error) {
        console.error(error);
        return false;
    }
}
