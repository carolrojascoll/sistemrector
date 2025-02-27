<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expedientes a Revisar</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/datatables.min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/toastr.min.css">
    <link rel="stylesheet" href="../css/sweetalert2.min.css">
    <link rel="stylesheet" href="../css/menu.css">
</head>

<body>
    <?php include("sidebar.php") ?>
    <div class="container-fluid" id="main">
        <div class="card">
            <div class="card-header text-center">
                <h3>Expedientes a Revisar</h3>
            </div>
            <div class="card-body">
                <div class="w-25" id="div_select">
                    <label for="dependencia_expedientes">Dependencia</label>
                    <select name="dependencia_expedientes" id="dependencia_expedientes" class="form-select">

                    </select>
                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-striped table-hover w-100" id="tabla_expedientes">
                        <thead class="text-center">
                            <tr>
                                <th>Nro</th>
                                <th>Fecha</th>
                                <th>Año</th>
                                <th>Remitente</th>
                                <th>Objeto</th>
                                <th>Dependecia</th>
                                <th>Recepcionó</th>
                                <th>Observación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-12 text-end">
                        <button type="button" class="btn btn-outline-danger" id="btn_salir">Salir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nuevo | Editar -->
    <div class="modal fade" id="modalEditarExp" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Expediente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div>
                            <label for="nro_edit">Nro</label>
                            <input type="text" name="nro_edit" id="nro_edit" class="form-control text-uppercase" oninput="this.value=solo_numeros_sin_cero(this.value)" autocomplete="off" maxlength="30">
                        </div>
                        <div class="mt-2">
                            <label for="fecha_edit">Fecha</label>
                            <input type="text" name="fecha_edit" id="fecha_edit" class="form-control">
                        </div>
                        <div class="mt-2">
                            <label for="anhio_edit">Año</label>
                            <input type="text" name="anhio_edit" id="anhio_edit" class="form-control text-uppercase" oninput="this.value=solo_numeros_sin_cero(this.value)" autocomplete="off" maxlength="4">
                        </div>
                        <div class="mt-2">
                            <label for="area_edit">Area</label>
                            <select name="area_edit" id="area_edit" class="form-select">

                            </select>
                        </div>
                        <div class="mt-2">
                            <label for="objeto_edit">Objeto</label>
                            <select name="objeto_edit" id="objeto_edit" class="form-select">

                            </select>
                        </div>
                        <div class="mt-2">
                            <label for="dependencia_edit">Dependencia</label>
                            <select name="dependencia_edit" id="dependencia_edit" class="form-select">

                            </select>
                        </div>
                        <div class="mt-2">
                            <label for="observacion_edit">Observación</label>
                            <input type="text" name="observacion_edit" id="observacion_edit" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" id="btn_guardar"> Guardar</button>
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/datatables.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/all.min.js"></script>
    <script src="../js/toastr.js"></script>
    <script src="../js/sweetalert2.all.min.js"></script>
    <script src="../js/functions.js"></script>
    <script src="../js/permisos.js"></script>
    <script src="../js/menu.js"></script>
    <script src="../js/expedientes_revisar.js"></script>
</body>

</html>