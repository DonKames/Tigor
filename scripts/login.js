function Login(){
    let formData = new FormData();
    let user = document.getElementById("userLogin").value;
    let pass = document.getElementById("passLogin").value;
    formData.append("userLogin", user);
    formData.append("passLogin", pass);
    formData.append("btnForm", "leerUsuario")
    axios.post('../php/Login.php', formData)
        .then(response => {
            if(response.data[0] === "Validado"){
                console.log(response);
                console.log(sessionStorage);
                sessionStorage.setItem("user", user);
                location.href = "administrar.html"
            }else{
                console.log(response);
                console.log(sessionStorage.getItem("id"));
                alert("Error en el Usuario o Contraseña");
            }
    }).catch(e => {
        console.log(e);
    });
}