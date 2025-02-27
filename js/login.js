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

siguienteCampo($("#usuario"), $("#password"));
siguienteClick($("#password"), $("#btn_acceder"));
siguienteCtrl($("#password"), $("#hide-show"));

function validarAcceso() {
  let usuario = $("#usuario").val();
  let password = $("#password").val();
  if (usuario.length === 0) {
    toastr.warning("Ingrese su usuario.");
    $("#usuario").focus();
  } else if (password.length === 0) {
    toastr.warning("Ingrese su contraseña.");
    $("#password").focus();
  } else {
    $.ajax({
      url: "servicios/login.php",
      method: "POST",
      data: {
        usuario: usuario,
        password: password,
      },
      dataType: "json",
      success: function (json) {
        if (json.acceso === true) {
          // successMessage("Acceso Correcto.!!!");
          localStorage.user = usuario;
          location.href = "vistas/menu.php";
        } else if (json.acceso === false) {
          toastr.warning("Usuario y/o contraseña incorrectos.!!!");
        } else {
          errorMessage(json.error);
        }
      },
    });
  }
}
