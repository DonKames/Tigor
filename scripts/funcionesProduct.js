function recuperarProduct(idProduct) {
    axios.get('../php/CrudProduct.php?btnForm=leerProduct&idProduct=' + idProduct).then((response) => { intercambiarBotonAgregar('Product', response.data) });
}

function recuperarProducts_Producto(filtro) {
    console.log('../php/CrudProduct.php?btnForm=leerProducts&filtro='+filtro);
    axios.get('../php/CrudProduct.php?btnForm=leerProducts&filtro='+filtro).then((response) => { 
        console.log(response);
        renderProducts(response.data); });
}

function recuperarProducts_Administrar() {
    axios.get('../php/CrudProduct.php?btnForm=leerProducts&filtro=null').then((response) => { crearTablaProducts(response.data); });
}

function renderProducts(productList) {
    let product;
    let cardText;
    let productName;
    let cardBody;
    let productImg;
    let card;
    let cardContainer;
    let productsBody = document.createElement("div");
    productsBody.setAttribute("class", "row");
    productsBody.id = "productsBody";
    for (i = 0; i < productList.length; i++) {
        product = productList[i];
        cardContainer = document.createElement("div");
        cardContainer.setAttribute("class", "col-12 col-md-4 mb-3");
        card = document.createElement("div");
        card.setAttribute("class", "card h-100");
        productImg = document.createElement("img");
        productImg.src = "../imgs/products/"+product.codigo;
        productImg.setAttribute("class", "card-img-top");
        productImg.setAttribute("onerror", "this.onerror=null; this.src='../imgs/products/asdfasdf4312'");
        cardBody = document.createElement("div");
        cardBody.setAttribute("class", "card-body");
        productName = document.createElement("h5");
        productName.innerHTML = product.nombre;
        cardText = document.createElement("p");
        cardText.setAttribute("class", "card-text");
        cardText.innerHTML = product.descripcion;
        cardBody.appendChild(productName);
        cardBody.appendChild(cardText);
        card.appendChild(productImg);
        card.appendChild(cardBody);
        cardContainer.appendChild(card);
        productsBody.appendChild(cardContainer);
    }
    actualizarElemento(productsBody.id, productsBody);
}

function crearTablaProducts(listaProducts) {
    console.log("Entramos a crearTablaProducts");
    console.log(listaProducts);
    let tabla = document.createElement('tbody');
    let categoria;
    let fila;
    let hFila;
    let codigo;
    let nombre;
    for (i = 0; i < listaProducts.length; i++) {
        product = listaProducts[i];
        fila = document.createElement('tr');
        hFila = document.createElement('th');
        hFila.setAttribute('scope', 'row');
        codigo = document.createElement('td');
        nombre = document.createElement('td');
        categoria = document.createElement('td');
        botones = document.createElement('td');
        hFila.innerHTML = i + 1;
        codigo.innerHTML = product.codigo;
        nombre.innerHTML = product.nombre;
        categoria.innerHTML = product.categoria;
        botones.innerHTML = `<a href="javascript:recuperarProduct('` + product.codigo + `')"><img src="../imgs/editar.png" alt="" style="height:30px; width: 30px;"><a/>
        <a href="javascript:confirmarEliminar('Product', '` + product.codigo + `')"><img src="../imgs/borrar.png" alt="" style="height:30px; width: 30px;"></a>`;
        fila.appendChild(hFila);
        fila.appendChild(codigo);
        fila.appendChild(nombre);
        fila.appendChild(categoria);
        fila.appendChild(botones);
        tabla.appendChild(fila);
        tabla.codigo = "cuerpoTablaMostrarProducts";
    
    }
    actualizarElemento(tabla.codigo, tabla);
}