<?php

include("../conexion.php");

try {

    $stmt = $conexion->prepare("SELECT * FROM funcionarios WHERE id_funcionario = ?");
    $stmt->execute(array($_POST["id_funcionario"]));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $salida = array();
    foreach ($resultado as $datos) {
            $salida["ci"] = $datos["ci"];
            $salida["nombre"] = $datos["nombre"];
            $salida["apellido"] = $datos["apellido"];
            $salida["id_ciudad"] = $datos["id_ciudad"];
            $salida["direccion"] = $datos["direccion"];
            $salida["telefono"] = $datos["telefono"];
            $salida["id_dependencia"] = $datos["id_dependencia"];
            $salida["encontrado"] = true;
        
    }
} catch (PDOException $e) {
    $salida = array(
        "encontrado" => false,
        "mensaje" => "Ocurrio un error en la obtenció de datos. " . $e->getMessage()
    );
}

echo json_encode($salida);