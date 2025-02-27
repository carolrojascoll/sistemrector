<?php

include('../conexion.php');

try {

    $stmt = $conexion->prepare("SELECT rol FROM roles WHERE id_rol = ?");
    $stmt->execute(array($_POST["id_rol"]));
    $resultado = $stmt->fetchAll();
    $rol = "";
    foreach ($resultado as $fila) {
        $rol = $fila["rol"];
    }

    $salida = array(
        "encontrado" => true,
        "rol" => $rol
    );
} catch (PDOException $e) {
    $salida = array(
        "encontrado" => false,
        "mensaje" => "Ocurrio un error. " . $e->getMessage()
    );
}

echo json_encode($salida);

$conexion = null;
