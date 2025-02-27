<?php

include("../conexion.php");

try {
    $codigo_comparar = '';
    $objeto_comparar = '';
    $modify = false;
    $existe = false;

    // Obtiene los valores actuales de código y objeto
    $stmt = $conexion->prepare("SELECT codigo, objeto FROM objetos WHERE id_objeto = ?");
    $stmt->execute(array($_POST["id_objeto"]));
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $codigo_comparar = $resultado["codigo"];
        $objeto_comparar = $resultado["objeto"];
    }

    // Verifica si los valores proporcionados son iguales a los actuales
    if ($codigo_comparar == $_POST["codigo"] && $objeto_comparar == $_POST["objeto"]) {
        $modify = true;
    } else {
        // Verifica individualmente si el código existe
        if ($codigo_comparar != $_POST["codigo"]) {
            $stmt = $conexion->prepare("SELECT 1 FROM objetos WHERE codigo = ?");
            $stmt->execute(array($_POST["codigo"]));
            if ($stmt->fetch()) {
                $salida = array(
                    'existe' => true,
                    'mensaje' => 'El código ingresado ya existe.',
                    'focus' => '#codigo'
                );
                $existe = true;
            }
        }

        // Verifica individualmente si el objeto existe
        if (!$existe && $objeto_comparar != $_POST["objeto"]) {
            $stmt = $conexion->prepare("SELECT 1 FROM objetos WHERE objeto = ?");
            $stmt->execute(array($_POST["objeto"]));
            if ($stmt->fetch()) {
                $salida = array(
                    'existe' => true,
                    'mensaje' => 'El objeto ingresado ya existe.',
                    'focus' => '#objeto'
                );
                $existe = true;
            }
        }

        // Si ninguno de los valores existe, permite la modificación
        if (!$existe) {
            $modify = true;
        }
    }

    // Realiza la modificación si está permitido
    if ($modify === true) {
        $stmt = $conexion->prepare("UPDATE objetos SET codigo = ?, objeto = ? WHERE id_objeto = ?");
        $stmt->execute(array(
            $_POST["codigo"],
            $_POST["objeto"],
            $_POST["id_objeto"]
        ));
        $salida = array(
            'modificado' => true,
            'mensaje' => 'Registro Modificado.'
        );
    }
} catch (PDOException $e) {
    $salida = array(
        'modificado' => false,
        'mensaje' => 'Ocurrio un error al modificar. ' . $e->getMessage()
    );
}

echo json_encode($salida);

$conexion = null;
?>
