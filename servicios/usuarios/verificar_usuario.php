<?php

include("../conexion.php");

try {

    $stmt = $conexion->prepare("SELECT usuario FROM usuarios WHERE usuario = ?");
    $stmt->execute(array($_POST["usuario"]));
    if($stmt->rowCount() > 0) {
        $salida = array(
            "existe" => true,
            "mensaje" => "Nombre de usuario no disponible."
        );
    } else {
        $salida = array(
            "existe" => false,
            "mensaje" => ""
        );
    }
} catch(PDOException $e) {

    $salida = array(
        "error" => true,
        "mensaje" => "Ocurio un error. " .$e->getMessage()
    );
}

echo json_encode($salida);