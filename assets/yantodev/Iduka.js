function getIduka() {
    var idJUrusan = document.getElementById("jurusan").value;
    $.ajax({
        type:'GET',
        url: configUrl + '/admin/iduka',
        data: {
            jurusan : idJUrusan
        },
        success: function () {
            window.location.href = configUrl + '/admin/iduka?jurusan=' + idJUrusan;
        },
        error: function (e) {
            console.log(e)
        }
    })
}