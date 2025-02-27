<?php

include("../conexion.php");

try {

    $dependencia_comparar = '';
    $modify = false;

    $stmt = $conexion->prepare("SELECT dependencia FROM dependencias WHERE id_dependencia = ?");
    $stmt->execute(array($_POST["id_dependencia"]));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultado as $datos) {
        $dependencia_comparar = $datos["dependencia"];
    }

    if ($dependencia_comparar == $_POST["dependencia"]) {
        $modify = true;
    } else {
        $stmt = $conexion->prepare("SELECT dependencia FROM dependencias WHERE dependencia = ?");
        $stmt->execute(array($_POST["dependencia"]));
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resultado == true) {
            $modify = false;
            $salida = array(
                'existe' => true,
                'mensaje' => 'La dependencia ingresada ya existe.'
            );
        } else {
            $modify = true;
        }
    }

    if ($modify === true) {
        $stmt = $conexion->prepare("UPDATE dependencias SET dependencia = ? WHERE id_dependencia = ?");
        $stmt->execute(array(
            $_POST["dependencia"],
            $_POST["id_dependencia"]
        ));
        $salida = array(
            'modificado' => true,
            'mensaje' => 'Registro Modificado.'
        );
    }
} catch (PDOException $e) {
    $salida = array(
        'modificado' => false,
        'mensaje' => 'Ocurrio un error al modificar. ' . $e->getMessage()
    );
}

echo json_encode($salida);

$conexion = null;
