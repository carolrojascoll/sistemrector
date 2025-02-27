<?php

include("../conexion.php");

try {

    $stmt = $conexion->prepare("DELETE FROM funcionarios WHERE id_funcionario = ?");
    $stmt->execute(array($_POST["id_funcionario"]));
    $salida = array(
        "eliminado" => true,
        "mensaje" => "Registro Eliminado.!!!"
    );
} catch(PDOException $e) {
    if($e->getCode() == 23000) {
        $salida = array(
            "eliminado" => false,
            "mensaje" => "El registro esta asociado a otros datos, no se podra elininar.!!!"
        );  
    } else {
        $salida = array(
            "eliminado" => false,
            "mensaje" => "Ocurrio un error al eliminar. " .$e->getMessage()
        );
    }
}

echo json_encode($salida);