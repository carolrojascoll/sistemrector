<?php

include("../conexion.php");

try {

    $stmt = $conexion->prepare("SELECT f.id_funcionario, CONCAT(f.nombre, ' ', f.apellido) as nombre
    FROM usuarios u JOIN funcionarios f ON u.id_funcionario = f.id_funcionario 
    WHERE f.ci = ?");
    $stmt->execute(array($_POST["ci"]));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $salida = array();
    if ($stmt->rowCount() > 0) {
        $salida["tiene"] = true;
        $salida["mensaje"] = "El ci ingresado ya tiene una cuenta de usuario.!!!";
    } else {
        $stmt = $conexion->prepare(
            "SELECT id_funcionario, CONCAT(nombre, ' ', apellido ) as nombre 
            FROM funcionarios WHERE ci = ?"
        );
        $stmt->execute(array($_POST["ci"]));
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultado as $datos) {
            $salida["tiene"] = false;
            $salida["id_funcionario"] = $datos["id_funcionario"];
            $salida["nombre"] = $datos["nombre"];
        }
    }
} catch (PDOException $e) {
    $salida["error"] = false;
    $salida["mensaje"] = "Ocurrio un error. " . $e->getMessage();
}

echo json_encode($salida);
