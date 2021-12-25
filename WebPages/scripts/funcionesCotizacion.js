let listaQuotes;
let numPgQuotes = 1;

function goPDF(){
    let cantprods = document.getElementById('tBodyProdsCotizacion').childElementCount;
    console.log(cantprods);
    let inputValorUnitario;
    for (let i = 0; i < cantprods; i++) {
        inputValorUnitario = document.getElementById('unitario' + i).value;
        document.getElementById('valorUnitario' + i).innerHTML = inputValorUnitario;
    }
    let btnCrearPDF = document.getElementById('btnCrearPDF');
    btnCrearPDF.setAttribute('hidden', true);
    let htmlCotizacion = document.getElementById('cotizacion').innerHTML;
    sessionStorage.setItem('htmlCotizacion', htmlCotizacion);
    window.open("php/cotizacion.php","_blank");
    location.reload();
}

function aPDF(){
    let cotizacion = document.body;
    //html2pdf(cotizacion);
    html2pdf()
    .set({
        margin: 0.1,
        filename: 'documento.pdf',
        image: {
            type: 'jpeg',
            quality: 1
        },
        html2canvas: {
            scale: 5, // A mayor escala, mejores gráficos, pero más peso
            letterRendering: true,
        },
        jsPDF: {
            unit: "in",
            format: "letter",
            orientation: 'portrait' // landscape o portrait
        }
    })
    .from(cotizacion)
    .save()
    .catch(err => console.log(err));
}

function crearPDF(){
    let cotizacion = sessionStorage.getItem('htmlCotizacion');
    let body = document.getElementById("body");
    body.innerHTML = cotizacion;
    console.log("FUNCION crearPDF");
    aPDF();
}

function getCotizaciones() {
    data = {
        btnForm: 'readCotizaciones'
    };
    axios.get('php/CrudCotizacion.php', { params: data }).then((response) => {
        listaQuotes = response.data;
        crearTablaCotizaciones(listaQuotes);
        createPaginationQuotes(listaQuotes);
        console.log(listaQuotes)
    })
}

function getCotizacion(id) {
    console.log(id);
    params = {
        btnForm: 'readCotizacion',
        idCotizacion: id
    };
    axios.get('php/CrudCotizacion.php', { params: params }).then((response) => {
        console.log(response.data);
        rellenarCotizacion(response.data);
    })
}

function getProdsCotizacion(idCotizacion) {
    console.log(idCotizacion);
    params = {
        btnForm: 'readProdsCotizacion',
        idCotizacion: idCotizacion
    };
    axios.get('php/CrudCotizacion.php', { params: params }).then((response) => {
        console.log(response.data);
        crearTablaProdsCotizacion(response.data);
    })
}

function crearTablaCotizaciones(listaCotizaciones) {
    let tbody = document.createElement('tbody');
    let fila;
    let hFila;
    let id;
    let fecha;
    let rut;
    let nombre;
    let email;
    let botones;
    let cotizacion;
    let cantPgs = Math.ceil(listaCotizaciones.length / 10);
    let iMax = numPgQuotes * 10;
    let iStart = iMax - 10;
    if(cantPgs == numPgQuotes){
        iMax = listaCotizaciones.length;
    }
    for (let i = iStart; i < iMax; i++) {
        cotizacion = listaCotizaciones[i];
        fila = document.createElement('tr');
        hFila = document.createElement('th');
        hFila.setAttribute('scope', 'row');
        id = document.createElement('td');
        fecha = document.createElement('td');
        rut = document.createElement('td');
        nombre = document.createElement('td');
        email = document.createElement('td');
        botones = document.createElement('td');
        hFila.innerHTML = i + 1;
        id.innerHTML = cotizacion.id;
        fecha.innerHTML = cotizacion.fecha;
        rut.innerHTML = cotizacion.rut;
        nombre.innerHTML = cotizacion.nombre;
        email.innerHTML = cotizacion.email;
        botones.innerHTML = `<a href="javascript:renderResponderCotizacion(` + cotizacion.id + `)"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-file-earmark-richtext text-dark" viewBox="0 0 16 16">
            <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
            <path d="M4.5 12.5A.5.5 0 0 1 5 12h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zm0-2A.5.5 0 0 1 5 10h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zm1.639-3.708 1.33.886 1.854-1.855a.25.25 0 0 1 .289-.047l1.888.974V8.5a.5.5 0 0 1-.5.5H5a.5.5 0 0 1-.5-.5V8s1.54-1.274 1.639-1.208zM6.25 6a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5z"/>
            </svg><a/>
            <a href="#"><img src="imgs/borrar.png" alt="" style="height:30px; width: 30px;"><a/>`;
        fila.appendChild(hFila);
        fila.appendChild(id);
        fila.appendChild(fecha);
        fila.appendChild(rut);
        fila.appendChild(nombre);
        fila.appendChild(email);
        fila.appendChild(botones);
        tbody.appendChild(fila);
    }
    tbody.id = "cuerpoTablaMostrarCotizacion";
    actualizarElemento(tbody.id, tbody);
}

function crearTablaProdsCotizacion(listaCotizaciones) {
    let tbody = document.createElement('tbody');
    let fila;
    let hFila;
    let codigoProd;
    let nombre;
    let valorUnitario;
    let unidades;
    let total;
    let cotizacion;
    for (i = 0; i < listaCotizaciones.length; i++) {
        cotizacion = listaCotizaciones[i];
        fila = document.createElement('tr');
        hFila = document.createElement('th');
        hFila.setAttribute('scope', 'row');
        codigoProd = document.createElement('td');
        nombre = document.createElement('td');
        valorUnitario = document.createElement('td');
        unidades = document.createElement('td');
        total = document.createElement('td');
        hFila.innerHTML = i + 1;
        codigoProd.innerHTML = cotizacion.codigoProd;
        nombre.innerHTML = cotizacion.nombreProd;
        valorUnitario.innerHTML = `<input type='text' onchange='setTotal(` + i + `)' id='unitario` + i + `'>`;
        unidades.innerHTML = cotizacion.cantidadProd;
        valorUnitario.id = "valorUnitario" + i;
        unidades.id = "unidades" + i;
        total.id = "total" + i;
        fila.appendChild(hFila);
        fila.appendChild(codigoProd);
        fila.appendChild(nombre);
        fila.appendChild(valorUnitario);
        fila.appendChild(unidades);
        fila.appendChild(total);
        tbody.appendChild(fila);
    }
    tbody.id = "tBodyProdsCotizacion";
    actualizarElemento(tbody.id, tbody);
}

function setTotal(id) {
    console.log("Entramos a setTotal")
    let tBody = document.getElementById("tBodyProdsCotizacion");
    let valorUnitario = document.getElementById("unitario" + id).value;
    let unidades = document.getElementById("unidades" + id).innerHTML;
    let totalProd = document.getElementById("total" + id);
    let totalNeto = document.getElementById("valorNetoCotizacion");
    let ivaNetoCotizacion = document.getElementById("ivaNetoCotizacion");
    let total = document.getElementById("totalCotizacion");
    let valorTotalNeto = 0;
    let netoParcial;
    totalProd.innerHTML = valorUnitario * unidades;
    console.log(tBody.childElementCount);
    for (i = 0; i < tBody.childElementCount; i++) {
        netoParcial = parseInt(document.getElementById("total" + i).innerHTML);
        if (isNaN(netoParcial)) {
        
        } else {
            console.log(netoParcial);
            valorTotalNeto += netoParcial;
        }
    }
    console.log(valorTotalNeto);
    //totalNeto.value = valorTotalNeto;
    totalNeto.setAttribute("value", valorTotalNeto);
    //ivaNetoCotizacion.value = valorTotalNeto * 0.19;
    ivaNetoCotizacion.setAttribute("value", valorTotalNeto * 0.19);
    //total.value = parseInt(totalNeto.value) + parseInt(ivaNetoCotizacion.value);
    total.setAttribute("value", parseInt(totalNeto.value) + parseInt(ivaNetoCotizacion.value));
}

function renderResponderCotizacion(id) {
    mostrarPestañaResponderCotizacion();
    getCotizacion(id);
    getProdsCotizacion(id);
}

function mostrarPestañaResponderCotizacion() {
    let btnMostrarCotizacion = document.getElementById('btnAccordionMostrarCotizacion');
    let btnResponderCotizacion = document.getElementById('btnAccordionResponderCotizacion');
    let bodyMostrarCotizacion = document.getElementById('collapseMostrarCotizacion');
    let bodyResponderCotizacion = document.getElementById('collapseResponderCotizacion');
    btnMostrarCotizacion.classList.add('collapsed');
    btnMostrarCotizacion.setAttribute('aria-expanded', 'false');
    bodyMostrarCotizacion.classList.remove('show');
    btnResponderCotizacion.classList.remove('collapsed');
    btnResponderCotizacion.setAttribute('aria-expanded', 'true');
    bodyResponderCotizacion.classList.add('show');
}

function rellenarCotizacion(cotizacion) {
    let id = document.getElementById("numeroCotizacion");
    let fecha = document.getElementById("fechaCotizacion");
    let rut = document.getElementById("rutCotizacion");
    let nombre = document.getElementById("nombreCotizacion");
    let direccion = document.getElementById("direccionCotizacion");
    let comuna = document.getElementById("comunaCotizacion");
    let email = document.getElementById("emailCotizacion");
    let telefono = document.getElementById("telefonoCotizacion");
    //id.value = cotizacion.id;
    id.setAttribute('value', cotizacion.id);
    //fecha.value = cotizacion.fecha;
    fecha.setAttribute('value', cotizacion.fecha);
    //rut.value = cotizacion.rut;
    rut.setAttribute('value', cotizacion.rut);
    //nombre.value = cotizacion.nombre;
    nombre.setAttribute('value', cotizacion.nombre);
    //direccion.value = cotizacion.direccion;
    direccion.setAttribute('value', cotizacion.direccion);
    //comuna.value = cotizacion.comuna;
    comuna.setAttribute('value', cotizacion.comuna);
    //email.value = cotizacion.email;
    email.setAttribute('value', cotizacion.email);
    //telefono.value = cotizacion.telefono;
    telefono.setAttribute('value', cotizacion.telefono);
}

function createPaginationQuotes(listaQuotes){
    const paginationQuotes = document.createElement('ul');
    paginationQuotes.id = 'paginationQuotes';
    paginationQuotes.setAttribute('class', 'pagination justify-content-center');
    const qtyItemsPage = 10;
    let qtyPages = Math.ceil(listaQuotes.length/qtyItemsPage);
    console.log(qtyPages);
    let li = document.createElement('li');
    li.setAttribute('class', 'page-item');
    let a = document.createElement('a');
    a.setAttribute('class', 'page-link');
    a.setAttribute('href', 'javascript:chngPageQuote("<")');
    a.innerHTML = '<';
    li.appendChild(a);
    paginationQuotes.appendChild(li);
    for (let i = 0; i < qtyPages; i++) {
        let li = document.createElement('li');
        li.setAttribute('class', 'page-item');
        let a = document.createElement('a');
        a.setAttribute('class', 'page-link');
        a.setAttribute('href', 'javascript:passNumPageQuote('+(i+1)+');');
        a.innerHTML = i + 1;
        li.appendChild(a);
        paginationQuotes.appendChild(li);
    }
    li = document.createElement('li');
    li.setAttribute('class', 'page-item');
    a = document.createElement('a');
    a.setAttribute('class', 'page-link');
    a.setAttribute('href', 'javascript:chngPageQuote(">")');
    a.innerHTML = '>';
    li.appendChild(a);
    paginationQuotes.appendChild(li);
    actualizarElemento(paginationQuotes.id, paginationQuotes);
}

function passNumPageQuote(numPage){
    numPgQuotes = numPage;
    crearTablaCotizaciones(listaQuotes);
}

function chngPageQuote(change){
    if (change == '<'){
        if (numPgQuotes > 1){
            numPgQuotes--;
            crearTablaCotizaciones(listaQuotes);
        }
    }else{
        if (numPgQuotes < Math.ceil(listaQuotes.length/10)){
            numPgQuotes++;
            crearTablaCotizaciones(listaQuotes);
        }
    }
}