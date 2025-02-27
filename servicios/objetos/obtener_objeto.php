<?php

include('../conexion.php');

try {

    $stmt = $conexion->prepare("SELECT codigo, objeto FROM objetos WHERE id_objeto = ?");
    $stmt->execute(array($_POST["id_objeto"]));
    $resultado = $stmt->fetchAll();
    $codigo = "";
    $objeto = "";
    foreach ($resultado as $fila) {
        $codigo = $fila["codigo"];
        $objeto = $fila["objeto"];
    }

    $salida = array(
        "encontrado" => true,
        "codigo" => $codigo,
        "objeto" => $objeto,
    );
} catch (PDOException $e) {
    $salida = array(
        "encontrado" => false,
        "mensaje" => "Ocurrio un error. " . $e->getMessage()
    );
}

echo json_encode($salida);

$conexion = null;
