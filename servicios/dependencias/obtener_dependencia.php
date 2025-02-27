<?php

include('../conexion.php');

try {

    $stmt = $conexion->prepare("SELECT dependencia FROM dependencias WHERE id_dependencia = ?");
    $stmt->execute(array($_POST["id_dependencia"]));
    $resultado = $stmt->fetchAll();
    $dependencia = "";
    foreach ($resultado as $fila) {
        $dependencia = $fila["dependencia"];
    }

    $salida = array(
        "encontrado" => true,
        "dependencia" => $dependencia
    );
} catch (PDOException $e) {
    $salida = array(
        "encontrado" => false,
        "mensaje" => "Ocurrio un error. " . $e->getMessage()
    );
}

echo json_encode($salida);

$conexion = null;
