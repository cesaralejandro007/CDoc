<!DOCTYPE html>
<html lang="en">

<?php include_once "bin/component/head.php";?>

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
                <h2 class="sign-up__title">Documentos de Salida</h2>
            </div>
            <div class="main-nav-end">
            <button class="theme-switcher gray-circle-btn" type="button" title="Switch theme">
                <span class="sr-only">Switch theme</span>
                <i class="sun-icon" data-feather="sun" aria-hidden="true"></i>
                <i class="moon-icon" data-feather="moon" aria-hidden="true"></i>
            </button>
            <div class="nav-user-wrapper">
                <button href="##" class="nav-user-btn dropdown-btn" title="My profile" type="button">
                <span class="sr-only">My profile</span>
                <span class="nav-user-img">
                    <picture><source srcset="assets/img/avatar/avatar-illustrated-02.webp" type="image/webp"><img src="assets/img/avatar/avatar-illustrated-02.png" alt="User name"></picture>
                </span>
                </button>
                <ul class="users-item-dropdown nav-user-dropdown dropdown">
                <li><a href="##">
                    <i data-feather="user" aria-hidden="true"></i>
                    <span>Perfil</span>
                    </a></li>
                <li><a href="##">
                    <i data-feather="settings" aria-hidden="true"></i>
                    <span>Configuración</span>
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
            <th style="text-align: center;">Migrar Doc.</th>
            <th style="text-align: center;">Funcionario</th>
            <th style="text-align: center;">Nº de documento</th>
            <th style="text-align: center;">Fecha de Entrada</th>
            <th style="text-align: center;">Fecha de Salida</th>
            <th style="text-align: center;">Dias de diferencia</th>
            <th style="text-align: center;">Nombre de Remitente</th>
            <th style="text-align: center;">Descripción del Documento</th>
          </tr>
        </thead>
        <tbody>
        <?php
          foreach ($listDocSal as $valor) 
          {?>
              <tr>
              <td style="text-align: center; padding-left:0px" class="project-actions text-left">
                  <button class="btn m-1 text-white px-2 py-1" style="background:#E67E22;" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Editar"
                  onclick="cargar_datos(<?=$valor['id_documento'];?>);"><i style="font-size: 15px" class="fas fa-edit"></i></button>
              </td>
              <td style="text-align: center;" class="project-actions text-left">
                  <button class="btn m-1 px-2 py-1" style="background:#9D2323;color:white"  type="button" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Eliminar"
                  onclick="eliminar(<?=$valor['id_documento'];?>);"><i style="font-size: 15px" class="fas fa-trash"></i></button>
              </td>
              <td style="text-align: center;" class="project-actions text-left">
                  <button class="btn m-1 px-2 py-1" style="background:#0228B5;color:white"  type="button" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Migrar"
                  onclick="migrarDoc(<?=$valor['id_documento'];?>);"><i style="font-size: 15px" class="fas fa-exchange-alt"></i></button>
              </td>
              <td style="text-align: center;" class="project-actions text-left">
                  <?php echo $valor['usuario_completo']; ?>
              </td>
              <td style="text-align: center;" class="project-actions text-left">
                  <?php echo $valor['numero_doc']; ?>
              </td>
              <td style="text-align: center;" class="project-actions text-left">
                  <?php echo $valor['fecha_entrada_formateada']; ?>
              </td>
              <td style="text-align: center;" class="project-actions text-left">
                  <?php echo $valor['fecha_salida_formateada']; ?>
              </td>
              <td style="text-align: center;" class="project-actions text-left">
                  <?php echo $valor['nombre_rem']; ?>
              </td>
              <td style="text-align: center;" class="project-actions text-left">
                  <?php echo $valor['diferencia_dias']; ?>
              </td>
              <td style="text-align: center;" class="project-actions text-left">
                  <?php echo $valor['descripcion']; ?>
              </td>
              </tr>
      <?php
          }?>
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
<script src="content/js/datatables-docSalida.js"></script>

<script src="content/js/script.js"></script>
</body>

</html>