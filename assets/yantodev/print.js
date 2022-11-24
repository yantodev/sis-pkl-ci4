async function getAllIdukaByMajor() {
    let major = document.getElementById("major_id").value;
    let tp = document.getElementById("tp").value;
    console.log("major " + major, "tp " + tp)
    await fetchingData('/Iduka/findAllIdukaByMajorAndTp',
        {
            major: document.getElementById("major_id").value,
            tp: document.getElementById("tp").value
        })
        .then(response => {
            if (response.code === 200) {
                let iduka = document.getElementById("iduka");
                let result;
                for (const element of response.result) {
                    result = "<option value=" + element.id + ">" + element.name + "</option>"
                    iduka.innerHTML += result
                }
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