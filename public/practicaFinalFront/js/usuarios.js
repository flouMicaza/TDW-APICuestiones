/**
 * Método que carga los usuarios y muestra los que están inactivos. 
 */
function cargar_usuarios(){
    var cuestion_actual = JSON.parse(
        window.localStorage.getItem("cuestion_actual")
      );
      var aprendiz = JSON.parse(window.localStorage.getItem("usuarioRegistrado"));
    
      $("#nombre-usuario").text("Nombre usuario: " + aprendiz.username);
        
    $.ajax({
        url: "http://localhost:8000/api/v1/users",
        type: "GET",
        headers: { Authorization: "Bearer " + localStorage.getItem("token") },
        success: function(data, textStatus) {
          console.log(data,"usuarios");
          mostrar_usuarios(data.usuarios);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log(errorThrown);
        },
        dataType: "json"
      });
}
function activar_usuario(id_user){
    var checked = $("#usuario_" + id_user).find("#activar_usuario").is(':checked');
    console.log(checked,"checked")
    $.ajax({
        url: "/api/v1/users/" + id_user,
        type: "PUT",
        data: {
          enabled : checked ? 1 : 0
        },
        // Fetch the stored token from localStorage and set in the header
        headers: { Authorization: "Bearer " + localStorage.getItem("token") },
        success: function(data, textStatus) {
          console.log("activado!")
    
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          
        }
      });
}

/**
 * Método que crea los elmentos para ver los usuarios
 * @param  lista_usuarios 
 */
function mostrar_usuarios(lista_usuarios){
    for(let usuario of lista_usuarios){
        $("#usuarios").append($("#usuario_init").clone());
        $("#usuarios").children().last().attr("id","usuario_" + usuario.usuario.id);
        $("#usuario_" + usuario.usuario.id).find("#nombre").text(usuario.usuario.username);
        $("#usuario_" + usuario.usuario.id).find("#email").text(usuario.usuario.email);
        $("#usuario_" + usuario.usuario.id).find("#activar_usuario").change(()=>activar_usuario(usuario.usuario.id));
        $("#usuario_" + usuario.usuario.id).find("#activar_usuario").attr('checked',usuario.usuario.enabled);
        $("#usuario_" + usuario.usuario.id).find("#maestro_usuario").change(()=>maestro_usuario(usuario.usuario.id));
        $("#usuario_" + usuario.usuario.id).find("#maestro_usuario").attr('checked',usuario.usuario.maestro);
        
    }
    $("#usuario_init").remove();
}
function maestro_usuario(id_user){
    var checked = $("#usuario_" + id_user).find("#maestro_usuario").is(':checked');

    $.ajax({
        url: "/api/v1/users/" + id_user,
        type: "PUT",
        data: {
          isMaestro : checked ? 1 : 0,
          isAdmin : checked ? 1:0
        },
        // Fetch the stored token from localStorage and set in the header
        headers: { Authorization: "Bearer " + localStorage.getItem("token") },
        
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          
        }
      });
}