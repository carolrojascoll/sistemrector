<?php

include("../conexion.php");

try {
    $modify = false;
    $nro_expediente = 0;
    $anhio = 0;

    // Consulta para obtener el número de expediente y año actual
    $stmt = $conexion->prepare("SELECT nro_expediente, anio_recepcion FROM expedientes WHERE id_expediente = ?");
    $stmt->execute(array($_POST["id_expediente"]));
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $nro_expediente = $resultado["nro_expediente"];
        $anhio = $resultado["anio_recepcion"];
    }

    // Verifica si el número de expediente y el año no han cambiado
    if ($nro_expediente == $_POST["nro_expediente"] && $anhio == $_POST["anhio"]) {
        $modify = true;
    } else {
        // Verifica si el número de expediente y el año ya existen juntos en otro registro
        $stmt = $conexion->prepare("SELECT nro_expediente, anio_recepcion 
        FROM expedientes WHERE nro_expediente = ? AND anio_recepcion = ?");
        $stmt->execute(array($_POST["nro_expediente"], $_POST["anhio"]));
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($resultado) {
            $modify = false;
            $salida = array(
                'existe' => true,
                'mensaje' => 'El número de expediente ya existe.'
            );
        } else {
            $modify = true;
        }
    }

    if ($modify == true) {
        $stmt = $conexion->prepare("UPDATE expedientes 
        SET nro_expediente = ?, anio_recepcion = ?,
        id_area = ?, id_objeto = ?, id_dependencia = ?, observacion = ?
        WHERE id_expediente = ?");
        $stmt->execute(array(
            $_POST["nro_expediente"],
            $_POST["anhio"],
            $_POST["area"],
            $_POST["objeto"],
            $_POST["dependencia"],
            $_POST["observacion"],
            $_POST["id_expediente"]
        ));
        
        $salida = array(
            'modificado' => true,
            'mensaje' => 'Modificación Exitosa.'
        );
    }
} catch (PDOException $e) {
    $salida = array(
        'modificado' => false,
        'mensaje' => 'Ocurrió un error al modificar: ' . $e->getMessage()
    );
} catch (Exception $e) {
    $salida = array(
        'modificado' => false,
        'mensaje' => $e->getMessage()
    );
}

echo json_encode($salida);

?>
