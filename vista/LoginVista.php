<?php
use config\componentes\configSistema as configSistema;
?>
<!DOCTYPE html>
<html lang="en">

<?php include_once "bin/component/head.php";?>
<body>
  <div class="layer"></div>
<main class="page-center">

              <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar Usuario</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="inputGroup-sizing-default">Cedula</span>
                                <input type="Text" name="user" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" id="user" required>
                            </div>
                            <span id="suser"></span>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nombres</span>
                                <input type="Text" name="nombres" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" id="nombres" required>
                            </div>
                            <span id="snombres"></span>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="inputGroup-sizing-default">Apellidos</span>
                                <input type="Text" name="apellidos" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" id="apellidos" required>
                            </div>
                            <span id="sapellidos"></span>
                        </div>
                        <div class="col-12">
                                <div class="input-group mb-1">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Rol</span>
                                    <select type="select" class="form-select" id="rol" aria-label="Default select example">
                                        <option value="Administrador">Administrador</option>
                                        <option value="Usuario">Usuario</option>
                                    </select>
                                </div>
                                <span id="ssexo"></span>
                            </div>
                            <div class="col-12">
                                <div class="input-group mb-1">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Sexo</span>
                                    <select type="select" class="form-select" id="sexo" aria-label="Default select example">
                                        <option value="0" selected>--Seleccione--</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
                                </div>
                                <span id="ssexo"></span>
                            </div>
                        <div class="col-12">
                            <div class="input-group mb-1">
                                <label class="input-group-text" for="seccion">Sección</label>
                                <input list="tipoSeccion" id="seccion" placeholder="Sección" class="form-control" required>
                                <datalist id="tipoSeccion">
                                    <?php foreach($list as $key => $section) {?>
                                    <option value="<?php echo $section["nombre_seccion"]; ?>" data-id="<?php echo $section["id_seccion"]; ?>"></option>
                                    <?php }?>
                                </datalist>
                            </div>
                            <span id="sseccion"></span>
                        </div>
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button id="enviar" type="button" style="background:#2f49d1" class="btn btn-primary">Registrar</button>
                    </div>
                    </div>
                </div>
                </div>

  <article class="sign-up">
    <h1 class="sign-up__title" style="margin-bottom:15px">Control de Documentos</h1>
    <p class="sign-up__subtitle" style="margin-bottom:5px">Inicia sesión en tu cuenta para continuar</p>
    <form class="sign-up-form form" action="" method="">
      <label class="form-label-wrapper">
        <p class="form-label">Usuario</p>
        <input id="inputUsuario" class="form-input" type="text" placeholder="Usuario" required>
      </label>
      <label class="form-label-wrapper">
        <p class="form-label">Contraseña</p>
        <input id="inputPassword" class="form-input" type="password" placeholder="Contraseña" required>
      </label>
      <a id="ingresar" class="form-btn primary-default-btn transparent-btn">Iniciar Sesión</a>
    </form>
  </article>
</main>
<?php include_once "bin/component/footer.php";?>
<!-- Chart library -->
<script src="plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="content/js/script.js"></script>

<script src="content/js/login.js"></script>
</body>

</html>