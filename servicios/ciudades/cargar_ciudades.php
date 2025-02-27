<?php

include ("../conexion.php");

try {

    $stmt = $conexion->prepare("SELECT * FROM ciudades ORDER BY ciudad");
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $salida = array();
    foreach($resultado as $datos) {
        $salida [] = array(
            "id_ciudad" => $datos["id_ciudad"],
            "ciudad" => $datos["ciudad"]
        );
    }

} catch(PDOException $e) {
    echo json_encode("Ocurrio un error al cargar las ciudades. " . $e->getMessage());
}

echo json_encode($salida);