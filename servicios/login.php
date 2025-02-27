<?php

    include("conexion.php");

    try {

        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ? AND password = ?"); 
        $stmt->execute(array(
            $_POST["usuario"],
            $_POST["password"]
        ));
        if($stmt->rowCount() > 0) {
            $salida = array("acceso" => true);
        } else {
            $salida = array("acceso" => false);
        }
    } catch(PDOException $e) {
        $salida = array("error" => "Ocurrio un error. " . $e->getMessage());
    }

    echo json_encode($salida);

?>