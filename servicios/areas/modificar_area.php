<?php

include("../conexion.php");

try {

    $area_comparar = '';
    $modify = false;

    $stmt = $conexion->prepare("SELECT area FROM areas WHERE id_area = ?");
    $stmt->execute(array($_POST["id_area"]));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultado as $datos) {
        $$area_comparar = $datos["area"];
    }

    if ($$area_comparar == $_POST["area"]) {
        $modify = true;
    } else {
        
        $stmt = $conexion->prepare("SELECT area FROM areas WHERE area = ?");
        $stmt->execute(array($_POST["area"]));
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resultado == true) {
            $modify = false;
            $salida = array(
                'existe' => true,
                'mensaje' => 'El área ingresada ya existe.'
            );
        } else {
            $modify = true;
        }
    }

    if ($modify === true) {
        $stmt = $conexion->prepare("UPDATE areas SET area = ? WHERE id_area = ?");
        $stmt->execute(array(
            $_POST["area"],
            $_POST["id_area"]
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
