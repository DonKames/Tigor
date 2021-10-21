function crearTablaProveedores(listaProveedores) {
    console.log("Entramos a crearTablaProveedores");
    let tabla = document.createElement('tbody');
    let fila;
    let hFila;
    let rut;
    let nombre;
    let direccion;
    let comuna;
    let mail;
    let telefono;
    for (i = 0; i < listaProveedores.length; i++) {
        proveedor = listaProveedores[i];
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
        rut.innerHTML = proveedor.rut;
        nombre.innerHTML = proveedor.nombre;
        direccion.innerHTML = proveedor.direccion;
        comuna.innerHTML = proveedor.comuna;
        mail.innerHTML = proveedor.email;
        telefono.innerHTML = proveedor.telefono;
        botones.innerHTML = `<a href="javascript:recuperarProveedor('` + proveedor.rut + `')"><img src="../imgs/editar.png" alt="" style="height:30px; width: 30px;"><a/>
        <a href="javascript:confirmarEliminar('Proveedor', '` + proveedor.rut + `')"><img src="../imgs/borrar.png" alt="" style="height:30px; width: 30px;"></a>`;
        fila.appendChild(hFila);
        fila.appendChild(rut);
        fila.appendChild(nombre);
        fila.appendChild(direccion);
        fila.appendChild(comuna);
        fila.appendChild(mail);
        fila.appendChild(telefono);
        fila.appendChild(botones);
        tabla.appendChild(fila);
        tabla.id = "cuerpoTablaMostrarProveedores";
    }
    actualizarElemento(tabla.id, tabla);
}


function recuperarProveedores(){
    axios.get('../php/CrudProveedor.php?btnForm=leerProveedores').then((response) => {crearTablaProveedores(response.data);});
}

function recuperarProveedor(idProveedor) {
    axios.get('../php/CrudProveedor.php?btnForm=leerProveedor&idProveedor=' + idProveedor).then((response) => {intercambiarBotonAgregar('Proveedor', response.data)});
}