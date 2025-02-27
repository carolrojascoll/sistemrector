<?php
ob_start();

require_once '../dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$mysqli = new mysqli("localhost", "root", "", "rectorado");

// Manejo de errores si la conexión falla
if ($mysqli->connect_errno) {
    die("Error al conectar con MySQL: " . $mysqli->connect_error);
}

$consulta = "SELECT f.id_funcionario, f.ci,CONCAT(f.nombre,' ',f.apellido) AS nombre, c.ciudad, f.direccion, f.telefono, d.dependencia FROM funcionarios f JOIN ciudades c ON f.id_ciudad = c.id_ciudad JOIN dependencias d ON f.id_dependencia = d.id_dependencia;
";
$resultados = $mysqli->query($consulta);

// Manejo de errores si la consulta falla
if (!$resultados) {
    die("Error al recuperar datos: " . $mysqli->error);
}

$filas = $resultados->fetch_all(MYSQLI_ASSOC);

$mysqli->close();

$fechaGeneracion = date('d/m/Y');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Funcionarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.2;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        header img {
            width: 80px; /* Ajustar el tamaño aquí */
            height: auto;
            margin-right: 10px;
        }

        h1 {
            font-size: 16px;
            margin: 0;
        }

        h2 {
            font-size: 14px;
            margin: 0;
        }

        .subheader {
            font-size: 10px;
        }

        hr {
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #aab0fd;
            font-size: 12px;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #d5d5d5;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: left;
            font-size: 10px;
        }

        .seccion1 {
            width: 15%;
            box-sizing: border-box;
            font-size: 12px;
            text-align: center;
            float: left;
        }

        .seccion2 {
            width: 85%;
        }
    </style>
</head>

<body>
    <header>
        <div class="seccion1">
            <?php $ima = base64_encode(file_get_contents('uncrectorado.png')); ?>
            <img src="data:image/png;base64, <?php echo $ima; ?>" alt="">
        </div>
        <div class="seccion2">
            <h1>UNIVERSIDAD NACIONAL DE CONCEPCIÓN - RECTORADO</h1>
            <h2>“Ciencias, Sabiduría, Acción... Marcando el Norte”</h2>
            <h2>Creada por Ley N° 3201/07</h2>
            <p class="subheader">Ruta V "Gral. Bemandino Cabaliero" Km. 2. Tel: (55) 331 241060-240883 uncrecionado@gmail.com</p>
        </div>
    </header>
    <hr>
    <h2 style="text-align: center;">LISTA DE FUNCIONARIOS</h2>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>CI</th>
                <th>NOMBRE</th>
                <th>CIUDAD</th>
                <th>DIRECCIÓN</th>
                <th>TELÉFONO</th>
                <th>DEPENDENCIA</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $num = 1;
            foreach ($filas as $fila) {
            ?>
                <tr>
                    <td><?php echo $num++; ?></td>
                    <td><?php echo $fila['ci']; ?></td>
                    <td><?php echo $fila['nombre']; ?></td>
                    <td><?php echo $fila['ciudad']; ?></td>
                    <td><?php echo $fila['direccion']; ?></td>
                    <td><?php echo $fila['telefono']; ?></td>
                    <td><?php echo $fila['dependencia']; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <footer>
        Fecha: <?php echo $fechaGeneracion; ?>
    </footer>
</body>

</html>

<?php
$html = ob_get_clean();
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('defaultFont', 'Arial');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('letter', 'portrait');
$dompdf->render();

$dompdf->stream('lista_funcionarios.pdf', array('Attachment' => false));
?>
