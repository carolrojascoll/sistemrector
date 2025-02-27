<?php

include("../conexion.php");

try {

    $sql = "SELECT e.id_expediente, e.nro_expediente, DATE_FORMAT(e.fecha_recepcion, '%d/%m') as fecha,
    anio_recepcion as anhio, a.area as remitente, o.objeto, d.dependencia, 
    CONCAT(f.nombre,' ', f.apellido) as funcionario, e.observacion, e.estado
    FROM expedientes e 
    JOIN areas a ON e.id_area = a.id_area 
    JOIN objetos o ON e.id_objeto = o.id_objeto 
    JOIN dependencias d ON e.id_dependencia = d.id_dependencia 
    JOIN funcionarios f ON e.id_funcionario = f.id_funcionario";

    // Si el valor obtenido hace referencia a una dependencia realizamos la consulta por el nombre de esa dependencia
    if ($_POST["dependencia"] != "todo") {
        $sql = $sql . " WHERE d.dependencia = ?";
    }

    $stmt = $conexion->prepare($sql);

    //        WHERE d.id_dependencia = ?

    // Si el valor obtenido hace referencia a una dependencia, enviamos el valor dentro de la consulta
    if ($_POST["dependencia"] != "todo") {
        $stmt->execute(array($_POST["dependencia"]));
    } else {
        // En caso contrario se ejecuta la consulta directamente.    
        $stmt->execute();
    }

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $salida = array();
    foreach ($resultado as $datos) {
        $salida[] = array(
            "cargado" => true,
            "id_expediente" => $datos["id_expediente"],
            "nro_expediente" => $datos["nro_expediente"],
            "fecha" => $datos["fecha"],
            "remitente" => $datos["remitente"],
            "anhio" => $datos["anhio"],
            "objeto" => $datos["objeto"],
            "dependencia" => $datos["dependencia"],
            "funcionario" => $datos["funcionario"],
            "observacion" => $datos["observacion"],
        );
    }
} catch (PDOException $e) {
    $salida[] = array(
        "cargado" => false,
        "mensaje" => "Error al cargar los expedientes. " . $e->getMessage()
    );
}

echo json_encode($salida);
