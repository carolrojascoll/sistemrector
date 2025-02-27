function siguienteCampo(actual, siguiente) {
  $(actual).keypress(function (event) {
    if (event.which === 13) {
      $(siguiente).focus();
      $(siguiente).select();
    }
  });
}

function siguienteClick(actual, siguiente) {
  $(actual).keypress(function (event) {
    if (event.which === 13) {
      $(siguiente).click();
    }
  });
}

function siguienteCtrl(actual, siguiente) {
  $(actual).keydown(function (event) {
    if (event.ctrlKey) {
      $(siguiente).click();
    }
  });
}

function mostrarPassword(campo, icono) {
  var cambio = document.getElementById(campo);
  if (cambio.type == "password") {
    cambio.type = "text";
    $("." + icono)
      .removeClass("fa fa-eye")
      .addClass("fa fa-eye-slash");
  } else {
    cambio.type = "password";
    $("." + icono)
      .removeClass("fa fa-eye-slash")
      .addClass("fa fa-eye");
  }
}

function successMessage(mensaje) {
  Swal.fire({
    title: "!!!MENSAJE!!!",
    text: mensaje,
    icon: "success",
    showConfirmButton: false,
    timer: "1500",
  });
}
function successMensaje(mensaje) {
  Swal.fire({
    title: "!!!MENSAJE!!!",
    text: mensaje,
    icon: "success",
    showConfirmButton: true,
    timer: "1500",
  });
}

function errorMessage(mensaje) {
  Swal.fire({
    title: "!!!MENSAJE!!!",
    text: mensaje,
    icon: "error",
    showConfirmButton: true,
  });
}

function warningMessage(mensaje) {
  Swal.fire({
    title: "!!!MENSAJE!!!",
    text: mensaje,
    icon: "warning",
    showConfirmButton: true,
  });
}

/* agregar lo siguiente a un input date para no permitir seleccionar fechas futuras
    max="<?= date("Y-m-d") ?>"
*/

/* agregar lo siguiente a un input datetime-local para no permitir seleccionar fechas y horas futuras
    max="<?= date('Y-m-d\TH:i', time()) ?>"
*/

// Asigna la fecha actual dd/mm/YYYY H:m:ss
function fechaActual(fecha) {
  var hoy = new Date().toISOString().split("T")[0];
  fecha.val(hoy);
}

// Asigna la fecha actual dd/mm/YYYY 
function fechaActualTime(fecha) {
  var ahora = new Date();
  var fechaFormateada = ahora.toISOString().split("T")[0]; // Formato YYYY-MM-DD
  var horas = String(ahora.getHours()).padStart(2, '0');
  var minutos = String(ahora.getMinutes()).padStart(2, '0');
  var fechaHoraCompleta = fechaFormateada + " " + horas + ":" + minutos;
  fecha.val(fechaHoraCompleta);
}

function asignarAnhio(fecha, campo) {
  let ahora = new Date(fecha.val());
  let anhio = ahora.getFullYear();
  campo.val(anhio);
}

function formatear(num) {
  n = new Intl.NumberFormat("de-DE").format(num);
  return n;
}

function quitarSeparador(num) {
  // Convertir el número a cadena y verificar si contiene un punto
  if (num.toString().includes(".")) {
    // Si tiene un punto, quitar todos los puntos
    var n = num.toString().replace(/\./g, "");
    return n;
  } else {
    // Si no tiene un punto, devolver el número sin cambios
    return num.toString();
  }
}

function agregarSeparador(elemento) {
  // Obtener el valor actual del campo de entrada
  var valor = elemento.value;
  // Remover cualquier separador de miles previo
  valor = valor.replace(/,/g, "");
  // Agregar separadores de miles
  valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  // Establecer el valor modificado en el campo de entrada
  elemento.value = valor;
}

function solo_numeros(input) {
  return input.replace(/[^0-9]/g, "");
}

function solo_numeros_sin_cero(input) {
  // Verificamos si el primer carácter es un guión o un cero
  if (input.charAt(0) === "-" || input.charAt(0) === "0") {
    // Eliminar el primer carácter con substring
    input = input.substring(1);
    // Verificar si el segundo carácter es un guión
    if (input.charAt(0) === "-") {
      // Eliminar el segundo carácter
      input = input.substring(1);
    }
  }
  return input.replace(/[^0-9]/g, "");
}

function mayusculas_espacio(input) {
  // Elimina todos los caracteres que no sean letras, espacios o letras con acentos
  return input.replace(/[^a-zA-Z\sáéíóúÁÉÍÓÚüÜ]/gu, "");
}

function validarCorreo(correo) {
  // Expresión regular para validar el formato de correo electrónico
  var expresionRegular = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  // Validar el correo utilizando la expresión regular
  if (expresionRegular.test(correo) && correo.includes("@")) {
    return true; // El correo es válido
  } else {
    return false; // El correo es inválido
  }
}

function validar_contrasenha(password) {
  let contMay = 0; // Contador para las mayusculas
  let contMin = 0; // Contador para las minusculas
  let contNum = 0; // Contador para los numeros
  let contCar = 0; // Contador para los cartacteres especiales

  for (let i = 0; i < password.length; i++) {
    let c = password.charAt(i);

    if (c >= "A" && c <= "Z") {
      contMay += 1;
    }

    if (c >= "a" && c <= "z") {
      contMin += 1;
    }

    if (c >= "0" && c <= "9") {
      contNum += 1;
    }

    if (
      (c >= "!" && c <= "/") ||
      (c >= ":" && c <= "@") ||
      (c >= "[" && c <= "`") ||
      (c >= "{" && c <= "~")
    ) {
      contCar += 1;
    }
  }

  if (contMay < 2) {
    return false;
  } else if (contMin < 2) {
    return false;
  } else if (contNum < 2) {
    return false;
  } else if (contCar < 2) {
    return false;
  } else {
    return true;
  }
}

// Configuracion del Tooltip "Mensaje flotante" de Bootstrap

const tooltipTriggerList = document.querySelectorAll(
  '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
  (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);
