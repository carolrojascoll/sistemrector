<?php

include ("../conexion.php");

try {

    $stmt = $conexion->prepare("SELECT id_objeto FROM objetos WHERE codigo = ?");
    $stmt->execute(array($_POST["codigo"]));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $salida = array();
    foreach($resultado as $dato) {
        $salida [] = array(
            "encontrado" => true,
            "id_objeto" => $dato["id_objeto"]
        );
    }

} catch(PDOException $e) {

    $salida [] = array(
        "encontrado" => false,
        "error" => "Ocurrio un error. " . $e->getMessage()
    );
}

echo json_encode($salida);