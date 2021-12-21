function Login(){
    let formData = new FormData();
    let user = document.getElementById("userLogin").value;
    let pass = document.getElementById("passLogin").value;
    formData.append("userLogin", user);
    formData.append("passLogin", pass);
    formData.append("btnForm", "leerUsuario")
    let config;
    axios.post('php/Login.php', formData)
        .then(response => {
            console.log(response.data.status);
            if(response.data.status === "Validado"){
                console.log(sessionStorage);
                sessionStorage.setItem("token", response.data.token);
                //let xhr = new XMLHttpRequest();
                //xhr.open("GET", "../php/administrar.php");
                config = {'Authorizations': 'bearer ' + response};
                location.href = "administrar.php"
            }else{
                console.log(response);
                console.log(sessionStorage.getItem("id"));
                alert("Error en el Usuario o Contraseña");
            }
    }).catch(e => {
        console.log(e);
    });
}