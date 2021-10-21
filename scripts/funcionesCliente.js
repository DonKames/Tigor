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

    for (i = 0; i < listaClientes.length; i++) {
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
        botones.innerHTML = `<a href="javascript:recuperarCliente('` + cliente.rut + `')"><img src="../imgs/editar.png" alt="" style="height:30px; width: 30px;"><a/>
        <a href="javascript:confirmarEliminar('Cliente', '` + cliente.rut + `')"><img src="../imgs/borrar.png" alt="" style="height:30px; width: 30px;"></a>`;
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
    axios.get('../php/CrudCliente.php?btnForm=leerClientes').then((response) => { crearTablaClientes(response.data); });
}

function recuperarCliente(idCliente) {
    axios.get('../php/CrudCliente.php?btnForm=leerCliente&idCliente=' + idCliente).then((response) => { intercambiarBotonAgregar('Cliente', response.data) });
}