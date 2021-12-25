let listaProviders;
let numPgProviders = 1;

function crearTablaProveedores(listaProveedores) {
    let cantPgs = Math.ceil(listaProveedores.length / 10);
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
    let iMax = numPgProviders * 10;
    let iStart = iMax - 10;
    if(cantPgs == numPgProviders){
        iMax = listaProveedores.length;
    }
    for (i = iStart; i < iMax; i++) {
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
        botones.innerHTML = `<a href="javascript:recuperarProveedor('` + proveedor.rut + `')"><img src="imgs/editar.png" alt="" style="height:30px; width: 30px;"><a/>
        <a href="javascript:confirmarEliminar('Proveedor', '` + proveedor.rut + `')"><img src="imgs/borrar.png" alt="" style="height:30px; width: 30px;"></a>`;
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

function recuperarProveedores() {
    axios.get('php/CrudProveedor.php?btnForm=leerProveedores').then((response) => {
        listaProviders = response.data;
        crearTablaProveedores(listaProviders);
        createPaginationProviders(listaProviders);
    });
}

function recuperarProveedor(idProveedor) {
    axios.get('php/CrudProveedor.php?btnForm=leerProveedor&idProveedor=' + idProveedor).then((response) => { intercambiarBotonAgregar('Proveedor', response.data) });
}

function postProveedor() {
    let params = new URLSearchParams();
    let rut = document.getElementById('floatRutProveedor').value;
    let nombre = document.getElementById('floatNombreProveedor').value;
    let direccion = document.getElementById('floatDireccionProveedor').value;
    let comuna = document.getElementById('floatSelectComunaProveedor').value;
    let email = document.getElementById('floatEmailProveedor').value;
    let telefono = document.getElementById('floatTelefonoProveedor').value;
    params.append('btnForm', 'agregarProveedor');
    params.append('rutProveedor', rut);
    params.append('nombreProveedor', nombre);
    params.append('direccionProveedor', direccion);
    params.append('comunaProveedor', comuna);
    params.append('emailProveedor', email);
    params.append('telefonoProveedor', telefono);
    axios.post('php/CrudProveedor.php', params)
        .then((response) => {
            console.log(response.data);
            if (response.data[0] == 'failed') {
                alert(response.data[1][0])
            } else {
                if (typeof response.data == 'string') {
                    if (Number(response.data.search("El Proveedor ya existe"))) {
                        alert('El Proveedor ya existe');
                    }
                } else {
                    alert('Proveedor Agregado con Exito');
                }
            }
        })
        .catch((error) => {
            console.log(error);
        });
}

function createPaginationProviders(listaProviders){
    const paginationProviders = document.createElement('ul');
    paginationProviders.id = 'paginationProviders';
    paginationProviders.setAttribute('class', 'pagination justify-content-center');
    const qtyItemsPage = 10;
    let qtyPages = Math.ceil(listaProviders.length/qtyItemsPage);
    console.log(qtyPages);
    let li = document.createElement('li');
    li.setAttribute('class', 'page-item');
    let a = document.createElement('a');
    a.setAttribute('class', 'page-link');
    a.setAttribute('href', 'javascript:chngPageProvider("<")');
    a.innerHTML = '<';
    li.appendChild(a);
    paginationProviders.appendChild(li);
    for (let i = 0; i < qtyPages; i++) {
        let li = document.createElement('li');
        li.setAttribute('class', 'page-item');
        let a = document.createElement('a');
        a.setAttribute('class', 'page-link');
        a.setAttribute('href', 'javascript:passNumPageProvider('+(i+1)+');');
        a.innerHTML = i + 1;
        li.appendChild(a);
        paginationProviders.appendChild(li);
    }
    li = document.createElement('li');
    li.setAttribute('class', 'page-item');
    a = document.createElement('a');
    a.setAttribute('class', 'page-link');
    a.setAttribute('href', 'javascript:chngPageProvider(">")');
    a.innerHTML = '>';
    li.appendChild(a);
    paginationProviders.appendChild(li);
    actualizarElemento(paginationProviders.id, paginationProviders);
}

function passNumPageProvider(numPage){
    numPgProviders = numPage;
    crearTablaProveedores(listaProviders);
}

function chngPageProvider(change){
    if (change == '<'){
        if (numPgProviders > 1){
            numPgProviders--;
            crearTablaProveedores(listaProviders);
        }
    }else{
        if (numPgProviders < Math.ceil(listaProviders.length/10)){
            numPgProviders++;
            crearTablaProveedores(listaProviders);
        }
    }
}