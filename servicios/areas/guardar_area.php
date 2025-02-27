<?php

include("../conexion.php");

try {

    $stmt = $conexion->prepare("SELECT area FROM areas WHERE area  = ?");
    $stmt->execute(array($_POST["area"]));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultado == true) {
        $salida = array(
            'existe' => true,
            'mensaje' => 'El área ingresada ya existe.'
        );
    } else {
        $stmt = $conexion->prepare("INSERT INTO areas (area) VALUES (?);");
        $stmt->execute(array($_POST["area"]));
        $salida = array(
            'guardado' => true,
            'mensaje' => 'Registro Insertado.'
        );
    }
} catch (PDOException $e) {
    $salida = array(
        'guardado' => false,
        'mensaje' => 'Ocurrio un error al guadar. ' .$e->getMessage()
    );
}

echo json_encode($salida);

$conexion = null;

?>