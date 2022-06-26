function register() {
    Swal.fire({
        title: 'Registration Form',
        html: `
            <select id="role" name="role" class="swal2-select">
                <option value="">-- Pilih status --</option>
                <option value="3">Siswa</option>
                <option value="2">Guru</option>
            </select>
            <input type="text" id="email" name="email" class="swal2-input" placeholder="Email">
            <input type="password" id="password" name="password" class="swal2-input" placeholder="Password minimal 6 karakter">
            <input type="password" id="confpassword" name="confpassword" class="swal2-input" placeholder="Ulangi Password">`,
        confirmButtonText: 'Register',
        focusConfirm: false,
        showCancelButton: true,
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const role = Swal.getPopup().querySelector('#role').value
            const email = Swal.getPopup().querySelector('#email').value
            const password = Swal.getPopup().querySelector('#password').value
            const confpassword = Swal.getPopup().querySelector('#confpassword').value

            if (!role) {
                Swal.showValidationMessage(`Kolom status masih kosong!`)
            } else if (!email || !password) {
                Swal.showValidationMessage(`Email dan password tidak boleh kosong`)
            } else if (password != confpassword) {
                Swal.showValidationMessage(`Password tidak sama!!! Silahkan cek kembali`)
            }
            const data = { email: email };

            fetch(configUrl + "/RestApi/getUserByEmail", {
                method: 'POST', // or 'PUT'
                headers: {
                    'Content-Type': 'application/json;charset=utf-8"',
                },
                body: JSON.stringify(data),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.code == 200) {
                        Swal.fire({
                            icon: "error",
                            title: "Email sudah terdaftar!!!",
                            text: "Silahkan gunakan email lain"
                        });
                    } else {
                        $.ajax({
                            type: "POST",
                            url: configUrl + "/auth/register",
                            data: {
                                role: role,
                                email: email,
                                password: password
                            },
                            success: function () {
                                Swal.fire({
                                    icon: "success",
                                    title: "Register successfull!!!",
                                });
                                setTimeout(function () {
                                    window.location.reload(1);
                                }, 3000);
                            },
                            error: function (e) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Register failed!!!",
                                    text: e.status
                                });
                            }
                        });
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        },
        allowOutsideClick: () => !Swal.isLoading(),
    })
}

