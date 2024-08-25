<!DOCTYPE html>
<html lang="en">

<?php include_once "bin/component/head.php";?>

<body>
  <div class="layer"></div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="modalshowhide">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content white-block">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Registrar Persona</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="sign-up-form form">
        <input type="hidden" name="accion" class="form-control" id="accion">
        <input type="hidden" name="id_usuario" class="form-control" id="id_usuario">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label" for="inputCedula">Cédula</label>
              <input type="text" class="form-control form-input" id="inputCedula" placeholder="Cédula" required>
            </div>
            <span id="sinputCedula"></span>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label" for="inputNombres">Nombres</label>
              <input type="text" class="form-control form-input" id="inputNombres" placeholder="Nombres" required>
            </div>
            <span id="sinputNombres"></span>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label" for="inputApellidos">Apellidos</label>
              <input type="text" class="form-control form-input" id="inputApellidos" placeholder="Apellidos" required>
            </div>
            <span id="sinputApellidos"></span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label" for="inputSexo">Sexo</label>
              <select id="inputSexo" class="form-control form-input" required>
                <option value="0" selected>Seleccione...</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Otro">Otro</option>
              </select>
            </div>
            <span id="sinputSexo"></span>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label" for="rol">Rol</label>
              <select id="rol" class="form-control form-input" required>
                <option value="Administrador">Administrador</option>
                <option value="Usuario">Usuario</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group"> 
                <label class="form-label" for="seccion">Nombre de Sección</label>
                <input list="tipoSeccion" id="seccion" placeholder="Sección" class="form-control form-input" required>
                <datalist id="tipoSeccion">
                    <?php foreach($list as $key => $section) {?>
                    <option value="<?php echo $section["nombre_seccion"]; ?>" data-id="<?php echo $section["id_seccion"]; ?>"></option>
                    <?php }?>
                </datalist>
              </div>
              <span id="sseccion"></span>
            </div>
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button id="enviar" type="button" class="btn btn-primary">Registrar</button>
      </div>
    </div>
  </div>
</div>
<!-- ! Body -->
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>
<div class="page-flex">
  <!-- ! Sidebar -->
  <?php include_once "bin/component/sidebar.php";?>
  <div class="main-wrapper">
    <!-- ! Main nav -->
    <nav class="main-nav--bg">
        <div class="container main-nav">
            <div class="main-nav-start">
                <h2 class="sign-up__title">Consultar Usuarios</h2>
            </div>
            <div class="main-nav-end">
            <button class="theme-switcher gray-circle-btn" type="button" title="Switch theme">
                <span class="sr-only">Switch theme</span>
                <i class="sun-icon" data-feather="sun" aria-hidden="true"></i>
                <i class="moon-icon" data-feather="moon" aria-hidden="true"></i>
            </button>
            <div class="nav-user-wrapper">
                <button href="##" class="nav-user-btn dropdown-btn d-flex justify-content-center align-items-center" title="My profile" type="button">
                <span class="sr-only">My profile</span>
                <span class="p-1">   <?php echo "V". $_SESSION['usuario']['cedula'] ?></span>   
                <?php if($_SESSION['usuario']['sexo'] == "Masculino"){ ?>
                <span class="nav-user-img">
                    <picture><source srcset="assets/img/avatar/avatar-illustrated-02.webp" type="image/webp"><img src="assets/img/avatar/avatar-illustrated-02.png" alt="User name"></picture>
                </span>
                <?php }else{ ?>
                <span class="nav-user-img">
                    <picture><source srcset="assets/img/avatar/avatar-illustrated-01.webp" type="image/webp"><img src="assets/img/avatar/avatar-illustrated-02.png" alt="User name"></picture>
                </span>
                <?php } ?>
                </button>
                <ul class="users-item-dropdown nav-user-dropdown dropdown">
                <li><a href="##" onclick="cambiarClave()">
                    <i data-feather="user" aria-hidden="true"></i>
                    <span>Cambiar Clave</span>
                    </a></li>
                <li><a class="danger" href=".">
                    <i data-feather="log-out" aria-hidden="true"></i>
                    <span>Salir</span>
                    </a></li>
                </ul>
            </div>
            </div>
        </div>
    </nav>
    <!-- ! Main -->
    <main class="main users chart-page" id="skip-target">
  <div class="card white-block m-1">
    <div class="card-body">
    <div class="users-table table-responsive py-2 m-0">
      <table id="tabla" class="posts-table">
          <thead>
            <tr class="users-table-info">
              <th style="text-align: center;">Editar</th>
              <th style="text-align: center;">Eliminar</th>
              <th style="text-align: center;">Cedula</th>
              <th style="text-align: center;">Nombres</th>
              <th style="text-align: center;">Apellidos</th>
              <th style="text-align: center;">Genero</th>
              <th style="text-align: center;">Nombre de Sección</th>
              <th style="text-align: center;">Meta</th>
            </tr>
          </thead>
          <tbody>
          <?php
            foreach ($list as $valor) {
              // Imprimir datos básicos del usuario
              ?>
              <tr>
                  <td style="text-align: center; padding-left:0px" class="project-actions text-left">
                      <button class="btn m-1 text-white px-2 py-1" style="background:#E67E22;" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Editar"
                      onclick="cargar_datos(<?=$valor['id_usuario'];?>);">
                          <i style="font-size: 15px" class="fas fa-edit"></i>
                      </button>
                  </td>
                  <td style="text-align: center;" class="project-actions text-left">
                      <button class="btn m-1 px-2 py-1" style="background:#9D2323;color:white"  type="button" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Eliminar"
                      onclick="eliminar(<?=$valor['id_usuario'];?>,<?=$valor['cedula'];?>,`<?=$valor['nombres'];?>`,`<?=$valor['apellidos'];?>`);">
                          <i style="font-size: 15px" class="fas fa-trash"></i>
                      </button>
                  </td>
                  <td style="text-align: center;" class="project-actions text-left">
                      <?php echo $valor['cedula']; ?>
                  </td>
                  <td style="text-align: center;" class="project-actions text-left">
                      <?php echo $valor['nombres']; ?>
                  </td>
                  <td style="text-align: center;" class="project-actions text-left">
                      <?php echo $valor['apellidos']; ?>
                  </td>
                  <td style="text-align: center;" class="project-actions text-left">
                      <?php echo $valor['sexo']; ?>
                  </td>
                  <td style="text-align: center;" class="project-actions text-left">
                      <?php echo $valor['nombre_seccion']; ?>
                  </td>
                  <td style="text-align: center;" class="project-actions text-left">
                    <?php if (!empty($valor['metas'])) { ?>
                        <div style="max-height: 100px; overflow-y: auto;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Mes</th>
                                        <th style="text-align: center;">Meta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($valor['metas'] as $meta) { ?>
                                        <tr>
                                            <td style="text-align: center;"><?php echo $meta['mes']; ?></td>
                                            <td style="text-align: center;"><?php echo $meta['meta']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <p>No hay metas</p>
                    <?php } ?>
                </td>
              </tr>
              <?php
            } ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer">
      <div class="d-flex justify-content-center">
      <button type="submit" id="nuevo" data-toggle="modal" class="form-btn primary-default-btn transparent-btn col-2 text-nowrap">Registrar Usuario</button>
      </div>
    </div>
  </div>
    </main>
    <!-- ! Footer -->
    <?php include_once "bin/component/footer.php";?>
  </div>
</div>
<!-- Chart library -->
<script src="plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->

<script src="content/js/datatables-Usuarios.js"></script>

<script src="content/js/script.js"></script>

<script src="content/js/usuario.js"></script>
</body>

</html>