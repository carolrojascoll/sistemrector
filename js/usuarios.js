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

let operacion = "";
let usuario_valido = "";
let password_valido = "no";
let id_usuario = 0;
// Variable para almacenar el id del funcionario
let id_funcionario = 0;
// Variable para controlar si el usuario quiere o no una foto de perfil
let perfil = "si";
// Variable para controlar si el usuario ha seleccionado o no una imagen
let imagen = "no";

$("#btn_nuevo").click(() => {
  $("#modalUsuarios").modal("show");
  $(".modal-title").text("Nuevo Usuarios");
  $("#form_usuarios")[0].reset();
  operacion = "Nuevo";
  $("#ci").prop("disabled", false);
  $("#btn_buscar").prop("disabled", false);
});

$("#btn_salir").click(() => {
  location.href = "menu.php";
});

siguienteClick($("#ci"), $("#btn_buscar"));

// function vistaPrevia(input) {
//   var extension = $("#foto").val().split(".").pop().toLowerCase();

//   if (jQuery.inArray(extension, ["png", "jpg", "jpeg"]) == -1) {
//     errorMessage(
//       "Formato no admitido. Seleccione una imagen con los siguientes formatos: gif, png, jpg, jpeg."
//     );
//   } else {
//     if (input.files && input.files[0]) {
//       //Revisamos que el input tenga contenido
//       var reader = new FileReader(); //Leemos el contenido

//       reader.onload = function (e) {
//         //Al cargar el contenido lo pasamos como atributo de la imagen de arriba
//         $("#span_vista").html(
//           '<img class="rounded-5" id="vista_previa" src="">'
//         );
//         $("#vista_previa").attr("src", e.target.result);
//         $("#vista_previa").css("width", "240px");
//         $("#vista_previa").css("height", "240px");
//         perfil = "si";
//         $("#perfil").val(perfil);
//         imagen = "si";
//         console.log(perfil);
//       };

//       reader.readAsDataURL(input.files[0]);
//     }
//   }
// }

// $("#foto").change(function () {
//   //Cuando el input cambie (se cargue un nuevo archivo) se va a ejecutar de nuevo el cambio de imagen y se verá reflejado.
//   vistaPrevia(this);
// });

function comboRoles() {
  $.ajax({
    type: "POST",
    url: "../servicios/roles/cargar_roles.php",
    dataType: "json",
    success: function (json) {
      $.each(json, function (i, obj) {
        $("#rol").append($("<option>").text(obj.rol).attr("value", obj.id_rol));
      });
    },
  });
}

comboRoles();

let usuarios;

function cargarUsuarios() {
  usuarios = $("#tabla_usuarios").DataTable({
    language: {
      decimal: "",
      emptyTable: "No hay datos disponibles en la tabla",
      info: "Mostrando _START_ a _END_ de _TOTAL_ datos",
      infoEmpty: "Sin datos a mostrar",
      infoFiltered: "(filtradas de _MAX_ entradas totales)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ entradas",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "No se encontraron registros coincidentes",
      paginate: {
        first: "Primero",
        last: "Último",
        next: "Siguiente",
        previous: "Anterior",
      },
      aria: {
        sortAscending: ": activar para ordenar la columna ascendente",
        sortDescending: ": activar para ordenar la columna descendente",
      },
    },
    columnDefs: [
      {
        targets: [3, 4],
        className: "dt-body-center",
      },
      {
        target: [0, 1, 2, 3, 4],
        className: "vert",
      },
    ],
    ajax: {
      url: "../servicios/usuarios/cargar_usuarios.php",
      dataSrc: "",
    },
    columns: [
      { data: "funcionario" },
      { data: "usuario" },
      { data: "correo" },
      { data: "rol" },
      {
        data: "foto",
        render: function (data) {
          return (
            "<img class='rounded-5 perfil' width='50px' height='50px' src='../img/usuarios/" +
            data +
            "' id='" +
            data +
            "'>"
          );
        },
      },
      {
        data: null,
        defaultContent:
          "<div class='container d-flex'> <a class='btn btn-outline-primary editar'><i class='fa fa-pen-to-square'></i> </a>" +
          "<a class='btn btn-outline-danger eliminar ms-2'><i class='fa fa-trash'></i> </a> </div>",
      },
    ],
    createdRow: function (row, data) {
      $("a.editar", row).attr("id", data.id_usuario);
      $("a.eliminar", row).attr("id", data.id_usuario);
    },
  });
}

// Llamada al reporte de la tabla
$("#generarPDF").click(function () {
  window.open("../reportes/report_usuarios.php", "_blank");
});

cargarUsuarios();

function buscar_funcionario() {
  let ci = $("#ci").val();
  $.ajax({
    url: "../servicios/usuarios/buscar_funcionario.php",
    method: "POST",
    data: { ci: ci },
    dataType: "json",
    success: function (json) {
      if (json.tiene == false) {
        $("#id_funcionario").val(json.id_funcionario);
        $("#funcionario").val(json.nombre);
        $("#correo").focus();
      } else if (json.tiene == true) {
        $("#ci").val("");
        $("#ci").focus();
        warningMessage(json.mensaje);
      }
    },
  });
}

$(document).on("click", ".perfil", function () {
  Swal.fire({
    imageUrl: "../img/usuarios/" + $(this).attr("id"),
    imageWidth: 300,
    imageHeight: 300,
    showConfirmButton: false,
    background: "transparent",
  });
});

// $("#sin_perfil").click(function () {
//   if ($("#sin_perfil").prop("checked")) {
//     $("#vista_previa").attr("src", "#");
//     $("#foto").val("");
//     $("#foto").prop("disabled", true);
//     perfil = "no";
//     imagen = "no";
//     $("#perfil").val("no");
//     console.log(perfil);
//     $("#span_vista").html("");
//   } else {
//     $("#foto").prop("disabled", false);
//   }
// });

function validarUsuario(usuario) {
  $.ajax({
    url: "../servicios/usuarios/verificar_usuario.php",
    method: "POST",
    data: { usuario: usuario },
    dataType: "json",
    success: function (json) {
      if (json.existe == true) {
        $("#error_usuario").text("Nombre de usuario no disponible");
        $("#error_usuario").css("color", "#e63946");
        usuario_valido = "no";
        // $("#usuario").focus();
      } else if (json.existe == false) {
        $("#error_usuario").text("");
        usuario_valido = "si";
        console.log(json.mensaje);
      } else if (json.error == true) {
        console.log(json.mensaje);
      }
    },
  });
}

function validarContrasenha() {
  let password = $("#password").val();
  if (validar_contrasenha(password) == false) {
    $("#error_password").text(
      "La contraseña debe contener al menos 2 letras mayúsculas y minúsculas, 2 números y 2 caracteres especiales"
    );
    $("#error_password").css("color", "#e63946");
    console.log("no valido");
    password_valido = "no";
  } else {
    $("#error_password").text("");
    password_valido = "si";
    console.log("valido");
  }
}

function estaCargado() {
  let funcionario = $("#funcionario").val();
  let correo = $("#correo").val();
  let rol = $("#rol").val();
  let usuario = $("#usuario").val();
  let password = $("#password").val();

  if (funcionario.length == 0) {
    toastr.warning("Falta el nombre del funcionario");
    $("#ci").focus();
    return false;
  } else if (correo.length == 0) {
    toastr.warning("Ingrese un correo.");
    $("#correo").focus();
    return false;
  } else if (validarCorreo($("#correo").val()) == false) {
    toastr.warning("Ingrese un correo valido.");
    $("#correo").val();
    return false;
  } else if (rol == "") {
    toastr.warning("Seleccione un rol.");
    return false;
  } else if (usuario.length == 0) {
    toastr.warning("Ingrese un nombre de usuario.");
    $("#usuario").focus();
    return false;
  } else if (password.length == 0) {
    toastr.warning("Ingrese una contraseña.");
    $("#password").focus();
    return false;
  } else {
    return true;
  }
}

function guardar_usuario() {
  if (
    estaCargado() == true &&
    usuario_valido == "si" &&
    password_valido == "si"
  ) {
    $.ajax({
      url: "../servicios/usuarios/guardar_usuario.php",
      method: "POST",
      data: {
        correo: $("#correo").val(),
        id_rol: $("#rol").val(),
        id_funcionario: $("#id_funcionario").val(),
        foto: "sin_perfil.jpg",
        usuario: $("#usuario").val(),
        password: $("#password").val(),
      },
      dataType: "json",
      success: function (json) {
        if (json.guardado == true) {
          successMessage(json.mensaje);
          usuarios.ajax.reload();
          $("#modalUsuarios").modal("hide");
        } else if (json.guardado == false) {
          errorMessage(json.mensaje);
        }
      },
    });
  }
}

$(document).on("click", ".editar", function () {
  id_usuario = $(this).attr("id");
  $("#modalUsuarios").modal("show");
  $(".modal-title").text("Modificar Usuario");
  $("#btn_guardar").text("Actualizar");
  operacion = "Editar";
  $.ajax({
    url: "../servicios/usuarios/obtener_usuario.php",
    method: "POST",
    data: { id_usuario: id_usuario },
    dataType: "json",
    success: function (json) {
      if (json.encontrado == true) {
        $("#btn_buscar").prop("disabled", true);
        $("#ci").prop("disabled", true);
        $("#ci").val(json.ci);
        $("#funcionario").val(json.funcionario);
        $("#correo").val(json.correo);
        $("#rol").val(json.id_rol);
        $("#id_funcionario").val(json.id_funcionario);
        $("#usuario").val(json.usuario);
        $("#password").val(json.password);
      }
    },
  });
});

function modificar_usuario() {
  if (estaCargado()) {
    let correo = $("#correo").val().trim();
    let id_rol = $("#rol").val();
    let usuario = $("#usuario").val().trim();
    let password = $("#password").val().trim();
    $.ajax({
      url: "../servicios/usuarios/modificar_usuario.php",
      method: "POST",
      data: {
        correo: correo,
        id_rol: id_rol,
        usuario: usuario,
        password: password,
        id_usuario: id_usuario,
      },
      dataType: "json",
      success: function (json) {
        if (json.modificado == true) {
          $("#modalUsuarios").modal("hide");
          usuarios.ajax.reload();
          successMessage(json.mensaje);
        } else {
          errorMessage(json.mensaje);
        }
      },
    });
  }
}

$("#btn_guardar").click(function () {
  if (operacion == "Nuevo") {
    guardar_usuario();
  } else if (operacion == "Editar") {
    modificar_usuario();
  }
});

// Funcionalidad del boton de eliminar

$(document).on("click", ".eliminar", function () {
  // Se obtiene el id del usuarop y se almacena en la variable id_usuario
  id_usuario = $(this).attr("id");
  // Mensaje de confirmacion
  Swal.fire({
    title: "¡¡¡MENSAJE!!!",
    text: "Esta seguro de eliminar este usuario?",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminar.",
    cancelButtonText: "Cancelar.",
  }).then((result) => {
    if (result.isConfirmed) {
      // Proceso de la llamada al script que se encarga de la eliminacion
      $.ajax({
        url: "../servicios/usuarios/eliminar_usuario.php",
        method: "POST",
        data: { id_usuario: id_usuario },
        dataType: "json",
        success: function (json) {
          if (json.eliminado === true) {
            successMessage(json.mensaje);
            usuarios.ajax.reload();
          } else {
            errorMessage(json.mensaje);
          }
        },
      });
    }
  });
});
