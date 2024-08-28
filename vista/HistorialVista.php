<!DOCTYPE html>
<html lang="en">

<?php include_once "bin/component/head.php";?>
<style>
    body {
    margin: 0;
    padding: 0;
    position: relative; /* Asegura que el pseudoelemento se posicione correctamente */
    overflow: auto; /* Evita barras de desplazamiento si el pseudoelemento excede el tamaño del viewport */
}

/* Pseudoelemento para la imagen de fondo con opacidad */
body::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 98%;
    background-image: 
        linear-gradient(45deg, transparent 50%, rgba(255,255,255,0.7) 50%),
        url('assets/img/seniat_fondo.jpg');
    background-repeat: repeat;
    background-size: 250px 120px; /* Tamaño de la imagen */
    background-position: 0 0; /* Posiciona la imagen en la esquina superior izquierda */
    opacity: 0.2; /* Ajusta la opacidad de la imagen de fondo */
    z-index: -1; /* Asegura que la imagen esté detrás de todo el contenido */
    pointer-events: none; /* Evita que el pseudoelemento interfiera con la interacción del usuario */
}

/* Estilo adicional para asegurar que los botones y otros elementos estén visibles sobre el fondo */
.swal2-confirm {
    background-color: #2f49d1 !important;
}

</style>
<body>
  <div class="layer"></div>

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
                <h2 class="sign-up__title">Consultar Historial</h2>
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
              <th style="text-align: center;">Usuario</th>
              <th style="text-align: center;">acciones</th>
            </tr>
          </thead>
          <tbody>
<?php
foreach ($list as $valor) {
    ?>
    <tr>
        <td style="text-align: center;" class="project-actions text-left">
            <?php echo $valor['nombre_completo']; ?>
        </td>
        <td style="text-align: center;" class="project-actions text-left">
            <!-- Contenedor con scroll para las acciones -->
            <div style="max-height: 150px; overflow-y: auto;">
                <table class="table table-sm">
                    <tbody>
                    <?php
                    foreach ($valor['acciones'] as $accion) {
                        ?>
                        <tr>
                            <td><?php echo $accion; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </td>
    </tr>
    <?php
} ?>
</tbody>

        </table>
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

<script src="content/js/datatables-historial.js"></script>

<script src="content/js/script.js"></script>

</body>

</html>