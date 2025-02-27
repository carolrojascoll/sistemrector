const WEEK = [
  "DOMINGO",
  "LUNES",
  "MARTES",
  "MIERCOLES",
  "JUEVES",
  "VIERNES",
  "SÁBADO",
];

toastr.options = {
  closeButton: false,
  debug: false,
  newestOnTop: false,
  progressBar: false,
  positionClass: "toast-top-center",
  preventDuplicates: true,
  onclick: null,
  showDuration: "300",
  hideDuration: "1000",
  timeOut: "2000",
  extendedTimeOut: "1000",
  showEasing: "swing",
  hideEasing: "linear",
  showMethod: "fadeIn",
  hideMethod: "fadeOut",
};

// function updateTime() {
//   var now = new Date();

//   document.getElementById("time").innerText =
//     WEEK[now.getDay()] +
//     " " +
//     zeroPadding(now.getDate(), 2) +
//     " - " +
//     zeroPadding(now.getHours(), 2) +
//     ":" +
//     zeroPadding(now.getMinutes(), 2) +
//     ":" +
//     zeroPadding(now.getSeconds(), 2);
// }

// updateTime();
// setInterval(updateTime, 1000);

// function zeroPadding(num, digit) {
//   return String(num).padStart(digit, "0");
// }

$("#user_perfil").click(() => {
  op = "Mostrar";
  $("#modalPerfil").modal("show");
});

// Funcion que obtiene y muestra los datos del usuario logeado

function userLogeado() {
  $.ajax({
    url: "../servicios/user_logeado.php",
    method: "POST",
    data: { usuario: localStorage.user },
    dataType: "json",
    success: function (json) {
      if (json.logeado == true) {
        $("#p_nombre").text(json.nombre);
        $("#p_ci").text(json.ci);
        $("#p_rol").text(json.rol);
        $("#p_dependencia").text(json.dependencia);
        $("#p_ciudad").text(json.ciudad);
        $("#p_direccion").text(json.direccion);
        $("#p_telefono").text(json.telefono);
        $("#p_usuario").text(localStorage.user);
        $("#p_userPerfil").attr("src", "../img/usuarios/" + json.foto);
        $("#user_img").attr("src", "../img/usuarios/" + json.foto);
        localStorage.id_funcionario = json.id_funcionario;
        localStorage.dependencia = json.dependencia;
        localStorage.rol = json.rol;
      }
    },
  });
}

userLogeado();

// =============== Funcionalidad de Modal Editar Datos || Foto ================ \\

let op = "";

$("#btn_sesion").click(() => {
  location.href = "../index.html";
});

$("#div_datos").hide();
$("#div_password").hide();
$("#div_foto").hide();

function vistaPrevia(foto) {
  // Funcion que verifica y valida el formato de la imagen seleccionada

  var extension = $("#foto").val().split(".").pop().toLowerCase();

  if (jQuery.inArray(extension, ["png", "jpg", "jpeg"]) == -1) {
    errorMessage(
      "Formato no admitido. Seleccione una imagen con los siguientes formatos: gif, png, jpg, jpeg."
    );
  } else {
    if (foto.files && foto.files[0]) {
      //Revisamos que el input tenga contenido
      var reader = new FileReader(); //Leemos el contenido

      reader.onload = function (e) {
        //Al cargar el contenido lo pasamos como atributo de la imagen de arriba
        
        $("#span_vista").html(
          '<img class="img-thumbnail" id="vista_previa" src="">'
        );
        $("#vista_previa").attr("src", e.target.result);
        $("#vista_previa").css("width", "240px");
        $("#vista_previa").css("height", "240px");
        perfil = "si";
        $("#perfil").val(perfil);
        imagen = "si";
        console.log(perfil);
      };

      reader.readAsDataURL(foto.files[0]);
    }
  }
}

$("#foto").change(function () {
  //Cuando el input cambie (se cargue un nuevo archivo) se va a ejecutar de nuevo el cambio de imagen y se verá reflejado.
  vistaPrevia(this);
});

function cargarComboCiudades() {
  let combo_ciudades = $("#f_ciudad");
  if (combo_ciudades.children().length > 0) {
    combo_ciudades.empty();
  }
  $.ajax({
    type: "POST",
    url: "../servicios/ciudades/cargar_ciudades.php",
    dataType: "json",
    success: function (json) {
      $.each(json, function (i, obj) {
        $("#f_ciudad").append(
          $("<option>").text(obj.ciudad).attr("value", obj.id_ciudad)
        );
      });
    },
  });
}

/* Funcion que se encarga de mostrar los diversos formularios dentro del modal*/

function menuOperaciones(operacion) {
  switch (operacion) {
    case "Datos":
      $("#div_datos").show();
      $("#div_foto").hide();
      $("#div_password").hide();
      break;
    case "Foto":
      $("#div_foto").show();
      $("#div_datos").hide();
      $("#div_password").hide();
      break;
    case "Password":
      $("#div_password").show();
      $("#div_foto").hide();
      $("#div_datos").hide();
      break;
    default:
      $("#div_password").hide();
      $("#div_foto").hide();
      $("#div_datos").hide();
  }
}

$("#btn_datos").click(function () {
  op = "Datos";
  $("#modalPerfil").modal("hide");
  $("#modalEditar").modal("show");
  $("#title_editar").text("Modificar Datos");
  menuOperaciones(op);
  cargarComboCiudades();
  $.ajax({
    url: "../servicios/funcionarios/obtener_funcionario.php",
    method: "POST",
    data: { id_funcionario: localStorage.id_funcionario },
    dataType: "json",
    success: function (json) {
      if (json.encontrado == true) {
        $("#ci_num").val(json.ci);
        $("#f_nombre").val(json.nombre);
        $("#f_apellido").val(json.apellido);
        $("#f_ciudad").val(json.id_ciudad);
        $("#f_direccion").val(json.direccion);
        $("#f_telefono").val(json.telefono);
      }
    },
  });
});

$("#btn_password").click(function () {
  op = "Password";
  $("#modalPerfil").modal("hide");
  $("#modalEditar").modal("show");
  $("#title_editar").text("Modificar Contraseña");
  menuOperaciones(op);
});

$("#btn_foto").click(function () {
  op = "Foto";
  $("#modalPerfil").modal("hide");
  $("#modalEditar").modal("show");
  $("#title_editar").text("Modificar Foto de Perfil");
  menuOperaciones(op);
  $("#user").val(localStorage.user);
  $("#foto").val("");
});

function editar_datos() {
  let ciNum = $("#ci_num").val();
  let nom = $("#f_nombre").val();
  let ape = $("#f_apellido").val();
  let id_ciu = $("#f_ciudad").val();
  let dir = $("#f_direccion").val();
  let tel = $("#f_telefono").val();
  if (ciNum.length == 0) {
    toastr.warning("El ci no debe quedar vacio.");
    $("#ci_num").focus();
  } else if (nom.length == 0) {
    toastr.warning("El nombre no debe quedar vacio.");
    $("#f_nombre").focus();
  } else if (ape.length == 0) {
    toastr.warning("El apellido no debe quedar vacio.");
    $("#ci_num").focus();
  } else if (id_ciu.length == 0) {
    toastr.warning("Seleccione una ciudad.");
  } else if (dir.length == 0) {
    toastr.warning("La dirección no debe quedar vacio.");
    $("#f_dir").focus();
  } else if (tel.length == 0) {
    toastr.warning("El telefono no debe quedar vacio.");
    $("#f_telefono").focus();
  } else {
    $.ajax({
      url: "../servicios/menu/editar_datos.php",
      method: "POST",
      data: {
        ci: ciNum,
        nombre: nom,
        apellido: ape,
        id_ciudad: id_ciu,
        direccion: dir,
        telefono: tel,
        id_funcionario: localStorage.id_funcionario,
      },
      dataType: "json",
      success: function (json) {
        if (json.modificado == true) {
          successMessage(json.mensaje);
          userLogeado();
          $("#modalEditar").modal("hide");
          $("#modalPerfil").modal("show");
        } else {
          warningMessage(json.mensaje);
        }
      },
    });
  }
}

// Variable para validar que la contraseña ingresada es valida
let pass_valido = "";
siguienteCtrl($("#anterior"), $("#bef"));
siguienteCtrl($("#nueva"), $("#new"));
siguienteCtrl($("#confirmar"), $("#conf"));

function validarContrasenha() {
  let password = $("#nueva").val();
  if (password.length > 0) {
    if (validar_contrasenha(password) == false) {
      $("#error_nuevo").text(
        "La contraseña debe contener al menos 2 letras mayúsculas y minúsculas, 2 números y 2 caracteres especiales"
      );
      $("#error_nuevo").css("color", "#e63946");
      console.log("no valido");
      pass_valido = "no";
    } else {
      $("#error_nuevo").text("");
      pass_valido = "si";
      console.log("valido");
    }
  } else {
    $("#error_nuevo").text("");
    pass_valido = "no";
  }
}

function modificar_password() {
  let usuario = localStorage.user;
  let anterior = $("#anterior").val().trim();
  let nueva = $("#nueva").val().trim();
  let confirmar = $("#confirmar").val().trim();
  if (nueva != confirmar) {
    toastr.warning("Las contraseñas no coinciden.!!!");
  } else if (pass_valido == "si") {
    $.ajax({
      url: "../servicios/menu/modificar_contrasenha.php",
      method: "POST",
      data: {
        usuario: usuario,
        nueva: nueva,
        anterior: anterior,
      },
      dataType: "json",
      success: function (json) {
        if (json.modificado == true) {
          $("#error_anterior").text("");
          Swal.fire({
            title: "¡¡¡MENSAJE!!!",
            text: json.mensaje,
            icon: "success",
            timer: 10000,
            showConfirmButton: true,
            confirmButtonText: "Ok",
          }).then((result) => {
            if (result.isConfirmed) {
              location.href = "../index.html";
            }
          });
        } else if (json.coincide == false) {
          $("#error_anterior").css("color", "#e63946");
          $("#error_anterior").text(json.mensaje);
        } else {
          warningMessage(json.mensaje);
        }
      },
    });
  }
}

function modificar_perfil() {
  var data = new FormData($("#form_perfil")[0]);
  if($("#foto").val() === "") {
    toastr.warning("Seleccione una imagen.");
    $("#foto").click(); 
  } else {
    $.ajax({
      url: '../servicios/menu/modificar_perfil.php',
      method: 'POST',
      data: data,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function(json) {
        if(json.modificado === true) {
          successMessage(json.mensaje);
          userLogeado();
          $("#modalEditar").modal("hide");
          $("#modalPerfil").modal("show");
        } else {
          warningMessage(json.mensaje);
        }
      }
    })
  }
}

$("#btn_confirmar").click(function () {
  switch (op) {
    case "Datos":
      editar_datos();
      break;
    case "Foto":
      modificar_perfil();
      break;
    case "Password":
      modificar_password();
      break;
  }
});

$("#btn_cancelar").click(function () {
  switch (op) {
    case "Datos":
      $("#modalEditar").modal("hide");
      $("#modalPerfil").modal("show");
      $("#form_datos")[0].reset();
      break;
    case "Foto":
      $("#modalEditar").modal("hide");
      $("#modalPerfil").modal("show");
      $("#form_perfil")[0].reset();
      $("#span_vista").html("");
      break;
    case "Password":
      $("#modalEditar").modal("hide");
      $("#modalPerfil").modal("show");
      $("#form_contrasena")[0].reset();
      break;
  }
});
