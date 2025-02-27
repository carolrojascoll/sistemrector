<?php

include("../conexion.php");

try {

    $anterior = '';
    $stmt = $conexion->prepare("SELECT password FROM usuarios WHERE usuario = ?");
    $stmt->execute(array($_POST["usuario"]));
    $resultado = $stmt->fetchAll();
    foreach ($resultado as $dato) {
        $anterior = $dato["password"];
    }
    $salida = array();

    if ($anterior != $_POST["anterior"]) {
        $salida["coincide"] = false;
        $salida["mensaje"] = "Contraseña Incorrecta.";
    } else {

        $stmt = $conexion->prepare("UPDATE usuarios SET password = ? WHERE usuario = ?");
        $stmt->execute(array(
            $_POST["nueva"],
            $_POST["usuario"]
        ));
        $salida["modificado"] = true;
        $salida["mensaje"] = "Contraseña Modificada. Por favor vuelva a iniciar sesión.";
    }
} catch (PDOException $e) {

    $salida["modificado"] = false;
    $salida["mensaje"] = "Ocurrio un error. " . $e->getMessage();
}

echo json_encode($salida);
