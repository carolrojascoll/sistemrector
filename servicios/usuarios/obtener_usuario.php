<?php

include("../conexion.php");

try {

    $stmt = $conexion->prepare(
    "SELECT u.correo, r.id_rol, f.id_funcionario, f.ci,
    CONCAT(f.nombre,' ',f.apellido) as funcionario,
    u.usuario, u.password
    FROM usuarios u JOIN roles r 
    ON u.id_rol = r.id_rol JOIN funcionarios f
    ON u.id_funcionario = f.id_funcionario
    WHERE u.id_usuario =  ?");
    $stmt->execute(array($_POST["id_usuario"]));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $salida = array();
    foreach($resultado as $datos) {
        $salida["encontrado"] = true;
        $salida["ci"] = $datos["ci"];
        $salida["funcionario"] = $datos["funcionario"];
        $salida["correo"] = $datos["correo"];
        $salida["id_rol"] = $datos["id_rol"];
        $salida["id_funcionario"] = $datos["id_funcionario"];
        $salida["usuario"] = $datos["usuario"];
        $salida["password"] = $datos["password"];
    }
} catch (PDOException $e) {
    $salida["encontrado"] = false;
    $salida["mensaje"] = "Ocurrio un error al obtener los datos del usuario.!!!". $e->getMessage();
}

echo json_encode($salida);