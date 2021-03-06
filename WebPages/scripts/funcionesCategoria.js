function recuperarCategoria(idCategoria) {
    axios.get('../php/CrudCategoria.php?btnForm=leerCategoria&idCategoria=' + idCategoria).then((response) => { intercambiarBotonAgregar('Categoria', response.data) });
}

function recuperarCategorias(from) {
    axios.get('php/CrudCategoria.php?btnForm=leerCategorias').then((response) => {
        switch (from) {
            case "administrar":
                addCategoryOptions(response.data);
                break;
            case "index":
                dropdownCategoriasIndex(response.data);
                break;
            case "products":
                dropdownCategoriasIndex(response.data);
                dropdownMenuCategorias(response.data);
                break;
        }
    });
}

function crearTablaCategorias(listaCategorias) {
    console.log("Entramos a crearTablaCategorias");
    let tabla = document.createElement('tbody');
    let categoria;
    let fila;
    let hFila;
    let id;
    let nombre;
    let select = document.createElement('select');
    select.id = "floatSelectCategoriaProduct";
    select.setAttribute("class", "form-select");
    select.class = "form-select";
    select.ariaLabel = "labelSelect";
    select.name = "categoriaProduct";
    option = document.createElement('option');
    option.innerHTML = "Seleccione una Categoria.";
    option.selected = true;
    option.value = 0;
    select.appendChild(option);
    for (i = 0; i < listaCategorias.length; i++) {
        categoria = listaCategorias[i];
        option = document.createElement('option');
        option.value = categoria.nombre;
        option.innerHTML = categoria.nombre;
        select.appendChild(option);
        fila = document.createElement('tr');
        hFila = document.createElement('th');
        hFila.setAttribute('scope', 'row');
        id = document.createElement('td');
        nombre = document.createElement('td');

        botones = document.createElement('td');
        hFila.innerHTML = i + 1;
        id.innerHTML = categoria.id;
        nombre.innerHTML = categoria.nombre;
        botones.innerHTML = `<a href="javascript:recuperarCategoria('` + categoria.id + `')"><img src="../imgs/editar.png" alt="" style="height:30px; width: 30px;"><a/>
        <a href="javascript:confirmarEliminar('Categoria', '` + categoria.id + `')"><img src="../imgs/borrar.png" alt="" style="height:30px; width: 30px;"></a>`;
        fila.appendChild(hFila);
        fila.appendChild(id);
        fila.appendChild(nombre);
        fila.appendChild(botones);
        tabla.appendChild(fila);
        tabla.id = "cuerpoTablaMostrarCategorias";

    }
    actualizarElemento(select.id, select);
    actualizarElemento(tabla.id, tabla);

}

function dropdownMenuCategorias(listaCategorias) {
    console.log(listaCategorias);
    let dropdownCategoriasIndex = document.getElementById("dropdownMenuCategorias");
    let option;
    let categoria;
    for (i = 0; i < listaCategorias.length; i++) {
        categoria = listaCategorias[i];
        option = document.createElement('li');
        option.setAttribute("class", "dropdown-item");
        option.setAttribute("href", "#");
        option.setAttribute("onclick", "recuperarProducts_Producto('" + categoria.nombre + "')");
        option.innerHTML = categoria.nombre;
        dropdownCategoriasIndex.appendChild(option);
    }
}

function dropdownCategoriasIndex(listaCategorias) {
    console.log(listaCategorias);
    let dropdownCategoriasIndex = document.getElementById("dropdownCategoriasIndex");
    let option;
    let categoria;
    let li;
    for (i = 0; i < listaCategorias.length; i++) {
        categoria = listaCategorias[i];
        li = document.createElement("li")
        option = document.createElement('a');
        option.setAttribute("class", "dropdown-item");
        option.setAttribute("href", "#");
        option.setAttribute("onclick", "changeToProducts('" + categoria.nombre + "')");
        option.innerHTML = categoria.nombre;
        li.appendChild(option);
        dropdownCategoriasIndex.appendChild(li);
    }
}

function renderCategorias(listaCategorias) {
    let renderCategorias = document.getElementById("renderCategorias");
    let divCategoria;
    let button;
    let nombreCategoria;
    let shadow;
    for (i = 0; i < listaCategorias.length; i++) {
        shadow = document.createElement("div")
        divCategoria = document.createElement("div");
        button = document.createElement("button");
        nombreCategoria = document.createElement("h1");
        categoria = listaCategorias[i];
        shadow.setAttribute("class", "col-12 g-3");
        divCategoria.setAttribute("class", "mb-2 d-grid shadow g-0");
        divCategoria.setAttribute("onclick", "changeToProducts('" + categoria.nombre + "')");
        button.setAttribute("class", "btn btn-primary bg-gradient ");
        button.setAttribute("type", "button");
        button.setAttribute("onclick", "changeToProducts('" + categoria.nombre+ "')")
        nombreCategoria.innerHTML = categoria.nombre;
        button.appendChild(nombreCategoria);
        divCategoria.appendChild(button);
        shadow.appendChild(divCategoria);
        renderCategorias.appendChild(shadow);
    }
}

function postCategoria(){
    let params = new URLSearchParams();
    let nombre = document.getElementById("floatNombreCategoria").value;
    params.append("btnForm", "agregarCategoria");
    params.append("nombreCategoria", nombre);
    axios.post('../php/CrudCategoria.php', params)
        .then((response) => {
            console.log(response);
            if (response.data[0] == "failed") {
                alert(response.data[1][0]);
            } else {
                alert('Categoria Agregada con Exito');
            }
        })
        .catch((error) => {
            console.log(error);
        });
}

function addCategoryOptions(listaCategorias){
    const selectCategoryProduct = document.getElementById("floatSelectCategoriaProduct");
    let optionCategoryProduct;
    let category;
    for (i = 0; i < listaCategorias.length; i++) {
        category = listaCategorias[i];
        optionCategoryProduct = document.createElement('option');
        optionCategoryProduct.innerHTML = category.nombre;
        optionCategoryProduct.value = category.nombre;
        selectCategoryProduct.appendChild(optionCategoryProduct);
    }
}