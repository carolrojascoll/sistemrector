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
  let id_objeto = 0;
  
  $("#btn_nuevo").click(function () {
    $("#modalObjetos").modal("show");
    $(".modal-title").text("Nuevo Objeto");
    $("#codigo").val("");
    $("#objeto").val("");
    operacion = "Nuevo";
  });

  $("#btn_salir").click(() => {
    location.href = "menu.php";
  });
  
  siguienteCampo($("#codigo"), $("#objeto"));
  siguienteClick($("#objeto"), $("#btn_guardar"));
  
  let objetos;
  
  function cargarObjetos() {
    objetos = $("#tabla_objetos").DataTable({
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
          targets: [2],
          className: "dt-body-center",
        },
        {
            targets: [0],
            className: "dt-body-right",
        },
      ],
      ajax: {
        url: "../servicios/objetos/cargar_objetos.php",
        dataSrc: "",
      },
      columns: [
        { data: "codigo" },
        { data: "objeto" },
        {
          data: null,
          defaultContent:
            "<div class='container-fluid d-flex'> <a class='btn btn-outline-primary neon-btn editar'><i class='fa fa-pen-to-square'></i> </a>" +
            "<a class='btn btn-outline-danger neon-btn eliminar ms-2'><i class='fa fa-trash'></i> </a> </div>",
        },
      ],
      createdRow: function (row, data) {
        $("a.editar", row).attr("id", data.id_objeto);
        $("a.eliminar", row).attr("id", data.id_objeto);
      },
    });
  }
  
// Llamada al reporte de la tabla
$("#generarPDF").click(function () {
  window.open("../reportes/report_objetos.php", "_blank");
});

  cargarObjetos();
  
  function guardarObjeto() {
    let codigo = $("#codigo").val();
    let objeto = $("#objeto").val().toUpperCase();
    if (codigo.length == 0) {
      toastr.warning("Ingrese un código.");
      $("#codigo").focus();
    } else if(objeto.length == 0) {
        toastr.warning("Ingrese el objeto.");
        $("#objeto").focus();
    } else  {
      $.ajax({
        url: "../servicios/objetos/guardar_objeto.php",
        method: "POST",
        data: 
        { 
            codigo: codigo,
            objeto: objeto,
        },
        dataType: "json",
        success: function (json) {
          if (json.guardado === true) {
            successMessage("Registro Insertado.");
            objetos.ajax.reload();
            $("#modalObjetos").modal("hide");
          } else if (json.existe === true) {
            warningMessage(json.mensaje);
            $(json.focus).focus();
          } else {
            errorMessage(json.mensaje);
          }
        },
      });
    }
  }
  
  $(document).on("click", ".editar", function () {
    id_objeto = $(this).attr("id");
    $("#modalObjetos").modal("show");
    $(".modal-title").text("Modificar Objeto");
    $("#btn_guardar").text("Actualizar");
    operacion = "Editar";
    $.ajax({
      url: "../servicios/objetos/obtener_objeto.php",
      method: "POST",
      data: { id_objeto: id_objeto },
      dataType: "json",
      success: function (json) {
        if (json.encontrado === true) {
          $("#codigo").val(json.codigo);
          $("#objeto").val(json.objeto);
        }
      },
    });
  });
  
  function modificarObjeto() {
    let codigo = $("#codigo").val();
    let objeto = $("#objeto").val().toUpperCase();
    if (objeto.length == 0) {
      toastr.warning("Ingrese el objeto.");
      $("#objeto").focus();
    } else if(codigo.length == 0) {
        toastr.warning("Ingrese un código.");
        $("#codigo").focus();
    } else {
      $.ajax({
        url: "../servicios/objetos/modificar_objeto.php",
        method: "POST",
        data: {
          codigo: codigo,
          objeto: objeto,
          id_objeto: id_objeto,
        },
        dataType: "json",
        success: function (json) {
          if (json.modificado == true) {
            $("#modalObjetos").modal("hide");
            successMessage(json.mensaje);
            objetos.ajax.reload();
          } else if (json.existe == true) {
            warningMessage(json.mensaje);
            $(json.focus).focus();
          } else {
            errorMessage(json.mensaje);
          }
        },
      });
    }
  }
  
  function operaciones() {
    if (operacion === "Nuevo") {
      guardarObjeto();
    } else if (operacion === "Editar") {
      modificarObjeto();
    }
  }
  
  // Funcionalidad del boton de eliminar
  
  $(document).on("click", ".eliminar", function () {
    // Se obtiene el id de la rol y se almacena en la variable id_rol
    id_objeto = $(this).attr("id");
    // Mensaje de confirmacion
    Swal.fire({
      title: "¡¡¡MENSAJE!!!",
      text: "Esta seguro de eliminar este objeto?",
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
          url: "../servicios/objetos/eliminar_objeto.php",
          method: "POST",
          data: { id_objeto: id_objeto },
          dataType: "json",
          success: function (json) {
            if (json.eliminado === true) {
              successMessage(json.mensaje);
              objetos.ajax.reload();
            } else {
              errorMessage(json.mensaje);
            }
          },
        });
      }
    });
  });
  