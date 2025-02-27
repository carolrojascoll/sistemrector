<?php

include ("../conexion.php");

try {

    $stmt = $conexion->prepare("SELECT * FROM areas ORDER BY id_area");
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $salida = array();
    foreach($resultado as $datos) {
        $salida [] = array(
            "id_area" => $datos["id_area"],
            "area" => $datos["area"]
        );
    }

} catch(PDOException $e) {
    echo json_encode("Ocurrio un error al cargar las áreas. " . $e->getMessage());
}

echo json_encode($salida);