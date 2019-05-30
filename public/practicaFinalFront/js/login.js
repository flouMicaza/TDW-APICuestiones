function irRegistrarUsuario(){
  location.href = "registro.html";
}
function registrarUsuario(){
  var nombre = $("#user").val();
  var contrasena = $("#contrasena").val();
  var email = $("#email").val();
  
  if(nombre=="" || contrasena=="" || email==""){
    $("#registro").append("<small class='text-danger'>Todos los campos son obligatorios</small>")
  }else{
    $.ajax({
      url: "http://localhost:8000/api/v1/users/add",
      type: "POST",
      data: {
        username: nombre,
        email : email,
        password: contrasena,
        enabled: 0
      },
      success: function(data, textStatus) {
        location.href = "login.html";
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        if(errorThrown=="Bad Request"){
          $("#registro").append("<small class='text-danger'>El usuario ingresado ya existe</small>")
        }
      },
      dataType: "json"
    });
  }
}
function inicioLogin() {
  $("#botonLogin").click(function() {
    var nombre = $("#user").val();
    var contrasena = $("#contrasena").val();
   
    $.ajax({
      url: "http://localhost:8000/api/v1/login",
      type: "POST",
      data: {
        _username: nombre,
        _password: contrasena
      },
      success: function(data, textStatus) {
        var token = data["token"];
        localStorage.setItem("token", token);
        tokenInfo = parseJwt(localStorage.getItem("token"));
        console.log(tokenInfo);
        if(tokenInfo.enabled){
          
        localStorage.setItem("usuarioRegistrado", JSON.stringify(tokenInfo));
        location.href = "inicio.html";
        }else{
          location.href = "inicioDesactivado.html";
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        //errorThrown tira el error que devuelve la api
        //alert("fail " + errorThrown, +"gola");
        var mi_div = document.createElement("div");
        mi_div.innerHTML =
          "<small class='text-danger'>Credenciales incorrectas</small>";
        var form = document.getElementById("loginForm");
        form.insertBefore(mi_div, form.childNodes[5]);
      },
      dataType: "json"
    });
  });
}

function parseJwt(token) {
  var base64Url = token.split(".")[1];
  var base64 = decodeURIComponent(
    atob(base64Url)
      .split("")
      .map(function(c) {
        return "%" + ("00" + c.charCodeAt(0).toString(16)).slice(-2);
      })
      .join("")
  );

  return JSON.parse(base64);
}
