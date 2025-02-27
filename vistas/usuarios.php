<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
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

    <div class="container" id="main">
        <div class="card">
            <div class="card-header text-center">
                <h3>Usuarios</h3>
            </div>
            <div class="card-body">
                <div class="">
                    <button type="button" class="btn btn-outline-danger" id="generarPDF">Generar PDF <i class="fa-solid fa-file-pdf"></i></button>
                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-striped table-hover w-100" id="tabla_usuarios">
                        <thead>
                            <tr>
                                <th style="width: 20%;" class="text-center">Funcionario</th>
                                <th style="width: 20%;" class="text-center">Usuario</th>
                                <th style="width: 20%;" class="text-center">Correo</th>
                                <th style="width: 20%;" class="text-center">ROL</th>
                                <th style="width: 15%;" class="text-center">Foto</th>
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
    <div class="modal fade" id="modalUsuarios" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="#" id="form_usuarios" enctype="multipart/form-data" autocomplete="off">
                            <div class="row d-flex">
                                <div class="row">
                                    <div class="col-11">
                                        <div class="mt-2">
                                            <label for="ci">C.I</label>
                                            <input type="text" name="ci" id="ci" class="form-control text-uppercase text-end" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="mt-4">
                                            <button type="button" class="btn btn-outline-primary mt-2" id="btn_buscar" onclick="buscar_funcionario();" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Buscar"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="funcionario">Funcionario</label>
                                    <input type="text" name="funcionario" id="funcionario" class="form-control" readonly>
                                </div>
                                <div class="mt-2">
                                    <label for="correo">Correo</label>
                                    <input type="text" name="correo" id="correo" class="form-control" maxlength="30">
                                    <div id="error_correo" class="mt-1 fs-5">

                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="rol">Rol</label>
                                    <select name="rol" id="rol" class="form-select">
                                        <option value="">Seleccione un rol</option>
                                    </select>
                                </div>
                                <div class="mt-2">
                                    <label for="usuario">Usuario</label>
                                    <input type="text" name="usuario" id="usuario" class="form-control" autocomplete="off" maxlength="30" oninput="validarUsuario(this.value)">
                                    <div id="error_usuario" class="mt-1 fs-5">

                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="password">Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="password" id="password" maxlength="30" oninput="validarContrasenha()" />
                                        <button class="btn btn-dark border-0" type="button" id="hide-show" onclick="mostrarPassword('password', 'icono')">
                                            <i class="fa fa-eye icono fw-bold"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="error_password" class="mt-1 fs-6">

                                </div>
                                <div class="mt-2">
                                    <input type="hidden" id="id_funcionario" name="id_funcionario" class="form-control">
                                    <input type="hidden" id="perfil" name="perfil" class="form-control">
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
    <script src="../js/usuarios.js"></script>
</body>

</html>