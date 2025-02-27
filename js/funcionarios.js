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
let id_fun = 0;

// Al hacer en el boton nuevo mostramos el modal y asignamos el titulo y la operacion a realizar
// y a su vez reseteamos el formulario en caso de que hubiensen quedado datos.

$("#btn_nuevo").click(() => {
  $("#modalFuncionarios").modal("show");
  $(".modal-title").text("Nuevo Funcionario");
  $("#form_funcionarios")[0].reset();
  operacion = "Nuevo";
});

$("#btn_salir").click(() => {
  location.href = "menu.php";
});

function comboCiudades() {
  $.ajax({
    type: "POST",
    url: "../servicios/ciudades/cargar_ciudades.php",
    dataType: "json",
    success: function (json) {
      $.each(json, function (i, obj) {
        $("#ciudad").append(
          $("<option>").text(obj.ciudad).attr("value", obj.id_ciudad)
        );
      });
    },
  });
}

function comboDependencias() {
  $.ajax({
    type: "POST",
    url: "../servicios/dependencias/cargar_dependencias.php",
    dataType: "json",
    success: function (json) {
      $.each(json, function (i, obj) {
        $("#dependencia").append(
          $("<option>").text(obj.dependencia).attr("value", obj.id_dependencia)
        );
      });
    },
  });
}

comboCiudades();
comboDependencias();

siguienteCampo($("#ci"), $("#nombre"));
siguienteCampo($("#nombre"), $("#apellido"));

// Variable para almacenar estructura del dataTable y los datos
let funcionarios;

function cargarFuncionarios() {
  funcionarios = $("#tabla_funcionarios").DataTable({
    language: {
      decimal: "",
      emptyTable: "No hay datos disponibles en la tabla",
      info: "Mostrando _START_ a _END_ de _TOTAL_ funcionarios",
      infoEmpty: "Sin datos a mostrar",
      infoFiltered: "",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ funcionarios",
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
      // Alineamos los datos de la columna C.I a la derecha
      {
        targets: [0],
        className: "dt-body-right",
      },
      // Alineamos la columna de los botones en el centro
      {
        targets: [6],
        className: "dt-body-center",
      },
      // Asignamos el tamaño de la fuente para los datos de todas las filas
      {
        targets: [0, 1, 2, 3, 4, 5, 6],
        className: "font",
      },
    ],
    ajax: {
      url: "../servicios/funcionarios/cargar_funcionarios.php",
      dataSrc: "",
    },
    columns: [
      { data: "ci" },
      { data: "nombre" },
      { data: "ciudad" },
      { data: "direccion" },
      { data: "telefono" },
      { data: "dependencia" },
      {
        data: null,
        defaultContent:
          "<div class='container-fluid d-flex'> <a class='btn btn-outline-primary editar'><i class='fa fa-pen-to-square'></i> </a>" +
          "<a class='btn btn-outline-danger eliminar ms-2'><i class='fa fa-trash'></i> </a> </div>",
      },
    ],
    createdRow: function (row, data) {
      $("a.editar", row).attr("id", data.id_funcionario);
      $("a.eliminar", row).attr("id", data.id_funcionario);
    },
  });
}

// Llamada al reporte de la tabla
$("#generarPDF").click(function () {
  window.open("../reportes/report_funcionarios.php", "_blank");
});

cargarFuncionarios();

function esta_cargado() {
  let ci = $("#ci").val().trim();
  let nombre = $("#nombre").val().toUpperCase().trim();
  let apellido = $("#apellido").val().toUpperCase().trim();
  let id_ciudad = $("#ciudad").val();
  let direccion = $("#direccion").val().toUpperCase().trim();
  let telefono = $("#telefono").val().trim();
  let id_dependencia = $("#dependencia").val();

  // Validamos si todos los campos han sido cargados
  if (ci.length == 0) {
    toastr.warning("Ingrese el ci.");
    $("#ci").focus();
    return false;
  } else if (nombre.length == 0) {
    toastr.warning("Ingrese el nombre.");
    $("#nombre").focus();
    return false;
  } else if (apellido.length == 0) {
    toastr.warning("Ingrese el apellido.");
    $("#apellido").focus();
    return false;
  } else if (id_ciudad.length == 0) {
    toastr.warning("Seleccione una ciudad.");
    return false;
  } else if (direccion.length == 0) {
    toastr.warning("Ingrese la direccion.");
    $("#direccion").focus();
    return false;
  } else if (telefono.length == 0) {
    toastr.warning("Ingrese el telefono.");
    $("#telefono").focus();
    return false;
  } else if (id_dependencia.length == 0) {
    toastr.warning("Seleccione una dependencia.");
    return false;
  } else {
    return true;
  }
}

function guardar_funcionario() {
  let ci = $("#ci").val().trim();
  let nombre = $("#nombre").val().toUpperCase().trim();
  let apellido = $("#apellido").val().toUpperCase().trim();
  let id_ciudad = $("#ciudad").val();
  let direccion = $("#direccion").val().toUpperCase().trim();
  let telefono = $("#telefono").val().toUpperCase().trim();
  let id_dependencia = $("#dependencia").val();

  // Validamos si todos los campos han sido cargados
  if (esta_cargado() == true) {
    // Procedemos con la operación de insercción
    $.ajax({
      url: "../servicios/funcionarios/guardar_funcionario.php",
      method: "POST",
      data: {
        ci: ci,
        nombre: nombre,
        apellido: apellido,
        id_ciudad: id_ciudad,
        direccion: direccion,
        telefono: telefono,
        id_dependencia: id_dependencia,
      },
      dataType: "json",
      success: function (json) {
        // Verificamos si el guardado fue exitoso
        if (json.guardado == true) {
          successMessage(json.mensaje);
          $("#modalFuncionarios").modal("hide");
          funcionarios.ajax.reload();
        } else if (json.guardado == false) {
          // En caso contrario mostramos el error
          errorMessage(json.mensaje);
        } else if (json.existe == true) {
          $("#ci").focus();
          warningMessage(json.mensaje);
        }
      },
    });
  }
}

// Mostramos el modal modificando los titulos y obteniendo los datos del funcionario
$(document).on("click", ".editar", function () {
  $("#modalFuncionarios").modal("show");
  $(".modal-title").text("Modificar Funcionario");
  $("#btn_guardar").text("Actualizar");
  // Guardamos el id del funcionario que esta en el boton en la variable id_fun
  id_fun = $(this).attr("id");
  $.ajax({
    url: "../servicios/funcionarios/obtener_funcionario.php",
    method: "POST",
    data: { id_funcionario: id_fun },
    dataType: "json",
    success: function (json) {
      // Verificamos si el funcionario fue encontrado
      if (json.encontrado == true) {
        $("#ci").val(json.ci);
        $("#nombre").val(json.nombre);
        $("#apellido").val(json.apellido);
        $("#ciudad").val(json.id_ciudad);
        $("#direccion").val(json.direccion);
        $("#telefono").val(json.telefono);
        $("#dependencia").val(json.id_dependencia);
      } else {
        // Mostramos el error si hubiese
        errorMessage(json.mensaje);
      }
    },
  });
});

function modificar_funcionario() {
  let ci = $("#ci").val().trim();
  let nombre = $("#nombre").val().toUpperCase().trim();
  let apellido = $("#apellido").val().toUpperCase().trim();
  let id_ciudad = $("#ciudad").val();
  let direccion = $("#direccion").val().toUpperCase().trim();
  let telefono = $("#telefono").val().toUpperCase().trim();
  let id_dependencia = $("#dependencia").val();

  // Validamos si todos los campos han sido cargados
  if (esta_cargado() == true) {
    // Procedemos con la operación de insercción
    $.ajax({
      url: "../servicios/funcionarios/modificar_funcionario.php",
      method: "POST",
      data: {
        ci: ci,
        nombre: nombre,
        apellido: apellido,
        id_ciudad: id_ciudad,
        direccion: direccion,
        telefono: telefono,
        id_dependencia: id_dependencia,
        // Enviamos la variable id_fun que contiene el id del funcionario que estamos modificando
        id_funcionario: id_fun,
      },
      dataType: "json",
      success: function (json) {
        // Verificamos si la modificacion de los datos fue exitosa
        if (json.modificado == true) {
          successMessage(json.mensaje);
          $("#modalFuncionarios").modal("hide");
          funcionarios.ajax.reload();
        } else if (json.modificado == false) {
          // En caso contrario mostramos el error
          errorMessage(json.mensaje);
        } else if (json.existe == true) {
          $("#ci").focus();
          warningMessage(json.mensaje);
        }
      },
    });
  }
}

$("#btn_guardar").click(() => {
  if (operacion == "Nuevo") {
    guardar_funcionario();
  } else {
    modificar_funcionario();
  }
});

$(document).on("click", ".eliminar", function () {
  id_fun = $(this).attr("id");
  Swal.fire({
    title: "!!!MENSAJE¡¡¡",
    text: "Esta seguro de eliminar a este funcionario?",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminar.",
    cancelButtonText: "Cancelar.",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../servicios/funcionarios/eliminar_funcionario.php",
        method: "POST",
        data: { id_funcionario: id_fun },
        dataType: "json",
        success: function (json) {
          if (json.eliminado == true) {
            successMessage(json.mensaje);
            funcionarios.ajax.reload();
          } else {
            errorMessage(json.mensaje);
          }
        },
      });
    }
  });
});
