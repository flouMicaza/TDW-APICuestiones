//Hacer un get a la api y traer todas las cuesiones del usuario.
function get_cuestiones() {
  var usuarioActual = JSON.parse(
    window.localStorage.getItem("usuarioRegistrado")
  );
  $("#nombre-usuario").text("Nombre usuario: " + usuarioActual.username);
    
  $(document).ready(function() {
    $.ajax({
      url: "/api/v1/questions",
      type: "GET",
      // Fetch the stored token from localStorage and set in the header
      headers: { Authorization: "Bearer " + localStorage.getItem("token") },
      success: function(data, textStatus) {
        cargar_cuestiones(data.cuestiones);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        if (errorThrown == "Not Found") {
          noHayCuestiones();
        }
      }
    });
  });
}

function noHayCuestiones() {
  var usuarioActual = JSON.parse(
    window.localStorage.getItem("usuarioRegistrado")
  );
  var tipoUsuario = usuarioActual.isMaestro ? "maestro" : "aprendiz";
  if (tipoUsuario == "aprendiz") {
    $("#agregar_cuestion").remove();
    
    $("#menu_usuarios").remove();
  }
  $("#cuestiones").html(
    "<div class='card'><div class='card-body'><p class='card-text'>No hay cuestiones disponibles</p></div></div>"
  );
}

function cargar_cuestiones(cuestiones) {
  var usuarioActual = JSON.parse(
    window.localStorage.getItem("usuarioRegistrado")
  );
  var tipoUsuario = usuarioActual.isMaestro ? "maestro" : "aprendiz";

  var main_cuestiones = document.getElementById("cuestiones");

  //crear la lista de cuestiones
  for (let cuestion of cuestiones) {
    if((tipoUsuario=="aprendiz" && cuestion.cuestion.enunciadoDisponible)|| tipoUsuario=="maestro"){
      var nueva_cuestion = crear_cuestion(cuestion.cuestion, tipoUsuario);
      main_cuestiones.appendChild(nueva_cuestion);
    }
    
  }

  //si es alumno elimino del dom el elemento para agregar cuestiones
  if (tipoUsuario == "aprendiz") {
    $("#agregar_cuestion").remove(); 

    $("#menu_usuarios").remove();
    if($("#cuestiones").children().length==0){

      noHayCuestiones();
    }
  }
}

function crear_link_cuestion(cuestion, tipo) {
  var link;
  if (tipo == "maestro") {
    link = "pagina_cuestion_profesor.html";
  } else {
    link = "pagina_cuestion_alumno.html";
  }
  var link_cuestion = document.createElement("a");
  link_cuestion.id = "link_clave" + cuestion.idCuestion;
  link_cuestion.href = link;
  var mensaje = document.createTextNode(cuestion.enunciadoDescripcion);
  link_cuestion.appendChild(mensaje);
  link_cuestion.onclick = () => {
    window.localStorage.setItem("cuestion_actual", JSON.stringify(cuestion));
  };

  return link_cuestion;
}

function crear_boton_eliminar(cuestion) {
  var span_eliminar = document.createElement("span");
  span_eliminar.className = "delete-btn";
  var boton_eliminar = document.createElement("button");
  boton_eliminar.id = "eliminar_" + cuestion.idCuestion;
  boton_eliminar.className = "btn btn-danger";
  boton_eliminar.onclick = eliminar_cuestion;
  var mensaje_boton = document.createTextNode("Eliminar");
  boton_eliminar.appendChild(mensaje_boton);
  span_eliminar.appendChild(boton_eliminar);

  return span_eliminar;
}

function crear_cuestion(cuestion, tipo) {
  var card_div = document.createElement("div");
  card_div.className = "card";

  var card_body = document.createElement("div");
  card_body.className = "card-body";
  card_body.id = "card-body" + cuestion.idCuestion;
  let link_cuestion = crear_link_cuestion(cuestion, tipo);
  card_body.appendChild(link_cuestion);

  //esto es solo si es un maestro.
  if (tipo == "maestro") {
    var span_cantidad;
    crear_span_cantidad(cuestion);

    var span_eliminar = crear_boton_eliminar(cuestion);
    card_body.appendChild(span_eliminar);

  }

  card_div.appendChild(card_body);

  return card_div;
}

function crear_span_cantidad(cuestion){
  $.ajax({
    url: "/api/v1/propuestasolucion/cantidad/" + cuestion.idCuestion,
    type: "GET",
    // Fetch the stored token from localStorage and set in the header
    headers: {
      Authorization: "Bearer " + localStorage.getItem("token")
    },
    success: function(data, textStatus) {
      var span_cantidad = document.createElement("span");
      span_cantidad.innerHTML = '<span class="badge badge-pill badge-primary delete-btn">' + data + '</span>';
      $("#card-body" + cuestion.idCuestion).append(span_cantidad);
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      alert("Fail eliminacion!", errorThrown);
    },
    dataType: "json"
  });
}
//eliminar_cuestion: funcion que eliminar una cuestion completa del localStorage.
//Se edita el json y se vuelve a setear.
function eliminar_cuestion() {
  var id_cuestion = this.id.split("_")[1];

  $.ajax({
    url: "/api/v1/questions/" + id_cuestion,
    type: "DELETE",
    // Fetch the stored token from localStorage and set in the header
    headers: {
      Authorization: "Bearer " + localStorage.getItem("token")
    },
    success: function(data, textStatus) {
      alert("elimino", textStatus);

      location.href = "inicio.html";
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      alert("Fail eliminacion!", errorThrown);
    },
    dataType: "json"
  });
}

function agregar_cuestion() {
  var nombre = $("#id_nueva_cuestion").val();
  //agregar la cuestion a la base de datos
  var usuarioActual = JSON.parse(
    window.localStorage.getItem("usuarioRegistrado")
  );
  var data = {
    enunciadoDescripcion: nombre,
    enunciadoDisponible: true,
    creador: usuarioActual.user_id,
    estado: "abierta"
  };
  $.ajax({
    url: "/api/v1/questions",
    type: "POST",
    // Fetch the stored token from localStorage and set in the header
    headers: {
      Authorization: "Bearer " + localStorage.getItem("token")
    },
    data: data,
    success: function(data, textStatus) {
      window.localStorage.setItem(
        "cuestion_actual",
        JSON.stringify(data.cuestion)
      );
      location.href = "pagina_cuestion_profesor.html";
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      alert("Fail!", errorThrown);
    },
    dataType: "json"
  });
}
