function postContact() {
    let name = document.getElementById("contactName").value;
    let email = document.getElementById("contactEmail").value;
    let phone = document.getElementById("contactPhone").value;
    let message = document.getElementById("contactMessage").value;
    let params = new FormData();
    params.append('contactName', name);
    params.append('contactEmail', email);
    params.append('contactPhone', phone);
    params.append('contactMessage', message);
    params.append('btnForm', 'addContact');
    axios.post('php/CrudContact.php', params)
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

function getContacts() {
    data = {
        btnForm: 'readContacts'
    };
    axios.get('php/CrudContact.php', { params: data }).then((response) => {
        crearTablaContacts(response.data);
        console.log(response.data)
    })
}

function crearTablaContacts(listaContacts) {
    let tbody = document.createElement('tbody');
    let fila;
    let hFila;
    let id;
    let nombre;
    let email;
    let telefono;
    let botones;
    let contact;
    for (i = 0; i < listaContacts.length; i++) {
        contact = listaContacts[i];
        fila = document.createElement('tr');
        hFila = document.createElement('th');
        hFila.setAttribute('scope', 'row');
        id = document.createElement('td');
        nombre = document.createElement('td');
        email = document.createElement('td');
        telefono = document.createElement('td');
        botones = document.createElement('td');
        hFila.innerHTML = i + 1;
        id.innerHTML = contact.id;
        nombre.innerHTML = contact.name;
        email.innerHTML = contact.email;
        telefono.innerHTML = contact.phone;
        botones.innerHTML = `<a href="javascript:renderResponderContact(` + contact.id + `)"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-file-earmark-richtext text-dark" viewBox="0 0 16 16">
            <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
            <path d="M4.5 12.5A.5.5 0 0 1 5 12h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zm0-2A.5.5 0 0 1 5 10h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zm1.639-3.708 1.33.886 1.854-1.855a.25.25 0 0 1 .289-.047l1.888.974V8.5a.5.5 0 0 1-.5.5H5a.5.5 0 0 1-.5-.5V8s1.54-1.274 1.639-1.208zM6.25 6a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5z"/>
            </svg><a/>`;
        fila.appendChild(hFila);
        fila.appendChild(id);
        fila.appendChild(nombre);
        fila.appendChild(email);
        fila.appendChild(telefono);
        fila.appendChild(botones);
        tbody.appendChild(fila);
    }
    tbody.id = "cuerpoTablaMostrarContact";
    actualizarElemento(tbody.id, tbody);
}

function renderResponderContact(id){
    let data = {
        btnForm: 'readContact',
        id: id
    };
    axios.get('php/CrudContact.php', {params: data}).then((response) => {
        console.log(response);
        document.getElementById('btnAccordionMensajeContacto').click();
        document.getElementById('mailMsgContact').innerHTML = "Correo: " + response.data.email;
        document.getElementById('phoneMsgContact').innerHTML = "Teléfono: " + response.data.phone;
        document.getElementById('idMsgContact').innerHTML = "ID: " + response.data.id;
        document.getElementById('nameMsgContact').innerHTML = "Mensaje de: " + response.data.name;
        document.getElementById('messageMsgContact').innerHTML = "Mensaje: " + response.data.message;
    });
}