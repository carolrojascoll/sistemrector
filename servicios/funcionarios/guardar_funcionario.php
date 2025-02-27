<?php

include("../conexion.php");

try {

    $stmt_ci = $conexion->prepare("SELECT ci FROM funcionarios WHERE ci = ?");
    $stmt_ci->execute(array($_POST["ci"]));

    if ($stmt_ci->rowCount() > 0) {
        $salida = array(
            "existe" => true,
            "mensaje" => "El C.I ingresado pertenece a un funcionario, ingrese otro C.I.!!!"
        );
    } else {
        
        $stmt = $conexion->prepare("INSERT INTO funcionarios 
        (ci, nombre, apellido, id_ciudad, direccion, telefono, id_dependencia) VALUES(?,?,?,?,?,?,?)");
        $stmt->execute(array(
            $_POST["ci"],
            $_POST["nombre"],
            $_POST["apellido"],
            $_POST["id_ciudad"],
            $_POST["direccion"],
            $_POST["telefono"],
            $_POST["id_dependencia"],
        ));

        $salida = array(
            "guardado" => true,
            "mensaje" => "Registro Insertado.!!!"
        );
    }
} catch (PDOException $e) {
    $salida = array(
        "guardado" => false,
        "mensaje" => "Ocurrio un error al guardar. " . $e->getMessage()
    );
}

echo json_encode($salida);
