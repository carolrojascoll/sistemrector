<?php

include ("../conexion.php");

try {

    $stmt = $conexion->prepare("SELECT * FROM dependencias ORDER BY dependencia");
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $salida = array();
    foreach($resultado as $datos) {
        $salida [] = array(
            "id_dependencia" => $datos["id_dependencia"],
            "dependencia" => $datos["dependencia"]
        );
    }

} catch(PDOException $e) {
    echo json_encode("Ocurrio un error al cargar las dependencias. " . $e->getMessage());
}

echo json_encode($salida);