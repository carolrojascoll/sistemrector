<?php

include("../conexion.php");
$salida = array();

try {

    $stmt = $conexion->prepare("SELECT nro_expediente, anio_recepcion 
    FROM expedientes WHERE nro_expediente = ? AND anio_recepcion = ?");
    $stmt->execute(array($_POST["nro_expediente"], $_POST["anio_recepcion"]));
    if ($stmt->rowCount() > 0) {
        $salida["guardado"] = false;
        $salida["mensaje"] = "El numero de expediente ingresado ya existe.";
    } else {
        $stmt = $conexion->prepare("INSERT INTO expedientes 
        (nro_expediente, fecha_recepcion, anio_recepcion, id_area, id_objeto, id_dependencia, id_funcionario, observacion, estado)
        VALUES(?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array(
            $_POST["nro_expediente"],
            $_POST["fecha_recepcion"],
            $_POST["anio_recepcion"],
            $_POST["id_area"],
            $_POST["id_objeto"],
            $_POST["id_dependencia"],
            $_POST["id_funcionario"],
            $_POST["observacion"],
            $_POST["estado"],
        ));

        $salida["guardado"] = true;
        $salida["mensaje"] = "Documento Recepcionado.!!!";
    }
} catch (PDOException $e) {
    $salida["guardado"] = false;
    $salida["mensaje"] = "Ocurrio un error al guardar. " . $e->getMessage();
}

echo json_encode($salida);
