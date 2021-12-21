function eliminarElemento(idElemento) {
    console.log("Entramos a eliminarElemento()")
    let elemento = document.getElementById(idElemento);
    let padre = elemento.parentNode;
    padre.removeChild(elemento);
}

function resetCliente(reset) {
    let btnResetCliente = document.getElementById(`btnReset` + reset);
    let btnAgregarCliente = document.getElementById(`btnAgregar` + reset);
    let btnModificarCliente = document.getElementById(`btnModificar` + reset);
    btnResetCliente.hidden = true;
    btnAgregarCliente.hidden = false;
    btnModificarCliente.hidden = true;
}

function actualizarElemento(idTabla, newTabla) {
    console.log("entre a actualizarElemento() " + idTabla);
    let oldTabla = document.getElementById(idTabla);
    oldTabla.parentNode.replaceChild(newTabla, oldTabla);
}

function changeToProducts(filtro){
    localStorage.setItem("filtro", filtro);
    window.location.href = "productos.html";
}

function confirmarEliminar(tipo, id) {
    console.log("Entre a confirmarEliminarCliente()");
    let pregunta = "Seguro desea eliminar al " + tipo + ": " + id + " ?";
    let resp = confirm(pregunta);
    switch (tipo) {
        case "Cliente":
            if (resp) {
                location.href = "php/CrudCliente.php/?btnForm=eliminarCliente&idCliente=" + id;
            }
            break;
        case "Proveedor":
            if (resp) {
                location.href = "php/CrudProveedor.php/?btnForm=eliminarProveedor&idProveedor=" + id;
            }
            break;
        case "Categoria":
            if (resp) {
                location.href = "php/CrudCategoria.php/?btnForm=eliminarCategoria&idCategoria=" + id;
            }
            break;
        case "Product":
            if (resp) {
                location.href = "php/CrudProduct.php/?btnForm=eliminarCategoria&idProduct=" + id;
            }
            break;

    }
}

function intercambiarBotonAgregar(tipo, modificar) {
    let btnReset = document.getElementById("btnReset" + tipo);
    let btnAgregar = document.getElementById("btnAgregar" + tipo);
    let btnModificar = document.getElementById("btnModificar" + tipo);
    let btnAccordionAgregar = document.getElementById("btnAccordionAgregar" + tipo);
    let btnAccordionMostrar = document.getElementById("btnAccordionMostrar" + tipo + "s");
    let collapseAgregar = document.getElementById("collapseAgregar" + tipo);
    let collapseMostrar = document.getElementById("collapseMostrar" + tipo + "s");
    let floatNombre = document.getElementById("floatNombre" + tipo);
    btnReset.hidden = false;
    btnAgregar.hidden = true;
    btnModificar.hidden = false;
    btnAccordionMostrar.setAttribute("aria-expanded", "false");
    btnAccordionMostrar.className = "accordion-button collapsed";
    collapseMostrar.className = "accordion-collapse collapse";
    btnAccordionAgregar.setAttribute("aria-expanded", "true");
    btnAccordionAgregar.className = "accordion-button";
    collapseAgregar.className = "accordion-collapse collapse show";
    switch (tipo) {

        case "Cliente":

        case "Proveedor":
            console.log("Entro IntercambiarBotonCliente")
            let floatRut = document.getElementById("floatRut" + tipo);
            let floatDireccion = document.getElementById("floatDireccion" + tipo);
            let floatSelectComuna = document.getElementById("floatSelectComuna" + tipo);
            let floatEmail = document.getElementById("floatEmail" + tipo);
            let floatTelefono = document.getElementById("floatTelefono" + tipo);
            floatRut.value = modificar.rut;
            floatNombre.value = modificar.nombre;
            floatDireccion.value = modificar.direccion;
            floatSelectComuna.value = modificar.comuna;
            floatEmail.value = modificar.email;
            floatTelefono.value = modificar.telefono;
            break;
        case "Categoria":
            let floatId = document.getElementById("floatId" + tipo);
            floatNombre.value = modificar.nombre;
            floatId.value = modificar.id;
            break;
        case "Product":
            let floatNombreProduct = document.getElementById("floatNombre" + tipo);
            let floatCodigoProduct = document.getElementById("floatCodigo" + tipo);
            let floatSelectCategoriaProduct = document.getElementById("floatSelectCategoria" + tipo);
            let floatDescripcionProduct = document.getElementById("floatDescripcion" + tipo);
            floatNombreProduct.value = modificar.nombre;
            floatCodigoProduct.value = modificar.codigo;
            floatSelectCategoriaProduct.value = modificar.categoria;
            floatDescripcionProduct.value = modificar.descripcion;
            break;
    }
}