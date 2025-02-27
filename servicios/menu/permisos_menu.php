<?php

include("../conexion.php");

try {

    $stmt = $conexion->prepare("SELECT pa.pantalla, p.leer
    FROM permisos p INNER JOIN usuarios u
    ON p.id_usuario = u.id_usuario INNER JOIN pantallas pa
    ON p.id_pantalla = pa.id_pantalla 
    WHERE u.usuario = ?");
    $stmt->execute(array($_POST["usuario"]));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $salida = array();
    foreach ($resultado as $datos) {
        $salida[] = array(
            "pantalla" => $datos["pantalla"],
            "leer" => $datos["leer"],
        );
    }
} catch (PDOException $e) {
    echo "Ocurrio un error al obtener los permisos. " . $e->getMessage();
}

echo json_encode($salida);
