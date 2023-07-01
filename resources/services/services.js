class ApiService {
    static async post(url, data) {
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
                    return res.json()||res.text()
                }
            }).catch((res) => {
                return res;
            })
        } catch (error) {
            console.error(error);
        }
    };
}
export { ApiService };
