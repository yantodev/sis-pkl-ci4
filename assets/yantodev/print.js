async function printApplicationLetter() {
    let tp = document.getElementById("tp").value;
    let id = document.getElementById("major_id").value;
    let iduka = document.getElementById("iduka").value;
    let instansi = document.getElementById("instansi").value;
    console.log(id, iduka);
    window.location.href = baseUrl + '/admin/printApplicationLetter/' + tp + "/" + id + "/" + iduka + "/" + instansi;
}

async function getAllIdukaByMajor() {
    let ids = document.getElementById("major_id").value;
    document.getElementById("iduka").hidden
    console.log("id jurusan" + ids);
    await fetchingData("/Iduka/getAllIdukaByMajor/" + ids)
        .then(response => {
            console.log(response.result)
            let iduka = document.getElementById("iduka");
            let result;
            for (const element of response.result) {
                result = "<option value=" + element.id + ">" + element.name + "</option>"
                iduka.innerHTML += result
            }
        })
        .catch(error => {
            Swal.fire({
                icon: "error",
                title: "print data is not successfully!!!",
                text: error
            })
        });
}