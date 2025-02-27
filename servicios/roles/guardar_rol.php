<?php

include("../conexion.php");

try {

    $stmt = $conexion->prepare("SELECT rol FROM roles WHERE rol = ?");
    $stmt->execute(array($_POST["rol"]));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultado == true) {
        $salida = array(
            'existe' => true,
            'mensaje' => 'El rol ingresado ya existe.'
        );
    } else {
        $stmt = $conexion->prepare("INSERT INTO roles (rol) VALUES (?);");
        $stmt->execute(array($_POST["rol"]));
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