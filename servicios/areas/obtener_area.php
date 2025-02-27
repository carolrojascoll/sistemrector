<?php

include('../conexion.php');

try {

    $stmt = $conexion->prepare("SELECT area FROM areas WHERE id_area = ?");
    $stmt->execute(array($_POST["id_area"]));
    $resultado = $stmt->fetchAll();
    $area = "";
    foreach ($resultado as $fila) {
        $area = $fila["area"];
    }

    $salida = array(
        "encontrado" => true,
        "area" => $area
    );
} catch (PDOException $e) {
    $salida = array(
        "encontrado" => false,
        "mensaje" => "Ocurrio un error. " . $e->getMessage()
    );
}

echo json_encode($salida);

$conexion = null;
