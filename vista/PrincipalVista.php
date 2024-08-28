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
                <h2 class="sign-up__title">Pagina Principal</h2>
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
      <div class="container">
        <div class="row stat-cards">
          <div class="col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon primary">
                <i data-feather="file" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num"><?php echo $principal->count_doc_entrada() ?></p>
                <p class="stat-cards-info__title">Total Doc. entrada</p>
              </div>
            </article>
          </div>
          <div class="col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon warning">
                <i data-feather="file" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num"> <?php echo $principal->count_doc_salida() ?>
                <p class="stat-cards-info__title">Total Doc. Salida</p>
              </div>
            </article>
          </div>
          <div class="col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon danger">
                <i data-feather="file" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num"><?php echo $principal->count_doc_sin_entrada() ?></p>
                <p class="stat-cards-info__title">Total Doc. sin Entrada</p>
              </div>
            </article>
          </div>
          <div class="col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon success">
                <i data-feather="file" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-danger">
                <p class="stat-cards-info__num"><?php echo $principal->count_doc_total() ?></p>
                <p class="stat-cards-info__title">Total Doc</p>
              </div>
            </article>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="chart">
              <canvas id="myChart" aria-label="Site statistics" role="img"></canvas>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
          <div class="card white-block m-1">
          <div class="card-body">
          <div id="contenedorTabla">

          </div>
          </div>
          </div>
          </div>
        </div>
      </div>
    </main>
    <?php if($_SESSION["usuario"]["rol"] == 'Administrador'){?>
        <script>
          var Admin = true;
        </script>
    <?php } ?>
    <!-- ! Footer -->
    <?php include_once "bin/component/footer.php";?>
  </div>
</div>
<!-- Chart library -->
<script src="plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="content/js/script.js"></script>
<script src="content/js/reporte_principal.js"></script>

</body>

</html>