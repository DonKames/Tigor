function getComunas(){
    axios.get('php/CrudComunas.php').then((response) => {
        console.log(response.data);
        derivarComunas(response.data);
    });
}

function derivarComunas(comunas){
    let datalistComunas = document.getElementById('datalistComunasCliente');
    let optionComuna;
    for(let i = 0; i < comunas.length; i++){
        optionComuna = document.createElement('option');
        optionComuna.value = comunas[i].nombre;
        datalistComunas.appendChild(optionComuna);
    }
}