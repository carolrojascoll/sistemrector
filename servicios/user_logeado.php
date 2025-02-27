<?php

    include("conexion.php");

    try {

        $stmt = $conexion->prepare("SELECT f.ci, CONCAT(f.nombre,' ',f.apellido) as nombre,
        r.rol, d.dependencia, c.ciudad, f.direccion, f.telefono, u.foto, f.id_funcionario
        FROM usuarios u JOIN roles r
        ON u.id_rol = r.id_rol JOIN funcionarios f
        ON u.id_funcionario = f.id_funcionario JOIN ciudades c
        ON f.id_ciudad = c.id_ciudad JOIN dependencias d
        ON f.id_dependencia = d.id_dependencia
        WHERE u.usuario = ?");
        
        $stmt->execute(array($_POST["usuario"]));
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $salida = array();  
        foreach($resultado as $datos) {
            $salida["logeado"] = true;
            $salida["ci"] = $datos["ci"];
            $salida["nombre"] = $datos["nombre"];
            $salida["rol"] = $datos["rol"];
            $salida["dependencia"] = $datos["dependencia"];
            $salida["ciudad"] = $datos["ciudad"];
            $salida["id_funcionario"] = $datos["id_funcionario"];
            $salida["direccion"] = $datos["direccion"];
            $salida["foto"] = $datos["foto"];
        }

    } catch(PDOException $e) {
        $salida = array(
            "logeado" => false,
            "mensaje" => "Error al obtener los datos del funcionario.!!!"
        );
    }

    echo json_encode($salida);

