function login() {
    console.log("cek data")
    Swal.fire({
        title: 'Login Form',
        html: `<input type="text" id="email" name="email" class="swal2-input" placeholder="Email">
  <input type="password" id="password" name="password" class="swal2-input" placeholder="Password">`,
        confirmButtonText: 'Sign in',
        focusConfirm: false,
        showCancelButton: true,
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const email = Swal.getPopup().querySelector('#email').value
            const password = Swal.getPopup().querySelector('#password').value
            if (!email || !password) {
                Swal.showValidationMessage(`Please enter login and password`)
            }
            $.ajax({
                type: "POST",
                url: configUrl + "auth/login",
                data: {
                    email: login,
                    password: password
                },
                cache: false,
                dataType: "json",
                beforeSend: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function () {
                },
                error:function (e){
                    console.log(e)
                }
            });
        },
        allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
        if (result.isConfirmed) {
            console.log(result)
            // Swal.fire({
            //     icon: "success",
            //     title: "data added successfully!!!",
            // });
            // setTimeout(function () {
            //     window.location.reload(1);
            // }, 1000);
        }
    });
}