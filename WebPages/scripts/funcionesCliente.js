let listaClients;
let numPgClients = 1;

function crearTablaClientes(listaClientes) {
    console.log("Entramos a crearTablaClientes");
    let tabla = document.createElement('tbody');
    let fila;
    let hFila;
    let rut;
    let nombre;
    let direccion;
    let comuna;
    let mail;
    let telefono;
    let cliente;
    let cantPgs = Math.ceil(listaClientes.length / 10);
    let iMax = numPgClients * 10;
    let iStart = iMax - 10;
    if(cantPgs == numPgClients){
        iMax = listaClientes.length;
    }
    for (let i = iStart; i < iMax; i++) {
        cliente = listaClientes[i];
        fila = document.createElement('tr');
        hFila = document.createElement('th');
        hFila.setAttribute('scope', 'row');
        rut = document.createElement('td');
        nombre = document.createElement('td');
        direccion = document.createElement('td');
        comuna = document.createElement('td');
        mail = document.createElement('td');
        telefono = document.createElement('td');
        botones = document.createElement('td');
        hFila.innerHTML = i + 1;
        rut.innerHTML = cliente.rut;
        nombre.innerHTML = cliente.nombre;
        direccion.innerHTML = cliente.direccion;
        comuna.innerHTML = cliente.comuna;
        mail.innerHTML = cliente.email;
        telefono.innerHTML = cliente.telefono;
        botones.innerHTML = `<a href="javascript:recuperarCliente('` + cliente.rut + `')"><img src="imgs/editar.png" alt="" style="height:30px; width: 30px;"><a/>
        <a href="javascript:confirmarEliminar('Cliente', '` + cliente.rut + `')"><img src="imgs/borrar.png" alt="" style="height:30px; width: 30px;"></a>`;
        fila.appendChild(hFila);
        fila.appendChild(rut);
        fila.appendChild(nombre);
        fila.appendChild(direccion);
        fila.appendChild(comuna);
        fila.appendChild(mail);
        fila.appendChild(telefono);
        fila.appendChild(botones);
        tabla.appendChild(fila);
        tabla.id = "cuerpoTablaMostrarClientes";
    }
    actualizarElemento(tabla.id, tabla);
}

function recuperarClientes() {
    axios.get('php/CrudCliente.php?btnForm=leerClientes').then((response) => {
        listaClients = response.data;
        crearTablaClientes(listaClients);
        createPaginationClients(listaClients);
    });
}

function recuperarCliente(idCliente) {
    axios.get('php/CrudCliente.php?btnForm=leerCliente&idCliente=' + idCliente).then((response) => { intercambiarBotonAgregar('Cliente', response.data) });
}

function postClient() {
    let params = new URLSearchParams();
    let rut = document.getElementById('floatRutCliente').value;
    let nombre = document.getElementById('floatNombreCliente').value;
    let direccion = document.getElementById('floatDireccionCliente').value;
    let comuna = document.getElementById('floatSelectComunaCliente').value;
    let email = document.getElementById('floatEmailCliente').value;
    let telefono = document.getElementById('floatTelefonoCliente').value;
    params.append('btnForm', 'agregarCliente');
    params.append('rutCliente', rut);
    params.append('nombreCliente', nombre);
    params.append('direccionCliente', direccion);
    params.append('comunaCliente', comuna);
    params.append('emailCliente', email);
    params.append('telefonoCliente', telefono);
    axios.post('php/CrudCliente.php', params)
        .then((response) => {
            console.log(response.data);
            if (response.data[0] == 'failed') {
                alert(response.data[1][0])
            } else {
                if (typeof response.data == 'string') {
                    if (Number(response.data.search("El Cliente ya existe"))) {
                        alert('El Cliente ya existe');
                    }
                } else {
                    alert('Cliente Agregado con Exito');
                }
            }
        })
        .catch((error) => {
            console.log(error);
        });
}

function createPaginationClients(listaClients){
    //const paginationClients = document.getElementById('paginationClients');
    const paginationClients = document.createElement('ul');
    paginationClients.id = 'paginationClients';
    paginationClients.setAttribute('class', 'pagination justify-content-center');
    const qtyItemsPage = 10;
    let qtyPages = Math.ceil(listaClients.length/qtyItemsPage);
    console.log(qtyPages);
    let li = document.createElement('li');
    li.setAttribute('class', 'page-item');
    let a = document.createElement('a');
    a.setAttribute('class', 'page-link');
    a.setAttribute('href', 'javascript:chngPageClient("<")');
    a.innerHTML = '<';
    li.appendChild(a);
    paginationClients.appendChild(li);
    for (let i = 0; i < qtyPages; i++) {
        let li = document.createElement('li');
        li.setAttribute('class', 'page-item');
        let a = document.createElement('a');
        a.setAttribute('class', 'page-link');
        a.setAttribute('href', 'javascript:passNumPageClient('+(i+1)+');');
        a.innerHTML = i + 1;
        li.appendChild(a);
        paginationClients.appendChild(li);
    }
    li = document.createElement('li');
    li.setAttribute('class', 'page-item');
    a = document.createElement('a');
    a.setAttribute('class', 'page-link');
    a.setAttribute('href', 'javascript:chngPageClient(">")');
    a.innerHTML = '>';
    li.appendChild(a);
    paginationClients.appendChild(li);
    actualizarElemento(paginationClients.id, paginationClients);
}

function passNumPageClient(numPage){
    numPgClients = numPage;
    crearTablaClientes(listaClients);
}

function chngPageClient(change){
    if (change == '<'){
        if (numPgClients > 1){
            numPgClients--;
            crearTablaClientes(listaClients);
        }
    }else{
        if (numPgClients < Math.ceil(listaClients.length/10)){
            numPgClients++;
            crearTablaClientes(listaClients);
        }
    }
}