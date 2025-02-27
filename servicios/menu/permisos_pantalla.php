<?php

include("../conexion.php");

try {

    $stmt = $conexion->prepare("SELECT pa.pantalla, p.alta, p.baja, p.modificacion, p.leer
    FROM permisos p INNER JOIN usuarios u
    ON p.id_usuario = u.id_usuario INNER JOIN pantallas pa
    ON p.id_pantalla = pa.id_pantalla 
    WHERE u.usuario = ? AND pa.pantalla = ?");
    $stmt->execute(array(
        $_POST["usuario"],
        $_POST["pantalla"],
    ));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $salida = array();
    foreach($resultado as $datos) {
        $salida[] = array(
            "alta" => $datos["alta"],
            "baja" => $datos["baja"],
            "modificacion" => $datos["modificacion"],
            "leer" => $datos["leer"],
        );
    }

} catch(PDOException $e) {
    echo "Ocurrio un error al obtener los permisos de la pantalla. " . $e->getMessage();
}

echo json_encode($salida);