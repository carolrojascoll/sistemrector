<?php

include("../conexion.php");

try {

    $ciudad_comparar = '';
    $modify = false;

    $stmt = $conexion->prepare("SELECT ciudad FROM ciudades WHERE id_ciudad = ?");
    $stmt->execute(array($_POST["id_ciudad"]));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultado as $datos) {
        $ciudad_comparar = $datos["ciudad"];
    }

    if ($ciudad_comparar == $_POST["ciudad"]) {
        $modify = true;
    } else {
        $stmt = $conexion->prepare("SELECT ciudad FROM ciudades WHERE ciudad = ?");
        $stmt->execute(array($_POST["ciudad"]));
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resultado == true) {
            $modify = false;
            $salida = array(
                'existe' => true,
                'mensaje' => 'La ciudad ingresada ya existe.'
            );
        } else {
            $modify = true;
        }
    }

    if ($modify === true) {
        $stmt = $conexion->prepare("UPDATE ciudades SET ciudad = ? WHERE id_ciudad = ?");
        $stmt->execute(array(
            $_POST["ciudad"],
            $_POST["id_ciudad"]
        ));
        $salida = array(
            'modificado' => true,
            'mensaje' => 'Registro Modificado.'
        );
    }
} catch (PDOException $e) {
    $salida = array(
        'modificado' => false,
        'mensaje' => 'Ocurrio un error al guadar. ' . $e->getMessage()
    );
}

echo json_encode($salida);

$conexion = null;
