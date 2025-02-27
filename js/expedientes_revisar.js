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

function comboDependencias() {
  $.ajax({
    type: "POST",
    url: "../servicios/dependencias/cargar_dependencias.php",
    dataType: "json",
    success: function (json) {
      $.each(json, function (i, obj) {
        $("#dependencia_expedientes").append(
          $("<option>").text(obj.dependencia).attr("value", obj.dependencia)
        );
      });
      $("#dependencia_expedientes").append(
        $("<option>").text("MOSTRAR TODOS").attr("value", "todo")
      );
    },
  });
}

$("#btn_salir").click(() => {
  location.href = "menu.php";
});

comboDependencias();

let id_expediente = 0;
let tablaExpedientes;
let dependencia;
let admin = false;

// Verificamos que si el rol del usuario es ADMINISTRADOR se muestre el select para filtrar por dependencias
if (localStorage.rol != "ADMINISTRADOR") {
  $("#div_select").hide();
  admin = false;
  dependencia = localStorage.dependencia;
} else {
  admin = true;
  dependencia = $("#dependencia_expedientes").val();
}

function cargarExpedientes() {
    
    if ($.fn.dataTable.isDataTable("#tabla_expedientes")) {
    $("#tabla_expedientes").DataTable().clear().destroy();
  }

  if(admin == true) {
    dependencia = $("#dependencia_expedientes").val();
  }

  tablaExpedientes = $("#tabla_expedientes").DataTable({
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
        targets: [8],
        className: "dt-body-center",
      },
      {
        targets: [0, 1, 2, 3, 4, 5, 6, 7, 8],
        className: "font",
      },
    ],
    ajax: {
      url: "../servicios/expedientes/expediente_revisar.php",
      method: "POST",
      data: { 
        dependencia: dependencia
       },
      dataType: "json",
      dataSrc: "",
    },
    columns: [
      { data: "nro_expediente" },
      { data: "fecha" },
      { data: "anhio" },
      { data: "remitente" },
      { data: "objeto" },
      { data: "dependencia" },
      { data: "funcionario" },
      { data: "observacion" },
      {
        data: null,
        defaultContent:
          "<div class='container d-flex'><a class='btn btn-outline-primary editar me-2'><i class='fa fa-pen-to-square'></i> </a>" +
          "<a class='btn btn-outline-success agregar'><i class='fa fa-plus'></i> </a>" +
          "<a class='btn btn-outline-warning terminar ms-2'><i class='fa fa-check'></i> </a></div>",
      },
    ],
    createdRow: function (row, data) {
      // Asignar el valor de id de la tabla como el ID de los botones
      $("a.editar", row).attr("id", data.id_expediente);
      $("a.agregar", row).attr("id", data.id_expediente);
      $("a.terminar", row).attr("id", data.id_expediente);
    },
  });
}

cargarExpedientes();

$("#dependencia_expedientes").change(function() {
  cargarExpedientes();
});

// =============== Funcionalidad boton "Editar"

function comboAreas() {
  $.ajax({
    type: "POST",
    url: "../servicios/areas/cargar_areas.php",
    dataType: "json",
    success: function (json) {
      $.each(json, function (i, obj) {
        $("#area_edit").append(
          $("<option>").text(obj.area).attr("value", obj.id_area)
        );
      });
    },
  });
}

comboAreas();

function comboDependenciasEdit() {
  $.ajax({
    type: "POST",
    url: "../servicios/dependencias/cargar_dependencias.php",
    dataType: "json",
    success: function (json) {
      $.each(json, function (i, obj) {
        $("#dependencia_edit").append(
          $("<option>")
            .text(obj.dependencia)
            .attr("value", obj.id_dependencia)
        );
      });
    },
  });
}

comboDependenciasEdit();

function comboObjetos() {
  $.ajax({
    type: "POST",
    url: "../servicios/objetos/cargar_objetos.php",
    dataType: "json",
    success: function (json) {
      $.each(json, function (i, obj) {
        $("#objeto_edit").append(
          $("<option>").text(obj.objeto).attr("value", obj.id_objeto)
        );
      });
    },
  });
}

comboObjetos();

// Obtener datos del expediente para vista previa
$(document).on("click", ".editar", function () {
  $("#modalEditarExp").modal("show"); 
  id_expediente = $(this).attr("id");
  $.ajax({
    url: "../servicios/expedientes/obtener_expediente.php",
    method: "POST",
    data: {id_expediente: id_expediente},
    dataType: "json",
    success: function(json) {
      if(json.encontrado == true) {
        $("#nro_edit").val(json.nro);
        $("#fecha_edit").val(json.fecha);
        $("#anhio_edit").val(json.anhio);
        $("#area_edit").val(json.area);
        $("#objeto_edit").val(json.objeto);
        $("#dependencia_edit").val(json.dependencia);
        $("#observacion_edit").val(json.observacion);
      } 
    }
  })
});

// Funcion que realiza el update de los datos
function modificarExpediente() {
  let nro = $("#nro_edit").val().trim();
  let anhio = $("#anhio_edit").val();
  let area = $("#area_edit").val();
  let objeto = $("#objeto_edit").val();
  let dependencia = $("#dependencia_edit").val();
  let observacion = $("#observacion_edit").val();

  if (nro.length == 0) {
    toastr.warning("El número de expediente no puede quedar vacío.!!!");
    $("#nro_edit").focus();
  } else if (anhio.length == 0) {
    toastr.warning("El año no debe quedar vacío.!!!");
    $("#anhio_edit").focus();
  } else if (anhio.length != 4) {
    toastr.warning("Debe ingresar un año válido (4 dígitos).");
    $("#anhio_edit").focus();
  } else if (area.length == 0) {
    toastr.warning("Debe seleccionar un área.");
    $("#area_edit").focus();
  } else if (objeto.length == 0) {
    toastr.warning("Debe seleccionar un objeto.");
    $("#objeto_edit").focus();
  } else if (dependencia.length == 0) {
    toastr.warning("Debe seleccionar una dependencia.");
    $("#dependencia_edit").focus();
  } else if (observacion.length > 255) {
    toastr.warning("La observación no puede exceder los 255 caracteres.");
    $("#observacion_edit").focus();
  } else {
    $.ajax({
      url: "../servicios/expedientes/editar_expediente.php",
      method: "POST",
      data: 
      {
        nro_expediente: nro,
        anhio: anhio,
        area: area,
        objeto: objeto,
        dependencia: dependencia,
        observacion: observacion,
        id_expediente: id_expediente
      },
      dataType: "json",
      success: function(json) {
        if(json.existe == true){
          warningMessage(json.mensaje);
        } else {
          if(json.modificado == true) {
            successMessage(json.mensaje);
            $("#modalEditarExp").modal("hide");
            tablaExpedientes.ajax.reload();
          } else {
            errorMessage(json.mensaje);
          }
        }
      }
    })
  }
}

// Asignamos la funcion al boton
$("#btn_guardar").click(function() {
  modificarExpediente();
})
