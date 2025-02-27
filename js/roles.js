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
let id_roles = 0;

$("#btn_nuevo").click(function () {
  $("#modalRoles").modal("show");
  $(".modal-title").text("Nuevo Rol");
  $("#rol").val("");
  operacion = "Nuevo";
});

$("#btn_salir").click(() => {
  location.href = "menu.php";
});

siguienteClick($("#rol"), $("#btn_guardar"));

let roles;

function cargarRoles() {
  roles = $("#tabla_roles").DataTable({
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
        targets: [1],
        className: "dt-body-center",
      },
    ],
    ajax: {
      url: "../servicios/roles/cargar_roles.php",
      dataSrc: "",
    },
    columns: [
      { data: "rol" },
      {
        data: null,
        defaultContent:
          "<div class='container-fluid d-flex'> <a class='btn btn-outline-primary editar'><i class='fa fa-pen-to-square'></i> </a>" +
          "<a class='btn btn-outline-danger eliminar ms-2'><i class='fa fa-trash'></i> </a> </div>",
      },
    ],
    createdRow: function (row, data) {
      $("a.editar", row).attr("id", data.id_rol);
      $("a.eliminar", row).attr("id", data.id_rol);
    },
  });
}

// Llamada al reporte de la tabla
$("#generarPDF").click(function () {
  window.open("../reportes/report_roles.php", "_blank");
});

cargarRoles();

function guardarRol() {
  let rol = $("#rol").val().toUpperCase();
  if (rol.length == 0) {
    toastr.warning("Ingrese un rol.");
    $("#rol").focus();
  } else {
    $.ajax({
      url: "../servicios/roles/guardar_rol.php",
      method: "POST",
      data: { rol: rol },
      dataType: "json",
      success: function (json) {
        if (json.guardado === true) {
          successMessage("Registro Insertado.");
          roles.ajax.reload();
          $("#modalRoles").modal("hide");
        } else if (json.existe === true) {
          warningMessage("El rol ingresado ya existe. Ingrese otro rol");
          $("#rol").focus();
        } else {
          errorMessage(json.mensaje);
        }
      },
    });
  }
}

$(document).on("click", ".editar", function () {
  id_rol = $(this).attr("id");
  $("#modalRoles").modal("show");
  $(".modal-title").text("Modificar Rol");
  $("#btn_guardar").text("Actualizar");
  operacion = "Editar";
  $.ajax({
    url: "../servicios/roles/obtener_rol.php",
    method: "POST",
    data: { id_rol: id_rol },
    dataType: "json",
    success: function (json) {
      if (json.encontrado === true) {
        $("#rol").val(json.rol);
      }
    },
  });
});

function modificarRol() {
  let rol = $("#rol").val().toUpperCase();
  if (rol.length == 0) {
    toastr.warning("Ingrese un rol.");
    $("#rol").focus();
  } else {
    $.ajax({
      url: "../servicios/roles/modificar_rol.php",
      method: "POST",
      data: {
        id_rol: id_rol,
        rol: rol,
      },
      dataType: "json",
      success: function (json) {
        if (json.modificado == true) {
          $("#modalRoles").modal("hide");
          successMessage(json.mensaje);
          roles.ajax.reload();
        } else if (json.existe == true) {
          warningMessage(json.mensaje);
        } else {
          errorMessage(json.mensaje);
        }
      },
    });
  }
}

function operaciones() {
  if (operacion === "Nuevo") {
    guardarRol();
  } else if (operacion === "Editar") {
    modificarRol();
  }
}

// Funcionalidad del boton de eliminar

$(document).on("click", ".eliminar", function () {
  // Se obtiene el id de la rol y se almacena en la variable id_rol
  id_rol = $(this).attr("id");
  // Mensaje de confirmacion
  Swal.fire({
    title: "¡¡¡MENSAJE!!!",
    text: "Esta seguro de eliminar este rol?",
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
        url: "../servicios/roles/eliminar_rol.php",
        method: "POST",
        data: { id_rol: id_rol },
        dataType: "json",
        success: function (json) {
          if (json.eliminado === true) {
            successMessage(json.mensaje);
            roles.ajax.reload();
          } else {
            errorMessage(json.mensaje);
          }
        },
      });
    }
  });
});
