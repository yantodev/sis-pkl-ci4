function logout() {
    Swal.fire({
        title: 'Are you sure?',
        text: "You will exit this page and have to login again",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, logged out it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'GET',
                url: configUrl + '/auth/logout',
                success: function () {
                },
                error: function (e) {
                    console.log(e)
                }
            })
            Swal.fire({
                icon: 'success',
                title: 'Logout berhasil',
                text: 'Terima kasih telah menggunakan aplikasi ini',
            })
            setTimeout(function () {
                window.location.reload(1);
            }, 3000);
        }
    })
}