function agregarFilaProducto(){
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

function eliminarFilaProducto(idFilaProducto){
    console.log("Entramos a eliminarFilaProducto()")
    let filaProducto = document.getElementById(idFilaProducto);
    let padre = filaProducto.parentNode;
    padre.removeChild(filaProducto);
}

