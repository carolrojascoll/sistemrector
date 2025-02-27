<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expedientes</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/datatables.min.css">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/sweetalert2.min.css">
    <link rel="stylesheet" href="../css/toastr.min.css">
</head>

<body>

    <?php include("sidebar.php") ?>

    <div class="container w-50" id="main">
        <div class="card">
            <div class="card-header text-center">
                <h3 class="text-white">Recepción de Expedientes</h3>
            </div>
            <div class="card-body">
                <!-- <div class="">
                    <button type="button" class="btn btn-outline-danger" id="generarPDF">Generar PDF <i class="fa-solid fa-file-pdf"></i></button>
                </div> -->
                <div class="container mt-2">
                    <form action="#" id="form_expedientes">
                        <div class="d-flex flex-column">
                            <div class="row">
                                <div class="col-4">
                                    <div class="">
                                        <label for="nro">Nro. Expediente</label>
                                        <input type="text" name="nro" id="nro" class="form-control text-end" oninput="this.value=solo_numeros_sin_cero(this.value)" maxlength="10" autofocus="on">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="">
                                        <label for="fecha">Fecha de Recepción</label>
                                        <input type="date" name="fecha" id="fecha" class="form-control text-end" max="<?= date('Y-m-d', time()) ?>">
                                    </div>
                                </div>
                                <div class="col-4">                                    
                                    <div class="">
                                        <label for="anio">Año de Recepción</label>
                                        <input type="text" name="anio" id="anio" class="form-control text-end" maxlength="4" oninput="this.value=solo_numeros_sin_cero(this.value)">
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <label for="area">Remitente</label>
                                <select name="area" id="area" class="form-select">
                                    <option value="">Seleccione un área</option>
                                </select>
                            </div>
                            <div class="mt-2">
                                <div class="row">
                                    <div class="col-11">
                                        <label for="objets">Objeto</label>
                                        <select name="objets" id="objets" class="form-select">
                                            <option value="">Seleccione un Objeto</option>
                                        </select>
                                    </div>
                                    <div class="col-1 mt-4">
                                        <button type="button" class="btn btn-outline-primary bg-transparent" id="btn_objeto" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Agregar Objeto"><i class="fa-solid fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <label for="dependencia">Dependencia</label>
                                <select name="dependencia" id="dependencia" class="form-select">
                                    <option value="">Seleccione una dependencia</option>
                                </select>
                            </div>
                            <div class="mt-2">
                                <label for="observacion">Observación</label>
                                <input type="text" name="observacion" id="observacion" class="form-control" oninput="this.value=mayusculas_espacio(this.value)" maxlength="100">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-primary" id="btn_guardar">Guardar</button>
                    </div>
                    <div class="col-6 text-end">
                        <button type="button" class="btn btn-outline-danger" id="btn_salir">Salir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nuevo Objeto -->
    <div class="modal fade" id="modalNuevoObj" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Nuevo Objeto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="codigo">Código</label>
                        <input type="text" name="codigo" id="codigo" class="form-control" autocomplete="off" oninput="this.value=solo_numeros_sin_cero(this.value)">
                    </div>
                    <div class="mt-2">
                        <label for="obj">Objeto</label>
                        <input type="text" name="obj" id="obj" class="form-control text-uppercase" oninput="this.value=mayusculas_espacio(this.value)" maxlength="80">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" id="btn_guardarObj">Guardar</button>
                    <button type="button" class="btn btn-outline-danger" id="btn_cancelarObj">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmar -->
    <div class="modal fade" id="modalConfirmar" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Verificación de Usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="ci">Contraseña</label>
                    <input type="password" name="password_usuario" id="password_usuario" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" id="btn_conf">Confirmar</button>
                    <button type="button" class="btn btn-outline-danger" id="btn_cancelar">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/datatables.min.js"></script>
    <script src="../js/all.min.js"></script>
    <script src="../js/sweetalert2.all.min.js"></script>
    <script src="../js/toastr.js"></script>
    <script src="../js/functions.js"></script>
    <script src="../js/menu.js"></script>
    <script src="../js/expedientes.js"></script>

</body>

</html>