function agregarFilaProducto() {
    console.log("Entramos a agregarFilaProducto()");
    let productosCotizacion = document.getElementById("productosCotizacion");
    let cantHijosActu = productosCotizacion.children.length + 1;

    let divCodProd = document.createElement("div");
    divCodProd.setAttribute("class", "form-floating col-12 col-sm-3 col-md-4 mb-3");
    let inputCodProd = document.createElement("input");
    inputCodProd.setAttribute("class", "form-control");
    inputCodProd.setAttribute("list", "codProdList");
    inputCodProd.setAttribute("placeholder", "Escriba para buscar...");
    inputCodProd.setAttribute("id", "codProd" + cantHijosActu);
    inputCodProd.setAttribute("onchange", "loadWithCod(" + cantHijosActu + ")");
    let labelCodProd = document.createElement("label");
    labelCodProd.setAttribute("class", "ms-3");
    labelCodProd.innerHTML = "Código Producto";
    divCodProd.appendChild(inputCodProd);
    divCodProd.appendChild(labelCodProd);

    let divNomProd = document.createElement("div");
    divNomProd.setAttribute("class", "form-floating col-12 col-sm-6 col-md-6 mb-3");
    let inputNomProd = document.createElement("input");
    inputNomProd.setAttribute("class", "form-control");
    inputNomProd.setAttribute("list", "nameProdList");
    inputNomProd.setAttribute("placeholder", "Escriba para buscar...");
    inputNomProd.setAttribute("id", "nameProd" + cantHijosActu);
    inputNomProd.setAttribute("onchange", "loadWithName(" + cantHijosActu + ")");
    let labelNomProd = document.createElement("label");
    labelNomProd.setAttribute("class", "ms-3");
    labelNomProd.innerHTML = "Nombre Producto";
    divNomProd.appendChild(inputNomProd);
    divNomProd.appendChild(labelNomProd);

    let divCantProd = document.createElement("div");
    divCantProd.setAttribute("class", "form-floating col-12 col-sm-2 col-md-1 mb-3");
    let inputCantProd = document.createElement("input");
    inputCantProd.setAttribute("type", "number");
    inputCantProd.setAttribute("class", "form-control");
    inputCantProd.setAttribute("placeholder", "Cantidad");
    inputCantProd.setAttribute("value", "1");
    let labelCantProd = document.createElement("label");
    labelCantProd.setAttribute("class", "ms-3");
    labelCantProd.innerHTML = "Cantidad";
    divCantProd.appendChild(inputCantProd);
    divCantProd.appendChild(labelCantProd);

    let divBtn = document.createElement("div");
    divBtn.setAttribute("class", "form-floating col-12 col-sm-1 col-md-1 mb-3 d-flex align-items-center");
    let btnEliminar = document.createElement("button");
    btnEliminar.setAttribute("class", "btn btn-danger");
    btnEliminar.setAttribute("onclick", "eliminarFilaProducto('filaProducto" + cantHijosActu + "')");
    btnEliminar.setAttribute("class", "btn btn-danger");
    btnEliminar.setAttribute("type", "button");
    btnEliminar.innerHTML = "-";
    divBtn.appendChild(btnEliminar);

    let filaProductoNueva = document.createElement("div");
    filaProductoNueva.setAttribute("class", "row");
    filaProductoNueva.setAttribute("id", "filaProducto" + cantHijosActu);
    filaProductoNueva.appendChild(divCodProd);
    filaProductoNueva.appendChild(divNomProd);
    filaProductoNueva.appendChild(divCantProd);
    filaProductoNueva.appendChild(divBtn);
    productosCotizacion.appendChild(filaProductoNueva);

    /*let interiorFila = `<div class="form-floating col-12 col-sm-3 col-md-4 mb-3">
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
    productosCotizacion.appendChild(filaProductoNueva);*/
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
    let options = {day: 'numeric', month: 'numeric', year: 'numeric'};
    formData.append("btnForm", "addCotizacion")
    formData.append("fechaCotizacion", fechaCotizacion.toLocaleDateString('es-CL', options));
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
    axios.post("php/CrudCotizacion.php", formData).then((response) => {
        console.log(response);
        if (response.data[0] !== 'success') {
            alert(response.data[1][0])
        } else {
            alert('Cotización Agregada con Exito');
        }
    })
        .catch((error) => {
            console.log(error);
        });
    console.log(fechaCotizacion.toDateString());
}

function getCategorias(from) {
    axios.get('php/CrudCategoria.php?btnForm=leerCategorias&from=' + from).then(response => {
        console.log(response.data);
        loadCategorias(response.data);
    })
}

function loadCategorias(listaCategorias) {
    let dropdownCategoriasNew = document.createElement("div");
    let li;
    let a;
    for (i = 0; i < listaCategorias.length; i++) {
        li = document.createElement("li");
        a = document.createElement("a");
        a.setAttribute("class", "dropdown-item");
        a.setAttribute("href", "#");
        a.setAttribute("onclick", "changeToProducts('" + listaCategorias[i].nombre + "')");
        a.innerHTML = listaCategorias[i].nombre;
        li.appendChild(a);
        dropdownCategoriasNew.appendChild(li);
    }
    dropdownCategoriasNew.setAttribute("id", "dropdownCategorias");
    actualizarElemento(dropdownCategoriasNew.id, dropdownCategoriasNew);
}

function getCodNameProducts() {
    axios.get('php/CrudProduct.php?btnForm=leerProducts&filtro=null').then((response) => {
        console.log(response.data);
        dataList(response.data);
    });
}

let codList = [];
let nameList = [];

function dataList(codNameProdList) {
    let codDataList = document.getElementById("codProdList");
    let nameDataList = document.getElementById("nameProdList");
    let optionCod;
    let optionName;
    let codProd;
    let nameProd;
    for (i = 0; i < codNameProdList.length; i++) {
        codProd = codNameProdList[i].codigo;
        nameProd = codNameProdList[i].nombre;
        optionCod = document.createElement("option");
        optionCod.setAttribute("value", codProd);
        codDataList.appendChild(optionCod);
        optionName = document.createElement("option");
        optionName.setAttribute("value", nameProd);
        nameDataList.appendChild(optionName);
        codList.push(codProd);
        nameList.push(nameProd);
    }
    console.log(codList);
    console.log(nameList);
}

function loadWithCod(index) {
    let codProd = document.getElementById("codProd" + index).value;
    let indexCod = codList.indexOf(codProd);
    if(indexCod == -1){
        document.getElementById("nameProd" + index).value = "";
    }else{
        document.getElementById("nameProd" + index).value = nameList[indexCod];
    }
}

function loadWithName(index) {
    let nameProd = document.getElementById("nameProd" + index).value;
    let indexName = nameList.indexOf(nameProd);
    if(indexName == -1){
        document.getElementById("codProd" + index).value = "";
    }else{
        document.getElementById("codProd" + index).value = codList[indexName];
    }
}

function loadClientCotizacion() {
    console.log("Entramos a loadClientCotizacion");
    rut = document.getElementById("floatRUTCotizacion").value;
    axios.get('php/CrudCliente.php?btnForm=leerCliente&idCliente=' + rut).then((response) => {
        console.log(response.data);
        if(response.data == false){
            document.getElementById("floatNombreCotizacion").value = "";
            document.getElementById("floatDireccionCotizacion").value = "";
            document.getElementById("floatSelectComunaCotizacion").value = "";
            document.getElementById("floatEmailCotizacion").value = "";
            document.getElementById("floatTelefonoCotizacion").value = "";
        }else{
            document.getElementById("floatNombreCotizacion").value = response.data.nombre;
            document.getElementById("floatDireccionCotizacion").value = response.data.direccion;
            document.getElementById("floatSelectComunaCotizacion").value = response.data.comuna;
            document.getElementById("floatEmailCotizacion").value = response.data.email;
            document.getElementById("floatTelefonoCotizacion").value = response.data.telefono;
        }
    })
}