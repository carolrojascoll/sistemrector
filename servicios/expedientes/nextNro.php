<?php

include("../conexion.php");


try {

    $nro = 0;
    $stmt = $conexion->prepare("SELECT MAX(nro_expediente) as nro
    FROM expedientes WHERE anio_recepcion = YEAR(NOW())");
    $stmt->execute();
    $resultado = $stmt->fetch();
    if($resultado) {
        $nro = $resultado["nro"] + 1;
    } else {
        $nro = 1;
    }

} catch(PDOException $e) {

    array("error" => "Ocurrio un error: " . $e->getMessage());

}

echo json_encode(array("nro" => $nro));