function validarBusqueda(){
    var palabrasClave, localizacion, orden, estado1, estado2, estado3, estado4, estado5;

    palabrasClave=document.getElementById("palabrasClave").value;
    localizacion=document.getElementById("localizacion").value;
    orden=document.getElementById("orden").value;
    estado1=document.getElementById("estado1").value;
    estado2=document.getElementById("estado2").value;
    estado3=document.getElementById("estado3").value;
    estado4=document.getElementById("estado4").value;
    estado5=document.getElementById("estado5").value;

    if(palabrasClave.length>20 || localizacion.length>20){
        alert("Introduzca un valor más pequeño");
        return false;
    }
    else if(orden!=0 && orden!=1 && orden!=2){
        alert("Orden no permitido");
        return false;
    }
    else if(estado1!=0 && estado1!=1){
        alert("Estado1 no permitido");
        return false;
    }
    else if(estado2!=0 && estado2!=1){
        alert("Estado2 no permitido");
        return false;
    }
    else if(estado3!=0 && estado3!=1){
        alert("Estado3 no permitido");
        return false;
    }
    else if(estado4!=0 && estado4!=1){
        alert("Estado4 no permitido");
        return false;
    }
    else if(estado5!=0 && estado5!=1){
        alert("Estado5 no permitido");
        return false;
    }
}

function validarRegistro(){
    var nombre, apellidos, email, direccion, telefono, rol, contrasena, contrasena2, dni;

    nombre=document.getElementById("nombre").value;
    apellidos=document.getElementById("apellidos").value;
    email=document.getElementById("email").value;
    direccion=document.getElementById("direccion").value;
    telefono=document.getElementById("telefono").value;
    rol=document.getElementById("rol").value;
    contrasena=document.getElementById("contrasena").value;
    contrasena2=document.getElementById("contrasena2").value;
    dni=document.getElementById("dni").value;

    var regexNombre = "^[a-zA-Z-ñÑçÇ-0-9-_\.]{1,20}$";
    var regexApellidos = "[A-Za-z- -áéíóú]{1,32}";
    var regexContrasena = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$";
    var regexDNI = "[A-Za-z0-9]{1,15}";



    if(nombre == "" || apellidos === "" || email === "" || direccion ==="" || telefono ===""|| rol ===""|| contrasena ==="" || contrasena2 ==="" || dni ===""){
        alert("Todos los campos son requeridos");
        return false;
    }

    if(nombre.length>20){
        alert("El nombre es demasiado largo");
        return false;
    }
    else if(!nombre.test(regexNombre)){
        alert("El nombre no es válido");
        return false;
    }
    else if(apellidos.length>40){
        alert("Los apellidos son demasiado largos");
        return false;
    }
    else if(!apellidos.test(regexApellidos)){
        alert("Los apellidos no son válidos");
        return false;
    }
    else if(email.length>30){
        alert("El email es demasiado largo");
        return false;
    }
    else if(direccion.length>30){
        alert("La direccion es demasiado larga");
        return false;
    }
    else if(telefono.length>30){
        alert("El telefono es demasiado largo");
        return false;
    }
    else if(isNaN(telefono)){
        alert("El telefono introducido no es válido");
        return false;
    }
    else if(rol>3 || rol<0){
        alert("El rol no es correcto");
        return false;
    }
    else if(contrasena.length>20){
        alert("La contraseña es demasiada largo");
        return false;
    }
    else if(contrasena2.length>20){
        alert("La contraseña es demasiada largo");
        return false;
    }
    else if(contrasena != contrasena2){
        alert("La contraseñas no coinciden");
        return false;
    }
    else if(!contrasena.test(regexContrasena)){
        alert("La contraseña no es válida");
        return false;
    }
    else if(dni.length != 9){
        alert("El DNI no es válido");
        return false;
    }
    else if(!dni.test(regexDNI)){
        alert("El DNI no es correcto");
        return false;
    }
}

function validarLogin(){
    var email, contrasena;

    email=document.getElementById("email").value;
    contrasena=document.getElementById("contrasena").value;

    var regexContrasena = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$";

    if(email === "" || contrasena ===""){
        alert("Todos los campos son requeridos");
        return false;
    }
    if(email.length>30){
        alert("El email es demasiado largo");
        return false;
    }
    else if(contrasena.length>20){
        alert("La contrasena es demasiado larga");
        return false;
    }
    else if(!contrasena.test(regexContrasena)){
        alert("La contrasena no es válida");
        return false;
    }
}

function validarEditar(){
    var nombre, apellidos, email, direccion;

    nombre=document.getElementById("nombre").value;
    apellidos=document.getElementById("apellidos").value;
    email=document.getElementById("email").value;
    direccion=document.getElementById("direccion").value;

    var regexNombre = "^[a-zA-Z-ñÑçÇ-0-9-_\.]{1,20}$";
    var regexApellidos = "[A-Za-z- -áéíóú]{1,32}";

    if(nombre.length>20){
        alert("El nombre es demasiado largo");
        return false;
    }
    else if(!nombre.test(regexNombre)){
        alert("El nombre no es válido");
        return false;
    }
    else if(apellidos.length>40){
        alert("Los apellidos son demasiado largos");
        return false;
    }
    else if(!apellidos.test(regexApellidos)){
        alert("Los apellidos no son válidos");
        return false;
    }
    else if(email.length>30){
        alert("El email es demasiado largo");
        return false;
    }
    else if(direccion.length>30){
        alert("La direccion es demasiado larga");
        return false;
    }
}

function validarPassword(){
    var antigua, nueva, nueva2;

    antigua=document.getElementById("antigua").value;
    nueva=document.getElementById("nueva").value;
    nueva2=document.getElementById("nueva2").value;

    var regexContrasena = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$";

    if(antigua.length>20){
        alert("La contraseña antigua no es válida");
        return false;
    }
    else if(!contrasena.test(regexContrasena)){
        alert("La contaseña no es válida");
        return false;
    }
    else if(nueva.length>20){
        alert("La contaseña es demasiado larga");
        return false;
    }
    else if(!nueva.test(regexContrasena)){
        alert("La contaseña no es válida");
        return false;
    }
    else if(nueva2.length>20){
        alert("La contaseña es demasiado larga");
        return false;
    }
    else if(!nueva2.test(regexContrasena)){
        alert("La contaseña no es válida");
        return false;
    }
    else if(nueva != nueva2){
        alert("Las contraseñas no coinciden");
        return false;
    }
}

function validarIncidencia(){
    var titulo, localizacion, palabrasClave, descripcion;

    titulo=document.getElementById("titulo").value;
    localizacion=document.getElementById("localizacion").value;
    palabrasClave=document.getElementById("palabrasClave").value;
    descripcion=document.getElementById("descripcion").value;

    if(titulo === "" || localizacion === "" || palabrasClave ==="" || descripcion === "" ){
        alert("Todos los campos son requeridos");
        return false;
    }
    if(titulo.length>20){
        alert("El título no es válido");
        return false;
    }
    else if(palabrasClave.length>50){
        alert("Las palabras clave no son válidas");
        return false;
    }
    else if(localizacion.length>255){
        alert("La localizacion es demasiado larga");
        return false;
    }
    else if(descripcion.length>500){
        alert("La descripción es demasiado larga");
        return false;
    }

}
