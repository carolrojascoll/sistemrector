<?php

include("../conexion.php");

try {

    $cant = 0;
    $stmt_count = $conexion->prepare("SELECT COUNT(*) as cantidad FROM usuarios");
    $stmt_count->execute();
    $resultado = $stmt_count->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultado as $dato) {
        $cant = $dato["cantidad"];
    }
    
    if($cant > 1) {
        $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
        $stmt->execute(array($_POST["id_usuario"]));
        $salida = array(
            "eliminado" => true,
            "mensaje" => "Registro eliminado.!!!"
        );
    } else {
        $salida = array(
            "eliminado" => false,
            "mensaje" => "El sistema no puede quedarse sin usuarios."
        );
    }

} catch (PDOException $e) {

    if ($e->getCode() == 23000) {
        $salida = array(
            "eliminado" => false,
            "mensaje" => "El registro esta relacionado con otros datos, no se podra eliminar."
        );
    } else {
        $salida = array(
            "eliminado" => false,
            "mensaje" => "Ocurrio un error al eliminar." .$e->getMessage()
        );
    }
}

echo json_encode($salida);