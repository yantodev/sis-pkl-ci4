function getStudentByMajor() {
    let majorId = document.getElementById("major").value;
    window.location.href = baseUrl + '/admin/data?major=' + majorId;
}

async function editStudent(id, masterDataId) {
    console.log(masterDataId)
    let student = await getDetailStudent(id)
    let iduka = await findIdukaByMajor(student.majorId);
    Swal.fire({
        title: "Edit Siswa",
        html: `
            <div>
                <div class="mb-3">
                    <input class="form-control" type="text" id="name" value="${student.name}" readonly/>
                </div>
                <div class="mb-3">
                    <select class="form-control" type="text" id="kelas" readonly>
                        <option value="${student.classId}">${student.kelas}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <select class="form-control" type="text" id="major" readonly>
                        <option value="${student.majorId}">${student.major}</option>
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
            console.log(student)
            fetchingData('/RestApi/updateMasterDataStudent/', {
                id: masterDataId,
                nis: student.nis,
                tp: student.tpId,
                iduka: Swal.getPopup().querySelector("#iduka").value
            })
                .then(response => {
                    if (response.code === 200) {
                        Swal.fire({
                            icon: response.message,
                            title: "data updated successfully!!!",
                        });
                        console.log(response)
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
