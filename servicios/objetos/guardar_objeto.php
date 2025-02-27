<?php

include("../conexion.php");

try {

    $stmt = $conexion->prepare("SELECT codigo FROM objetos WHERE codigo  = ?");
    $stmt->execute(array($_POST["codigo"]));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultado == true) {
        $salida = array(
            'existe' => true,
            'mensaje' => 'El codigo ingresado ya existe.',
            'focus' => "#codigo",
        );
    } else {
        $stmt = $conexion->prepare("SELECT objeto FROM objetos WHERE objeto  = ?");
        $stmt->execute(array($_POST["objeto"]));
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resultado == true) {
            $salida = array(
                'existe' => true,
                'mensaje' => 'El codigo ingresado ya existe.',
                'focus' => "#objeto",
            );
        } else {
            $stmt = $conexion->prepare("INSERT INTO objetos (codigo, objeto) VALUES (?,?);");
            $stmt->execute(array(
                $_POST["codigo"],
                $_POST["objeto"],
            ));
            $salida = array(
                'guardado' => true,
                'mensaje' => 'Registro Insertado.'
            );
        }
    }
} catch (PDOException $e) {
    $salida = array(
        'guardado' => false,
        'mensaje' => 'Ocurrio un error al guardar. ' . $e->getMessage()
    );
}

echo json_encode($salida);

$conexion = null;
