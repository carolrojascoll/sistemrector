<?php

include("../conexion.php");

try {

    $stmt = $conexion->prepare("SELECT dependencia FROM dependencias WHERE dependencia  = ?");
    $stmt->execute(array($_POST["dependencia"]));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultado == true) {
        $salida = array(
            'existe' => true,
            'mensaje' => 'La dependencia ingresada ya existe.'
        );
    } else {
        $stmt = $conexion->prepare("INSERT INTO dependencias (dependencia) VALUES (?);");
        $stmt->execute(array($_POST["dependencia"]));
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