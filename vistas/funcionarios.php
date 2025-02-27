<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionarios</title>
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

    <div class="container-fluid" id="main">
        <div class="card">
            <div class="card-header text-center">
                <h3>Funcionarios</h3>
            </div>
            <div class="card-body">
                <div class="">
                    <button type="button" class="btn btn-outline-danger" id="generarPDF">Generar PDF <i class="fa-solid fa-file-pdf"></i></button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover w-100" id="tabla_funcionarios">
                        <thead>
                            <tr>
                                <th style="width: 5%;" class="text-center">C.I</th>
                                <th style="width: 20%;" class="text-center">Nombre</th>
                                <th style="width: 15%;" class="text-center">Ciudad</th>
                                <th style="width: 25%;" class="text-center">Dirección</th>
                                <th style="width: 10%;" class="text-center">Telefono</th>
                                <th style="width: 20%;" class="text-center">Dependencia</th>
                                <th style="width: 5%;" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-primary" id="btn_nuevo">Nuevo</button>
                    </div>
                    <div class="col-6 text-end">
                        <button type="button" class="btn btn-outline-danger" id="btn_salir">Salir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Nuevo | Editar -->
    <div class="modal fade" id="modalFuncionarios" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="#" id="form_funcionarios">
                            <div>
                                <label for="ci">C.I</label>
                                <input type="text" name="ci" id="ci" class="form-control" autocomplete="off" maxlength="7" oninput="this.value=solo_numeros_sin_cero(this.value)">
                            </div>
                            <div class="mt-2">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control text-uppercase" autocomplete="off" maxlength="30" oninput="this.value=mayusculas_espacio(this.value)">
                            </div>
                            <div class="mt-2">
                                <label for="apellido">Apellido</label>
                                <input type="text" name="apellido" id="apellido" class="form-control text-uppercase" autocomplete="off" maxlength="30" oninput="this.value=mayusculas_espacio(this.value)">
                            </div>
                            <div class="mt-2">
                                <label for="ciudad">Ciudad</label>
                                <select name="ciudad" id="ciudad" class="form-select">
                                    <option value="">Seleccione una ciudad</option>
                                </select>
                            </div>
                            <div class="mt-2">
                                <label for="direcion">Dirección</label>
                                <input type="text" name="direccion" id="direccion" class="form-control text-uppercase" autocomplete="off" maxlength="30" oninput="this.value=mayusculas_espacio(this.value)">
                            </div>
                            <div class="mt-2">
                                <label for="telefono">Telefono</label>
                                <input type="text" name="telefono" id="telefono" class="form-control">
                            </div>
                            <div class="mt-2">
                                <label for="dependencia">Dependencia</label>
                                <select name="dependencia" id="dependencia" class="form-select">
                                    <option value="">Seleccione una dependencia</option>
                                </select>
                            </div>
                        </form>
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
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/datatables.min.js"></script>
    <script src="../js/all.min.js"></script>
    <script src="../js/sweetalert2.all.min.js"></script>
    <script src="../js/toastr.js"></script>
    <script src="../js/functions.js"></script>
    <script src="../js/menu.js"></script>
    <script src="../js/funcionarios.js"></script>
</body>

</html>