function agregarFilaProducto() {
    console.log("Entramos a agregarFilaProducto()");
    let productosCotizacion = document.getElementById("productosCotizacion");
    let cantHijosActu = productosCotizacion.children.length + 1;
    let filaProductoNueva = document.createElement("div");
    filaProductoNueva.className = "row";
    let interiorFila = `<div class="form-floating col-12 col-sm-3 col-md-4 mb-3">
        <input class="form-control" list="datalistOptionsCodigoProductoCotizacion"
            id="datalistCodigoProducto" placeholder="Escriba para buscar...">
        <datalist id="datalistOptionsCodigoProductoCotizacion">
            <option value="Escobillas">
            <option value="Aceites">
            <option value="Antiparras">
            <option value="Guantes">
            <option value="ETC">
        </datalist>
        <label for="exampleDataList" class="ms-3">Codigo Producto</label>
    </div>
    <div class="form-floating col-12 col-sm-6 col-md-6 mb-3">
        <input class="form-control" list="datalistOptionsNombreProductoCotizacion"
            id="datalistNombreProducto" placeholder="Escriba para buscar...">
        <datalist id="datalistOptionsNombreProductoCotizacion">
            <option value="Escobillas">
            <option value="Aceites">
            <option value="Antiparras">
            <option value="Guantes">
            <option value="ETC">
        </datalist>
        <label for="exampleDataList" class="ms-3">Nombre Producto</label>
    </div>
    <div class="form-floating col-12 col-sm-2 col-md-1 mb-3">
        <input type="number" class="form-control" id="floatCantidadProductoCotizacion"
            placeholder="CantidadProductoCotizacion" value="1">
        <label for="floatCantidadProductoCotizacion" class="ms-3">Cantidad</label>
    </div>

    <div class="form-floating col-12 col-sm-1 col-md-1 mb-3 d-flex align-items-center">
        <button type="button" class="btn btn-danger" onclick="eliminarFilaProducto('filaProducto` + cantHijosActu + `')">-</button>
    </div>`;
    filaProductoNueva.id = "filaProducto" + cantHijosActu;
    filaProductoNueva.innerHTML = interiorFila;
    productosCotizacion.appendChild(filaProductoNueva);
}

function eliminarFilaProducto(idFilaProducto) {
    console.log("Entramos a eliminarFilaProducto()")
    let filaProducto = document.getElementById(idFilaProducto);
    let padre = filaProducto.parentNode;
    padre.removeChild(filaProducto);
}

function postCotizacion() {
    let formData = new FormData();
    let fechaCotizacion = new Date();
    let rutCotizacion = document.getElementById("floatRUTCotizacion").value;
    let nombreCotizacion = document.getElementById("floatNombreCotizacion").value;
    let direccionCotizacion = document.getElementById("floatDireccionCotizacion").value;
    let comunaCotizacion = document.getElementById("floatSelectComunaCotizacion").value;
    let emailCotizacion = document.getElementById("floatEmailCotizacion").value;
    let telefonoCotizacion = document.getElementById("floatTelefonoCotizacion").value;
    let cantProds = document.getElementById("productosCotizacion").children.length;
    let listaCodigos = [];
    let listaNombres = [];
    let listaCantidades = [];
    formData.append("btnForm", "addCotizacion")
    formData.append("fechaCotizacion", fechaCotizacion.toLocaleDateString());
    formData.append("rutCotizacion", rutCotizacion);
    formData.append("nombreCotizacion", nombreCotizacion);
    formData.append("direccionCotizacion", direccionCotizacion);
    formData.append("comunaCotizacion", comunaCotizacion);
    formData.append("emailCotizacion", emailCotizacion);
    formData.append("telefonoCotizacion", telefonoCotizacion);
    console.log(formData);
    for (i = 0; i < cantProds; i++) {
        listaCodigos[i] = document.getElementById("productosCotizacion").children[i].children[0].children[0].value;
        listaNombres[i] = document.getElementById("productosCotizacion").children[i].children[1].children[0].value;
        listaCantidades[i] = document.getElementById("productosCotizacion").children[i].children[2].children[0].value;
    }
    formData.append("listaCodigos", listaCodigos);
    formData.append("listaNombres", listaNombres);
    formData.append("listaCantidades", listaCantidades);
    axios.post("../php/CrudCotizacion.php", formData).then((response) => {
        console.log(response);
        if (response.data[0] !== 'success'){
            alert(response.data[1][0])
        } else {
            alert('Producto Agregado con Exito');
        }
    })
        .catch((error) => {
            console.log(error);
        });
    console.log(fechaCotizacion.toDateString());
}