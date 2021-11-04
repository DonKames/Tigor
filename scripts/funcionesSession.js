function VerificarSession(){
    console.log(sessionStorage.getItem("user"))
    if(sessionStorage.getItem("user") == null){
        console.log("entre al if");
        window.location.href="login.html";
    }
};

function CerrarSesion(){
    sessionStorage.clear();
    window.location.href="login.html";
}