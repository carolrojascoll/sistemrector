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
  let id_area = 0;
  
  $("#btn_nuevo").click(function () {
    $("#modalAreas").modal("show");
    $(".modal-title").text("Nueva Area");
    $("#area").val("");
    operacion = "Nuevo";
  });
  
  $("#btn_salir").click(() => {
    location.href = "menu.php";
  });

  siguienteClick($("#area"), $("#btn_guardar"));
  
  let areas;
  
  function cargarAreas() {
    areas = $("#tabla_areas").DataTable({
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
        url: "../servicios/areas/cargar_areas.php",
        dataSrc: "",
      },
      columns: [
        { data: "area" },
        {
          data: null,
          defaultContent:
            "<div class='container-fluid d-flex'> <a class='btn btn-outline-primary editar'><i class='fa fa-pen-to-square'></i> </a>" +
            "<a class='btn btn-outline-danger eliminar ms-2'><i class='fa fa-trash'></i> </a> </div>",
        },
      ],
      createdRow: function (row, data) {
        $("a.editar", row).attr("id", data.id_area);
        $("a.eliminar", row).attr("id", data.id_area);
      },
    });
  }
  
// Llamada al reporte de la tabla
$("#generarPDF").click(function () {
  window.open("../reportes/report_areas.php", "_blank");
});

  cargarAreas();
  
  function guardarArea() {
    let area = $("#area").val().toUpperCase();
    if (area.length == 0) {
      toastr.warning("Ingrese un área.");
      $("#area").focus();
    } else {
      $.ajax({
        url: "../servicios/areas/guardar_area.php",
        method: "POST",
        data: { area: area },
        dataType: "json",
        success: function (json) {
          if (json.guardado === true) {
            successMessage("Registro Insertado.");
            areas.ajax.reload();
            $("#modalAreas").modal("hide");
          } else if (json.existe === true) {
            warningMessage("El área ingresada ya existe");
            $("#area").focus();
          } else {
            errorMessage(json.mensaje);
          }
        },
      });
    }
  }
  
  $(document).on("click", ".editar", function () {
    id_area = $(this).attr("id");
    $("#modalAreas").modal("show");
    $(".modal-title").text("Modificar Área");
    $("#btn_guardar").text("Actualizar");
    operacion = "Editar";
    $.ajax({
      url: "../servicios/areas/obtener_area.php",
      method: "POST",
      data: { id_area: id_area },
      dataType: "json",
      success: function (json) {
        if (json.encontrado === true) {
          $("#area").val(json.area);
        }
      },
    });
  });
  
  function modificarArea() {
    let area = $("#area").val().toUpperCase();
    if (area.length == 0) {
      toastr.warning("Ingrese un area.");
      $("#dependencia").focus();
    } else {
      $.ajax({
        url: "../servicios/areas/modificar_area.php",
        method: "POST",
        data: {
          id_area: id_area,
          area: area,
        },
        dataType: "json",
        success: function (json) {
          if (json.modificado == true) {
            $("#modalAreas").modal("hide");
            successMessage(json.mensaje);
            areas.ajax.reload();
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
      guardarArea();
    } else if (operacion === "Editar") {
      modificarArea();
    }
  }
  
  // Funcionalidad del boton de eliminar
  
  $(document).on("click", ".eliminar", function () {
    // Se obtiene el id de la rol y se almacena en la variable id_rol
    id_area = $(this).attr("id");
    // Mensaje de confirmacion
    Swal.fire({
      title: "¡¡¡MENSAJE!!!",
      text: "Esta seguro de eliminar esta área?",
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
          url: "../servicios/areas/eliminar_area.php",
          method: "POST",
          data: { id_area: id_area },
          dataType: "json",
          success: function (json) {
            if (json.eliminado === true) {
              successMessage(json.mensaje);
              areas.ajax.reload();
            } else {
              errorMessage(json.mensaje);
            }
          },
        });
      }
    });
  });
  