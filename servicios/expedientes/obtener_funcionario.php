<?php

include("../conexion.php");

try {

    $password = "";
    $id_funcionario = "";
    $stmt = $conexion->prepare("SELECT id_funcionario, password FROM usuarios WHERE usuario = ?");
    $stmt->execute(array($_POST["usuario"]));   
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultado as $dato) {
        $id_funcionario = $dato["id_funcionario"];
        $password = $dato["password"];
    }
    $salida = array();

    if($password == $_POST["password"]){
        $salida["confirmado"] = true;
        $salida["id_funcionario"] = $id_funcionario;
        $salida["mensaje"] = "Contraseña Correcta.!!!";
    } else {
        $salida["confirmado"] = false;
        $salida["mensaje"] = "Contraseña Incorrecta.!!!";
    }
    
} catch (PDOException $e) {
    $salida = array(
        "confirmado" => false,
        "mensaje" => "Ocurrio un error en la verficación de datos. " . $e->getMessage()
    );
}

echo json_encode($salida);