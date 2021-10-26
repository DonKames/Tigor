function postContact() {
    let name = document.getElementById("contactName").value;
    let email = document.getElementById("contactEmail").value;
    let phone = document.getElementById("contactPhone").value;
    let message = document.getElementById("contactMessage").value;
    let params = new URLSearchParams();
    params.append('contactName', name);
    params.append('contactEmail', email);
    params.append('contactPhone', phone);
    params.append('contactMessage', message);
    params.append('btnForm', 'addContact');
    axios.post('../php/CrudContact.php', params)
        .then((response) => {
            console.log(response);
            if(response.data[0] == 'failed'){
                alert(response.data[1][0])
            }else{
                alert('Mensaje Agregado con Exito');
            }
        })
        .catch((error) => {
            console.log(error);
        });
}