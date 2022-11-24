function getStudentByMajor(){
    let majorId = document.getElementById("major").value;
    window.location.href = baseUrl + '/admin/data?major=' + majorId;
}

function editStudent(nis){
    console.log(nis)
}