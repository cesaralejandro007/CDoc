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

        .swal2-confirm {
            background-color: #2f49d1 !important;
        }
    </style>
<body>
  <div class="layer"></div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="modalshowhide">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content white-block">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Registrar Secciones</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="sign-up-form form">
        <input type="hidden" name="accion" class="form-control" id="accion">
        <input type="hidden" name="id_seccion" class="form-control" id="id_seccion">
        <input type="hidden" name="nombre_seccion" class="form-control" id="nombre_seccion">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label class="form-label" for="cantidad">Meta por Sección</label>
              <input type="text" class="form-control form-input" id="cantidad" placeholder="Cantidad" required>
            </div>
            <span id="scantidad"></span>
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
                <h2 class="sign-up__title">Consultar Secciones y Documentos</h2>
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
              <th style="text-align: center;">Secciones</th>
              <th style="text-align: center;">Cantidad de Doc.</th>
              <th style="text-align: center;">Cumplimiento %</th>
              <th style="text-align: center;">Meta por sección</th>
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
                      onclick="cargar_datos(<?=$valor['id_seccion'];?>);">
                          <i style="font-size: 15px" class="fas fa-edit"></i>
                      </button>
                  </td>
                  <td style="text-align: center;" class="project-actions text-left">
                      <?php echo $valor['nombre_seccion']; ?>
                  </td>
                  <td style="text-align: center;" class="project-actions text-left">
                      <?php echo $valor['cantidad_documentos']; ?>
                  </td>
                  <td style="text-align: center;" class="project-actions text-left">
                      <?php echo $valor['porcentaje_documentos']; ?>
                  </td>
                  <td style="text-align: center;" class="project-actions text-left">
                      <?php echo $valor['total_documentos']; ?>
                  </td>
              </tr>
              <?php
            } ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer d-flex justify-content-center">
    <div class="input-group mb-3 col-6">
      <label class="input-group-text" for="meta">Meta general del mes</label>
      <input type="text" class="form-control" id="meta" placeholder="...">
      <button class="btn btn-outline-primary" type="button" id="actualizar_meta">Actualizar</button>
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

<script src="content/js/datatables-Secciones.js"></script>

<script src="content/js/script.js"></script>

<script src="content/js/secciones.js"></script>
</body>

</html>