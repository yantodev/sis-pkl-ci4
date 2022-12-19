async function getAllIdukaByMajor() {
    let major2 = document.getElementById("major_id2").value
    let tp2 = document.getElementById("tp2").value
    let data = {
        major: major2 ? major2 : document.getElementById("major_id").value,
        tp: tp2 ? tp2 : document.getElementById("tp").value
    }
    await fetchingData('/Iduka/findAllIdukaByMajorAndTp', data)
        .then(response => {
            if (response.responseData.responseCode === 200) {
                let iduka = document.getElementById("iduka");
                let iduka2 = document.getElementById("iduka2");
                let result;
                for (const element of response.result) {
                    result = "<option value=" + element.id + ">" + element.name + "</option>"
                    iduka.innerHTML += result
                    iduka2.innerHTML += result
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

async function getAllIdukaByTp() {
    await fetchingData('/Iduka/findAllIdukaByMajorAndTp',
        {
            tp: document.getElementById("tp").value,
            major: document.getElementById("major_id").value,
        })
        .then(response => {
            console.log(response)
            if (response.responseData.responseCode === 200) {
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

function findTeacherByTp() {
    fetchingData("/Teacher/findTeacherByTp", {
        tp: document.getElementById("tp-tugas").value
    }).then(response => {
        if (response.responseData.responseCode === 200) {
            let teacher = document.getElementById("teacher");
            let result;
            for (const element of response.result) {
                result = "<option value=" + element.user_public_id + ">" + element.name + "</option>"
                teacher.innerHTML += result
            }
        }
    }).catch(error => {
        console.log(error)
    })
}