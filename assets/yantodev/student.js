function getStudentByMajor() {
    let majorId = document.getElementById("major").value;
    window.location.href = baseUrl + '/admin/data?major=' + majorId;
}

async function editStudent(id) {
    let student = await getDetailStudent(id)
    let kelas = await findAllClassByMajor(student.majorId);
    let major = await findMajor();
    let iduka = await findIdukaByMajor(student.majorId);
    Swal.fire({
        title: "Edit Siswa",
        html: `
            <div>
                <div class="mb-3">
                    <input class="form-control" type="text" id="name" value="${student.name}"/>
                </div>
                <div class="mb-3">
                     <input class="form-control" type="hidden" id="userId" value="${student.id}"/>
                </div>
                <div class="mb-3">
                    <select class="form-control" type="text" id="kelas" >
                        <option value="${student.classId}">${student.kelas}</option>
                        ${kelas}
                    </select>
                </div>
                <div class="mb-3">
                    <select class="form-control" type="text" id="major" >
                        <option value="${student.majorId}">${student.major}</option>
                        ${major}
                    </select>
                </div>
                <div class="mb-3">
                    <select class="form-control" type="text" id="iduka" >
                        <option value="${student.idukaId}">${student.iduka}</option>
                        ${iduka}
                    </select>
                </div>
            </div>
                `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Update",
        showLoaderOnConfirm: true,
        preConfirm: async () => {
            let majorId = await findIdukaById(Swal.getPopup().querySelector("#iduka").value)
                .then(r => {
                    return r.major
                })
            let data = {
                id: Swal.getPopup().querySelector("#id").value,
                userId: Swal.getPopup().querySelector("#userId").value,
                iduka: Swal.getPopup().querySelector("#iduka").value,
                major: majorId,
                tp: result.tpId
            }
            fetchingData('/RestApi/updateTutor/', data)
                .then(response => {
                    if (response.code === 200) {
                        Swal.fire({
                            icon: response.message,
                            title: "data updated successfully!!!",
                        });
                        setTimeout(function () {
                            window.location.reload(1);
                        }, 2000);
                    }
                })
        },
    })
}

async function getDetailStudent(id) {
    return fetchingData('/RestApi/findStudentById', {id})
        .then(response => {
            if (response.code == 200) {
                return response.result
            }
            console.log(response)
        })
        .catch(error => {
            console.log(error)
        })
}
