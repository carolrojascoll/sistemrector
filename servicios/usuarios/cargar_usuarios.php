<?php

include("../conexion.php");

try {

    $stmt = $conexion->prepare(
        "SELECT u.id_usuario, u.correo, r.rol, CONCAT(f.nombre,' ',f.apellido) as funcionario,
        u.foto, u.usuario FROM usuarios u JOIN roles r
        ON u.id_rol = r.id_rol JOIN funcionarios f
        ON u.id_funcionario = f.id_funcionario"
    );
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $salida = [];
    foreach ($resultado as $datos) {
        $salida[] = array(
            "id_usuario" => $datos["id_usuario"],
            "funcionario" => $datos["funcionario"],
            "correo" => $datos["correo"],
            "rol" => $datos["rol"],
            "foto" => $datos["foto"],
            "usuario" => $datos["usuario"],
        );
    }
} catch (PDOException $e) {
    echo "Ocurrio un error al cargar los usuarios. " . $e->getMessage();
}

echo json_encode($salida);
