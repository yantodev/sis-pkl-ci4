function saveUserDetail() {
    const data = $('#nis').value;
    console.log(data)
}

function addUser() {
    alert("masih dalam pengembangan")
}

async function updateUser(id) {
    let student = await getDetailStudent(id)
    let kelas = await findAllClassByMajor(student.majorId)
    let tp = await findTp();
    Swal.fire({
        title: "Edit Siswa",
        html: `
            <div id="label-swal">
                <div class="mb-3">
                <label class="ml-3">NISN</label>
                    <input class="form-control" type="text" id="nisn" value="${student.nisn}"/>
                </div>
                <div class="mb-3">
                <label class="ml-3">Nama Lengkap</label>
                    <input class="form-control" type="text" id="name" value="${student.name}"/>
                </div>
                <div class="mb-3">
                <label class="ml-3">Kelas</label>
                    <select class="form-control" type="text" id="kelas">
                        <option value="${student.classId}">${student.kelas}</option>
                        ${kelas}
                    </select>
                </div>
                 <div class="mb-3">
                 <label class="ml-3">Tahun Pelajaran</label>
                    <select class="form-control" type="text" id="tp">
                        <option value="${student.tpId}">${student.tp}</option>
                        ${tp}
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
                    nisn :Swal.getPopup().querySelector("#nisn").value,
                    name: Swal.getPopup().querySelector("#name").value,
                    major: res.major_id,
                    classId: Swal.getPopup().querySelector("#kelas").value,
                    tp: Swal.getPopup().querySelector("#tp").value
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

function editUser(id) {
    alert("masih dalam pengembangan")
}

function resetPasswordUser(id) {
    alert("masih dalam pengembangan")
}

function resetDetailUser(id) {
    alert("masih dalam pengembangan")
}