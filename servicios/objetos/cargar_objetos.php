<?php

include ("../conexion.php");

try {

    $stmt = $conexion->prepare("SELECT * FROM objetos");
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $salida = array();
    foreach($resultado as $datos) {
        $salida [] = array(
            "id_objeto" => $datos["id_objeto"],
            "codigo" => $datos["codigo"],
            "objeto" => $datos["objeto"]
        );
    }

} catch(PDOException $e) {
    echo json_encode("Ocurrio un error al cargar las dependencias. " . $e->getMessage());
}

echo json_encode($salida);