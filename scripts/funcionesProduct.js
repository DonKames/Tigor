function recuperarProduct(idProduct) {
    axios.get('../php/CrudProduct.php?btnForm=leerProduct&idProduct=' + idProduct).then((response) => { intercambiarBotonAgregar('Product', response.data) });
}

function recuperarProducts_Producto(filtro) {
    if (localStorage['filtro']) {
        let filtro = localStorage['filtro'];
        localStorage.removeItem('filtro');
        console.log(filtro);
        axios.get('../php/CrudProduct.php?btnForm=leerProducts&filtro=' + filtro).then((response) => { 
            console.log(response);
            renderProducts(response.data);
        });
    } else {
        console.log('../php/CrudProduct.php?btnForm=leerProducts&filtro=' + filtro);
        axios.get('../php/CrudProduct.php?btnForm=leerProducts&filtro=' + filtro).then((response) => {
            console.log(response);
            renderProducts(response.data);
        });
    }
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
    let contImg;
    productsBody.setAttribute("class", "row");
    productsBody.id = "productsBody";
    for (i = 0; i < productList.length; i++) {
        product = productList[i];
        contImg = document.createElement("div");
        cardContainer = document.createElement("div");
        cardContainer.setAttribute("class", "col-12 col-md-4 mb-3");
        card = document.createElement("div");
        card.setAttribute("class", "card h-100");
        productImg = document.createElement("img");
        productImg.src = "../imgs/products/" + product.codigo;
        productImg.setAttribute("class", "card-img-top h-100 mt-0 align-top");
        productImg.setAttribute("onerror", "this.onerror=null; this.src='../imgs/logoTigor.svg'");
        cardBody = document.createElement("div");
        cardBody.setAttribute("class", "card-body");
        productName = document.createElement("h4");
        productName.innerHTML = product.nombre;
        cardText = document.createElement("p");
        cardText.setAttribute("class", "card-text");
        cardText.innerHTML = product.descripcion;
        cardBody.appendChild(productName);
        cardBody.appendChild(cardText);
        contImg.appendChild(productImg);
        card.appendChild(contImg);
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

function postProduct() {
    //let params = new URLSearchParams();
    let formData = new FormData();
    let codigo = document.getElementById('floatCodigoProduct').value;
    let nombre = document.getElementById('floatNombreProduct').value;
    let categoria = document.getElementById('floatSelectCategoriaProduct').value;
    let descripcion = document.getElementById('floatDescripcionProduct').value;
    let img = document.querySelector('#subirArchivo').files[0];
    console.log(img);
    formData.append('btnForm', 'agregarProduct');
    formData.append('codigoProduct', codigo);
    formData.append('nombreProduct', nombre);
    formData.append('categoriaProduct', categoria);
    formData.append('descripcionProduct', descripcion);
    formData.append('imgProduct', img);
    axios.post('../php/CrudProduct.php', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
        .then((response) => {
            console.log(response);
            if (response.data[0] == 'failed') {
                alert(response.data[1][0])
            } else {
                alert('Producto Agregado con Exito');
            }
        })
        .catch((error) => {
            console.log(error);
        });
}