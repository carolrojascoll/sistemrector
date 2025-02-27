function permisosMenu() {
  $.ajax({
    url: "../servicios/menu/permisos_menu.php",
    method: "POST",
    data: { usuario: localStorage.user },
    dataType: "json",
    success: function (data) {
      if (Array.isArray(data)) {
        data.forEach(function (permiso) {
          let pantalla = permiso.pantalla;
          let leer = permiso.leer;
          if( leer == 0) {
            $("#" + pantalla).hide();
          }
            
        });
      }
    },
  });
}

permisosMenu();

function permisosPantalla(usuario, pantalla) {
    $.ajax({
        url: "../servicios/menu/permisos_pantalla.php",
        method: "POST",
        data: 
        {
            usuario: usuario,
            pantalla: pantalla
        },
        dataType: "json",
        success: function(data) {
            if (Array.isArray(data)) {
                data.forEach(function(permisos) {
                    let alta = permisos.alta;
                    let baja = permisos.baja;
                    let modificacion = permisos.modificacion;

                    if(alta == 1) {
                        $("#btn_nuevo").prop("disabled", false);
                    } else {
                        $("#btn_nuevo").prop("disabled", true);
                    }

                    if(baja == 1) {
                        $(".eliminar").prop("disabled", false);
                    } else {
                        $(".eliminar").prop("disabled", true);
                    }

                    if(modificacion == 1) {
                        $(".editar").prop("disabled", false);
                    } else {
                        $(".editar").prop("disabled", true);
                    }

                })
            }
        }
    })
}