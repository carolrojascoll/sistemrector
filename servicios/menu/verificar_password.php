<?php

include("../conexion.php");
$password = "";
$salida = array();
try {
    
    $stmt = $conexion->prepare("SELECT password FROM usuarios WHERE usuario = ?");
    $stmt->execute(array($_POST["usuario"]));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultado as $dato) {
        $password = $dato["password"];
    }
    $salida["password"] = $password;

} catch(PDOException $e) {
    $password = "Ocurrio un error al verificar la contraseña.";
}

echo json_encode($salida);