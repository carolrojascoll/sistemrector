<?php

include("../conexion.php");

try {

    $stmt = $conexion->prepare("SELECT nro_expediente, 
    DATE_FORMAT(fecha_recepcion, '%d/%m') as fecha_recepcion,
    anio_recepcion, id_area, id_objeto, id_dependencia, observacion
    FROM expedientes
    WHERE id_expediente = ?");
    $stmt->execute(array($_POST["id_expediente"]));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $salida = array();

    foreach ($resultado as $datos) {
        $salida["encontrado"] = true;
        $salida["nro"] = $datos["nro_expediente"];
        $salida["fecha"] = $datos["fecha_recepcion"];
        $salida["anhio"] = $datos["anio_recepcion"];
        $salida["area"] = $datos["id_area"];
        $salida["objeto"] = $datos["id_objeto"];
        $salida["dependencia"] = $datos["id_dependencia"];
        $salida["observacion"] = $datos["observacion"];
    }
} catch (PDOException $e) {
    $salida["encontrado"] = false;
    $salida["error"] = "Ocurrio un error al obtener los datos. " . $e->getMessage();
}

echo json_encode($salida);
