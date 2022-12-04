function updateTeacher(id) {
    fetchingData('/RestApi/findTeacherById', {id})
        .then(response => {
            console.log(response)
        })
        .catch(error => {
            console.log(error)
        })
}