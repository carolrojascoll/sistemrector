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
  let id_dependencia = 0;
  
  $("#btn_nuevo").click(function () {
    $("#modalDependencias").modal("show");
    $(".modal-title").text("Nueva Dependencia");
    $("#dependencia").val("");
    operacion = "Nuevo";
  });

  $("#btn_salir").click(() => {
    location.href = "menu.php";
  });
  
  siguienteClick($("#dependencia"), $("#btn_guardar"));
  
  let dependencias;
  
  function cargarDependencias() {
    dependencias = $("#tabla_dependencias").DataTable({
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
        url: "../servicios/dependencias/cargar_dependencias.php",
        dataSrc: "",
      },
      columns: [
        { data: "dependencia" },
        {
          data: null,
          defaultContent:
            "<div class='container-fluid d-flex'> <a class='btn btn-outline-primary editar'><i class='fa fa-pen-to-square'></i> </a>" +
            "<a class='btn btn-outline-danger eliminar ms-2'><i class='fa fa-trash'></i> </a> </div>",
        },
      ],
      createdRow: function (row, data) {
        $("a.editar", row).attr("id", data.id_dependencia);
        $("a.eliminar", row).attr("id", data.id_dependencia);
      },
    });
  }
  
// Llamada al reporte de la tabla
$("#generarPDF").click(function () {
  window.open("../reportes/report_dependencias.php", "_blank");
});
  
  cargarDependencias();
  
  function guardarDepencia() {
    let dependencia = $("#dependencia").val().toUpperCase();
    if (dependencia.length == 0) {
      toastr.warning("Ingrese una dependencia.");
      $("#dependencia").focus();
    } else {
      $.ajax({
        url: "../servicios/dependencias/guardar_dependencia.php",
        method: "POST",
        data: { dependencia: dependencia },
        dataType: "json",
        success: function (json) {
          if (json.guardado === true) {
            successMessage("Registro Insertado.");
            dependencias.ajax.reload();
            $("#modalDependencias").modal("hide");
          } else if (json.existe === true) {
            warningMessage("La dependencia ingresada ya existe");
            $("#dependencia").focus();
          } else {
            errorMessage(json.mensaje);
          }
        },
      });
    }
  }
  
  $(document).on("click", ".editar", function () {
    id_dependencia = $(this).attr("id");
    $("#modalDependencias").modal("show");
    $(".modal-title").text("Modificar Dependencias");
    $("#btn_guardar").text("Actualizar");
    operacion = "Editar";
    $.ajax({
      url: "../servicios/dependencias/obtener_dependencia.php",
      method: "POST",
      data: { id_dependencia: id_dependencia },
      dataType: "json",
      success: function (json) {
        if (json.encontrado === true) {
          $("#dependencia").val(json.dependencia);
        }
      },
    });
  });
  
  function modificarDependencia() {
    let dependencia = $("#dependencia").val().toUpperCase();
    if (dependencia.length == 0) {
      toastr.warning("Ingrese una dependencia.");
      $("#dependencia").focus();
    } else {
      $.ajax({
        url: "../servicios/dependencias/modificar_dependencia.php",
        method: "POST",
        data: {
          id_dependencia: id_dependencia,
          dependencia: dependencia,
        },
        dataType: "json",
        success: function (json) {
          if (json.modificado == true) {
            $("#modalDependencias").modal("hide");
            successMessage(json.mensaje);
            dependencias.ajax.reload();
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
      guardarDepencia();
    } else if (operacion === "Editar") {
      modificarDependencia();
    }
  }
  
  // Funcionalidad del boton de eliminar
  
  $(document).on("click", ".eliminar", function () {
    // Se obtiene el id de la rol y se almacena en la variable id_rol
    id_dependencia = $(this).attr("id");
    // Mensaje de confirmacion
    Swal.fire({
      title: "¡¡¡MENSAJE!!!",
      text: "Esta seguro de eliminar esta dependencia?",
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
          url: "../servicios/dependencias/eliminar_dependencia.php",
          method: "POST",
          data: { id_dependencia: id_dependencia },
          dataType: "json",
          success: function (json) {
            if (json.eliminado === true) {
              successMessage(json.mensaje);
              dependencias.ajax.reload();
            } else {
              errorMessage(json.mensaje);
            }
          },
        });
      }
    });
  });
  