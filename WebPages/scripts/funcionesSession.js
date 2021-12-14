function VerificarSession(){
    console.log(sessionStorage.getItem("token"))
    if(sessionStorage.getItem("token") == null){
        console.log("entre al if");
        //window.location.href="login.html";
    }else{
        enviarToken();
    }
};

function enviarToken(){
    //let formData = new FormData();
    //formData.append("token", sessionStorage.getItem("token"));
    //formData.append("btnForm", "verificarUser");
    let config = {
        headers: {
           Authorization: "Bearer " + sessionStorage.getItem("token")
        }
     }
    axios.get('../php/Login.php?btnForm=verificarUser', config)
    .then(response => {
        console.log(response);
        if(response.data !== "Verificado"){
                        //window.location.href="login.html";
        }
    });
};

function CerrarSesion(){
    sessionStorage.clear();
    window.location.href="login.html";
};