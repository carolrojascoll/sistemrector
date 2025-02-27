<?php

include("../conexion.php");

try {

    $rol_comparar = '';
    $modify = false;

    $stmt = $conexion->prepare("SELECT rol FROM roles WHERE id_rol = ?");
    $stmt->execute(array($_POST["id_rol"]));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultado as $datos) {
        $rol_comparar = $datos["rol"];
    }

    if ($rol_comparar == $_POST["rol"]) {
        $modify = true;
    } else {
        $stmt = $conexion->prepare("SELECT rol FROM roles WHERE rol = ?");
        $stmt->execute(array($_POST["rol"]));
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resultado == true) {
            $modify = false;
            $salida = array(
                'existe' => true,
                'mensaje' => 'El rol ingresado ya existe.'
            );
        } else {
            $modify = true;
        }
    }

    if ($modify === true) {
        $stmt = $conexion->prepare("UPDATE roles SET rol = ? WHERE id_rol = ?");
        $stmt->execute(array(
            $_POST["rol"],
            $_POST["id_rol"]
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
