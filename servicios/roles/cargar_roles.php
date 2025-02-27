<?php

include ("../conexion.php");

try {

    $stmt = $conexion->prepare("SELECT * FROM roles ORDER BY rol");
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $salida = array();
    foreach($resultado as $datos) {
        $salida [] = array(
            "id_rol" => $datos["id_rol"],
            "rol" => $datos["rol"]
        );
    }

} catch(PDOException $e) {
    echo json_encode("Ocurrio un error al cargar las ciudades. " . $e->getMessage());
}

echo json_encode($salida);