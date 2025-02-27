<?php

include("../conexion.php");

try {

    $ci_comparar = "";
    $modify = false;

    $stmt_ci = $conexion->prepare("SELECT ci FROM funcionarios WHERE id_funcionario = ?");
    $stmt_ci->execute(array($_POST["id_funcionario"]));
    $resultado = $stmt_ci->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($resultado as $dato) {
        $ci_comparar = $dato["ci"];
    }

    if ($ci_comparar == $_POST["ci"]) {
        $modify = true;
    } else {

        $stmt_ci = $conexion->prepare("SELECT ci FROM funcionarios WHERE ci = ?");
        $stmt_ci->execute(array($_POST["ci"]));
        if ($stmt_ci->rowCount() > 0) {
            $modify = false;
            $salida = array(
                "existe" => true,
                "mensaje" => "El C.I ingresado pertenece a un funcionario, ingrese otro C.I.!!!"
            );
        } else {
            $modify = true;
        }
    }

    if ($modify === true) {

        $stmt = $conexion->prepare("UPDATE funcionarios SET
        ci = ?, nombre = ?, apellido = ?, id_ciudad = ?, direccion = ?, telefono = ?
        WHERE id_funcionario = ?");
        $stmt->execute(array(
            $_POST["ci"],
            $_POST["nombre"],
            $_POST["apellido"],
            $_POST["id_ciudad"],
            $_POST["direccion"],
            $_POST["telefono"],
            $_POST["id_funcionario"],
        ));

        $salida = array(
            "modificado" => true,
            "mensaje" => "Datos Actualizados.!!!"
        );
    }
} catch (PDOException $e) {
    $salida = array(
        "modificado" => false,
        "mensaje" => "Ocurrio un error al modificar.!!!" . $e->getMessage()
    );
}

echo json_encode($salida);
