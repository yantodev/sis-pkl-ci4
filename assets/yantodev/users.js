function saveUserDetail() {
    const data = $('#nis').value;
    console.log(data)
}

function addUser() {
    alert("masih dalam pengembangan")
}

async function updateUser(id) {
    let student = await getDetailStudent(id)
    let kelas = await findAllClassByMajor(student.majorId);
    Swal.fire({
        title: "Edit Siswa",
        html: `
            <div>
                <div class="mb-3">
                    <input class="form-control" type="text" id="name" value="${student.name}"/>
                </div>
                <div class="mb-3">
                    <select class="form-control" type="text" id="kelas">
                        <option value="${student.classId}">${student.kelas}</option>
                        ${kelas}
                    </select>
                </div>
            </div>
                `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Update",
        showLoaderOnConfirm: true,
        preConfirm: async () => {
            let res = await findMajorByClass(Swal.getPopup().querySelector("#kelas").value)
            if (res != null) {
                fetchingData('/RestApi/updateUserDetails/', {
                    id,
                    name: Swal.getPopup().querySelector("#name").value,
                    major: res.major_id,
                    classId: Swal.getPopup().querySelector("#kelas").value
                }).then(response => {
                    if (response.code === 200) {
                        Swal.fire({
                            icon: response.message,
                            title: "data updated successfully!!!",
                        });
                        setTimeout(function () {
                            window.location.reload(1);
                        }, 2000);
                    }
                }).catch(error => {
                    Swal.fire(error.name, error.message, 'error');
                })
            } else {
                Swal.fire('Opsss!!', 'Update data gagal', 'error');
            }
        },
    })
}

function deleteUser() {
    alert("masih dalam pengembangan")
}