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

let op_ciudades = "";
let id_ciudad = 0;
var pantalla = "ciudades";

var ciudades;

function cargarCiudades() {
  ciudades = $("#tabla_ciudades").DataTable({
    // Traduccion del DataTables
    language: {
      decimal: "",
      emptyTable: "No hay datos disponibles en la tabla",
      info: "Mostrando _START_ dato/s de _END_ a _TOTAL_ datos",
      infoEmpty: "Mostrando 0 a 0 de 0 datos",
      infoFiltered: "(filtrados de _MAX_ datos totales)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ datos",
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
      url: "../servicios/ciudades/cargar_ciudades.php",
      dataSrc: "",
    },
    columns: [
      { data: "ciudad" },
      {
        data: null,
        defaultContent:
          "<div class='container d-flex'><a class='btn btn-outline-primary  editar me-2'><i class='fa fa-pen-to-square'></i> </a>" +
          "<a class='btn btn-outline-danger eliminar ms-2'><i class='fa fa-trash'></i> </a></div>",
      },
    ],
    createdRow: function (row, data) {
      // Asignar el valor de id de la tabla como el ID de los botones
      $("a.editar", row).attr("id", data.id_ciudad);
      $("a.eliminar", row).attr("id", data.id_ciudad);
    },
  });
}

// Llamada al reporte de la tabla
$("#generarPDF").click(function () {
  window.open("../reportes/report_ciudad.php", "_blank");
});

cargarCiudades();

permisosPantalla(localStorage.user, pantalla);

$("#btn_nuevo").click(function () {
  op_ciudades = "Nuevo";
  $("#modalCiudades").modal("show");
  $(".modal-title").text("Nueva Ciudad");
  $("#ciudad").val("");
});

$("#btn_salir").click(() => {
  location.href = "menu.php";
});

siguienteClick($("#ciudad"), $("#btn_guardar"));

function guadarCiudad() {
  let ciudad = $("#ciudad").val().toUpperCase();
  if (ciudad.length == 0) {
    toastr.warning("Ingrese una ciudad.");
    $("#ciudad").focus();
  } else {
    $.ajax({
      url: "../servicios/ciudades/guardar_ciudad.php",
      method: "POST",
      data: { ciudad: ciudad },
      dataType: "json",
      success: function (json) {
        if (json.guardado == true) {
          successMessage(json.mensaje);
          ciudades.ajax.reload();
        } else if (json.existe == true) {
          warningMessage(json.mensaje);
        } else {
          errorMessage(json.mensaje);
        }
      },
    });
  }
}

$(document).on("click", ".editar", function () {
  op_ciudades = "Modificar";
  id_ciudad = $(this).attr("id");
  $("#modalCiudades").modal("show");
  $(".modal-title").text("Modificar Ciudad");
  $("#btn_guardar").text("Actualizar");
  operacion = "Editar";
  $.ajax({
    url: "../servicios/ciudades/obtener_ciudad.php",
    method: "POST",
    data: {
      id_ciudad: id_ciudad,
    },
    dataType: "json",
    success: function (json) {
      $("#modalCiudades").modal("show");
      $(".modal-title").text("Modificar Ciudad");
      $("#ciudad").val(json.ciudad);
      $("#ciudad").focus();
    },
  });
});

function modificarCiudad() {
  let ciudad = $("#ciudad").val().toUpperCase();
  if (ciudad.length == 0) {
    toastr.warning("Ingrese una ciudad.");
    $("#ciudad").focus();
  } else {
    $.ajax({
      url: "../servicios/ciudades/modificar_ciudad.php",
      method: "POST",
      data: {
        id_ciudad: id_ciudad,
        ciudad: ciudad,
      },
      dataType: "json",
      success: function (json) {
        if (json.modificado == true) {
          successMessage(json.mensaje);
          ciudades.ajax.reload();
          $("#ciudad").val("");
          $("#modal_ciudades").modal("hide");
        } else if (json.existe == true) {
          warningMessage(json.mensaje);
        } else {
          errorMessage(json.mensaje);
        }
      },
    });
  }
}

function eliminarCiudad(id_ciudad) {
  Swal.fire({
    title: "!!!MENSAJE!!!",
    text: "¿Esta seguro de eliminar esta ciudad?",
    icon: "question",
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    showCancelButton: true,
    confirmButtonText: "Sí, eliminar.",
    cancelButtonText: "Cancelar.",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../servicios/ciudades/eliminar_ciudad.php",
        method: "POST",
        data: { id_ciudad: id_ciudad },
        dataType: "json",
        success: function (json) {
          if (json.eliminado == true) {
            successMessage(json.mensaje);
            ciudades.ajax.reload();
          } else {
            errorMessage(json.mensaje);
          }
        },
      });
    }
  });
}

$(document).on("click", ".eliminar", function () {
  id_ciudad = $(this).attr("id");
  eliminarCiudad(id_ciudad);
});

$("#btn_guardar").click(function () {
  if (op_ciudades == "Nuevo") {
    guadarCiudad();
  } else if (op_ciudades == "Modificar") {
    modificarCiudad();
  }
});

$("#btn_salir").click(() => {
  location.href = "../vistas/menu.php";
});
