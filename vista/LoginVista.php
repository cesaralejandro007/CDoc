<?php
use config\componentes\configSistema as configSistema;
?>
<!DOCTYPE html>
<html lang="en">

<?php include_once "bin/component/head.php";?>
<body>
  <div class="layer"></div>
<main class="page-center">
  <article class="sign-up">
    <h1 class="sign-up__title" style="margin-bottom:15px">Control de Documentos</h1>
    <p class="sign-up__subtitle" style="margin-bottom:5px">Inicia sesión en tu cuenta para continuar</p>
    <form class="sign-up-form form" action="" method="">
      <label class="form-label-wrapper">
        <p class="form-label">Usuario</p>
        <input class="form-input" type="text" placeholder="Usuario" required>
      </label>
      <label class="form-label-wrapper">
        <p class="form-label">Contraseña</p>
        <input class="form-input" type="password" placeholder="Contraseña" required>
      </label>
      <a href="?pagina=<?php configSistema::_PRINCIPAL_();?>" class="form-btn primary-default-btn transparent-btn">Iniciar Sesión</a>
    </form>
  </article>
</main>
<!-- Chart library -->
<script src="plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="content/js/script.js"></script>
</body>

</html>