function pendamping() {
    let major = document.getElementById("major").value;
    let tp = document.getElementById("tp").value;
    console.log(major, tp)
    window.location.href = baseUrl + '/admin/pendamping?major=' + major + '&tp=' + tp;
}

async function addPendamping() {
    let major, tp = [];
    await getGetMajor().then(r => {
        major = r.innerHTML
    })
    await findTp().then(x => {
        tp = x.innerHTML
    })
    Swal.fire({
        title: "Tambah Pendamping",
        html: `
            <div>
                <div class="mb-3">
                    <select class="form-control" type="text" id="major" class="swal2-input">
                        ${major}
                    </select>
                </div>
                <div class="mb-3">
                    <select class="form-control" type="text" id="tp" class="swal2-input">
                        ${tp}
                    </select>
                </div>
                <div>
                    <input class="form-control" type="text" id="address" class="swal2-input" placeholder="Alamat Lokasi PKL" >
                </div>
            </div>
                `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Add",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            console.log(Swal.getPopup().querySelector("#major").value, Swal.getPopup().querySelector("#tp").value)
            fetchingData('/Iduka/addIduka', {
                // name: Swal.getPopup().querySelector("#name").value,
                // address: Swal.getPopup().querySelector("#address").value,
                // major: Swal.getPopup().querySelector("#major").value
            }).then(response => {
                if (response.code === 200) {
                    Swal.fire({
                        icon: "success", title: "Added data successfully!!!"
                    })
                    setTimeout(function () {
                        window.location.reload(1);
                    }, 3000);
                } else {
                    Swal.fire({
                        icon: "error", title: response.code, text: response.message
                    })
                }
            })
        }
    })
}

async function getGetMajor() {
    fetchingData('/Major/findAllMajor').then(response => {
        let major = [];
        for (const element of response.result) {
            let id = element.id;
            let name = element.name;
            major.push("<option value=" + id + ">" + name + "</option>");
        }
    }).catch(error => {
        console.log(error)
    })
    return major;
}

async function findTp() {
    fetchingData('/Tp/findAllTp').then(response => {
        let tp = [];
        for (const element of response.result) {
            let id = element.id;
            let name = element.name;
            tp.push("<option value=" + id + ">" + name + "</option>");
        }
    }).catch(error => {
        console.log(error)
    })
    return tp;
}