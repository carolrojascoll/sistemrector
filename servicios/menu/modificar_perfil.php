<?php

include("../conexion.php");

try {

    $stmt = $conexion->prepare("UPDATE usuarios SET foto = ? WHERE usuario = ?");
    $imagen = $_FILES['foto']['tmp_name'];
    $extension = explode('.', $_FILES['foto']['name']);
    $nombre = $_POST['user'] . '.' . $extension[1];
    $direccion = '../../img/usuarios/';
    $ruta = $direccion . $nombre;
    move_uploaded_file($imagen, $ruta);
    $stmt->execute(array(
        $nombre,
        $_POST["user"]
    ));
    $salida = array(
        'modificado' => true,
        'mensaje' => 'Foto de perfil modificada.'
    );
} catch (PDOException $e) {
    $salida = array(
        'modificado' => false,
        'mensaje' => 'Ocurrio un error al modificar la foto. ' . $e->getMessage()
    );
}

echo json_encode($salida);
