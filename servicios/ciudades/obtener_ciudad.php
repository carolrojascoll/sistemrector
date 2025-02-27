<?php

include('../conexion.php');

try {

    $stmt = $conexion->prepare("SELECT ciudad FROM ciudades WHERE id_ciudad = ?");
    $stmt->execute(array($_POST["id_ciudad"]));
    $resultado = $stmt->fetchAll();
    $ciudad = "";
    foreach ($resultado as $fila) {
        $ciudad = $fila["ciudad"];
    }

    $salida = array(
        "encontrado" => true,
        "ciudad" => $ciudad
    );
} catch (PDOException $e) {
    $salida = array(
        "encontrado" => false,
        "mensaje" => "Ocurrio un error. " . $e->getMessage()
    );
}

echo json_encode($salida);

$conexion = null;
