<?php

include("../conexion.php");

try {

    $stmt = $conexion->prepare("SELECT ciudad FROM ciudades WHERE ciudad = :ciudad");
    $stmt->execute(array(':ciudad' => $_POST["ciudad"]));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultado == true) {
        $salida = array(
            'existe' => true,
            'mensaje' => 'La ciudad ingresada ya existe.'
        );
    } else {
        $stmt = $conexion->prepare("INSERT INTO ciudades (ciudad) VALUES (:ciudad);");
        $stmt->execute(array(':ciudad' => $_POST["ciudad"]));
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