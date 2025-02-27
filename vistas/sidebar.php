      <!-- Modal Perfil de Usuario -->
      <div class="modal fade" id="modalPerfil" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Perfil de Usuario</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="d-flex flex-column">
                <span>
                  <b>FUNCIONARIO: </b> <span id="p_nombre"></span>
                </span>
                <span>
                  <b>C.I: </b><span id="p_ci"></span>
                </span>
                <span>
                  <b>DEPENDENCIA: </b><span id="p_dependencia"></span>
                </span>
                <span>
                  <b>CIUDAD: </b><span id="p_ciudad"></span>
                </span>
                <span>
                  <b>DIRECCIÓN: </b><span id="p_direccion"></span>
                </span>
                <span>
                  <b>TELEFONO: </b><span id="p_telefono"></span>
                </span>
                <span>
                  <b>ROL: </b><span id="p_rol"></span>
                </span>
                <span>
                  <b>USUARIO: </b><span id="p_usuario"></span>
                </span>
                <div class="text-center mt-2">
                  <img src="#" class="img-fluid rounded" id="p_userPerfil" width="200" height="200">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-primary" id="btn_datos" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Modificar Datos"><i class="fa-solid fa-pen-to-square"></i></button>
              <button type="button" class="btn btn-outline-success" id="btn_foto" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cambiar Foto de Perfil"><i class="fa-solid fa-user-gear"></i></button>
              <button type="button" class="btn btn-outline-warning" id="btn_password" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cambiar Contraseña"><i class="fa-solid fa-rotate"></i></button>
              <button type="button" class="btn btn-outline-danger" id="btn_sesion" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cerrar Sesión"><i class="bi bi-box-arrow-left"></i></button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Editar Datos || Foto -->
      <div class="modal fade" id="modalEditar" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="title_editar">Modal-title</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div id="div_datos">
                <form action="#" id="form_datos">
                  <div class="mt-2">
                    <label for="ci_num">C.I</label>
                    <input type="text" name="ci_num" id="ci_num" class="form-control">
                  </div>
                  <div class="mt-2">
                    <label for="f_nombre">Nombre</label>
                    <input type="text" name="f_nombre" id="f_nombre" class="form-control">
                  </div>
                  <div class="mt-2">
                    <label for="f_apellido">Apellido</label>
                    <input type="text" name="f_apellido" id="f_apellido" class="form-control">
                  </div>
                  <div class="mt-2">
                    <label for="f_ciudad">Ciudad</label>
                    <select name="f_ciudad" id="f_ciudad" class="form-select">
                    </select>
                  </div>
                  <div class="mt-2">
                    <label for="f_direccion">Dirección</label>
                    <input type="text" name="f_direccion" id="f_direccion" class="form-control">
                  </div>
                  <div class="mt-2">
                    <label for="f_telefono">Telefono</label>
                    <input type="text" name="f_telefono" id="f_telefono" class="form-control">
                  </div>
                </form>
              </div>
              <div id="div_password">
                <div>
                  <form action="#" id="form_contrasena">
                    <div class="mt-2">
                      <label for="anterior">Contraseña Anterior</label>
                      <div class="input-group">
                        <input type="password" class="form-control" name="anterior" id="anterior" maxlength="30" />
                        <button class="btn btn-dark border-0" type="button" id="bef" onclick="mostrarPassword('anterior', 'eye_anterior')">
                          <i class="fa fa-eye eye_anterior fw-bold"></i>
                        </button>
                      </div>
                    </div>
                    <div id="error_anterior" class="mt-1 fs-6">
                    </div>
                </div>
                <div>
                  <div class="mt-2">
                    <label for="nueva">Nueva Contraseña</label>
                    <div class="input-group">
                      <input type="password" class="form-control" name="nueva" id="nueva" maxlength="30" oninput="validarContrasenha()" />
                      <button class="btn btn-dark border-0" type="button" id="new" onclick="mostrarPassword('nueva', 'eye_nuevo')">
                        <i class="fa fa-eye eye_nuevo fw-bold"></i>
                      </button>
                    </div>
                  </div>
                  <div id="error_nuevo" class="mt-1 fs-6">
                  </div>
                </div>
                <div>
                  <div class="mt-2">
                    <label for="confirmar">Confirmar Contraseña</label>
                    <div class="input-group">
                      <input type="password" class="form-control" name="confirmar" id="confirmar" maxlength="30" />
                      <button class="btn btn-dark border-0" type="button" id="conf" onclick="mostrarPassword('confirmar', 'eye_confirmar')">
                        <i class="fa fa-eye eye_confirmar fw-bold"></i>
                      </button>
                    </div>
                  </div>
                </div>
                </form>
              </div>
              <div id="div_foto">
                <form action="#" id="form_perfil">
                  <div>
                    <input type="file" class="form-control" id="foto" name="foto">
                    <div class="mt-2 text-white" id="file_name">
                      <input type="hidden" name="user" id="user">
                    </div>
                    <div class="mt-2 text-center">
                      <span id="span_vista">
                      </span>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-success bg-transparent" id="btn_confirmar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Guardar"><i class="fa-solid fa-check"></i></button>
              <button type="button" class="btn btn-outline-danger bg-transparent" id="btn_cancelar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cancelar"><i class="fa-solid fa-x"></i></button>
            </div>
          </div>
        </div>
      </div>

      <nav class="navbar fixed-top nav-icon border-0">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <button type="button" class="border-0 bg-transparent" id="user_perfil">
            <img class="img-fluid rounded-5" id="user_img" src="#" alt="" width="50px" height="50px">
          </button>
          <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Rectorado</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body nav-icon">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="menu.php">
                    <img src="../img/inicio.png" class="rouded" alt="Inicio" height="50px" width="50px">
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Mantenimientos
                  </a>
                  <ul class="dropdown-menu nav-icon">
                    <li><a class="dropdown-item" id="ciudades" href="ciudades.php">Ciudades</a></li>
                    <li><a class="dropdown-item" id="roles" href="roles.php">Roles</a></li>
                    <li><a class="dropdown-item" id="funcionarios" href="funcionarios.php">Funcionarios</a></li>
                    <li><a class="dropdown-item" id="usuarios" href="usuarios.php">Usuarios</a></li>
                    <li><a class="dropdown-item" id="dependencias" href="dependencias.php">Dependencias</a></li>
                    <li><a class="dropdown-item" id="areas" href="areas.php">Áreas</a></li>
                    <li><a class="dropdown-item" id="objetos" href="objetos.php">Objetos</a></li>
                  </ul>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Expendientes
                  </a>
                  <ul class="dropdown-menu nav-icon">
                    <li><a class="dropdown-item" id="recepcion" href="expedientes.php">Recepcion</a></li>
                    <li><a class="dropdown-item" id="exp_revisar" href="expedientes_revisar.php">Expedientes a Revisar</a></li>
                    <li><a class="dropdown-item" id="his_expedientes" href="#">Historial de Expedientes</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>