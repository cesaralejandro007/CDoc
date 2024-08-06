<!DOCTYPE html>
<html lang="en">

<?php include_once "bin/component/head.php";?>

<body>
  <div class="layer"></div>

  <style>
        .swal2-confirm {
            background-color: #2f49d1 !important;
        }
    </style>
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="modalshowhide">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content white-block">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Registrar Documento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="sign-up-form form">
    <div class="row">
      <input type="hidden" name="accion" class="form-control" id="accion">
      <input type="hidden" name="id_documento" class="form-control" id="id_documento">
        <div class="form-group col-4">
            <label class="form-label" for="inputTipoDocumento">Entrada / Sin entrada</label>
            <select id="inputTipoDocumento" class="form-control form-input" required>
                <option selected value="1">Documento de entrada</option>
                <option value="2">Documento sin entrada</option>
            </select>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="form-label" for="inputNumeroDocumento">Nº de Documento</label>
            <input type="text" class="form-control form-input" id="inputNumeroDocumento" placeholder="Nº documento" required>
          </div>
          <span id="snumeroDocumento"></span>
        </div>
        <div class="col-4">
          <div class="form-group">
              <label class="form-label" for="inputFecha">Fecha de entrada</label>
              <input type="date" class="form-control form-input" id="inputFecha" placeholder="Fecha de entrada" disabled>
          </div>
          <span id="sfecha"></span>
        </div>
    </div>
    <div class="row">
    <div class="form-group col-md-6">
        <label class="form-label" for="inputTipo">Tipo de Documento</label>
        <input list="tipoDocumentos" id="inputTipo" placeholder="Tipo de Documento" class="form-control form-input" required>
        <datalist id="tipoDocumentos">
            <?php foreach($listTDoc as $key => $tipo) {?>
              <option value="<?php echo $tipo["nombre_doc"]; ?> / <?php echo $tipo["descripcion_doc"]; ?>" data-id="<?php echo $tipo["id_tipo_documento"]; ?>"></option>
            <?php }?>
        </datalist>
        <span id="stipo"></span>
    </div>
    <div class="form-group col-md-6">
        <label class="form-label" for="inputRemitente">Nombre de Remitente</label>
        <input list="remitentes" id="inputRemitente"  placeholder="Nombre de Remitente" class="form-control form-input" disabled>
        <datalist id="remitentes">
            <?php foreach($listRemit as $key => $renit) {?>
              <option value="<?php echo $renit["nombre_rem"]; ?>" data-id="<?php echo $renit["id_remitente"]; ?>"></option>
            <?php }?>
        </datalist>
        <span id="sremitente"></span>
    </div>
</div>

    <div class="row">
        <div class="form-group col-md-12">
            <label class="form-label" for="inputDescripcion">Descripción del Documento</label>
            <textarea id="inputDescripcion" class="form-control form-input" style="height: 128px;" placeholder="Descripción del documento"></textarea>
        </div>
        <span id="sdescripcion"></span>
    </div>
</form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="enviar">Registrar</button>
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
                <h2 class="sign-up__title">Documentos De Entrada</h2>
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
            <th style="text-align: center;">Fecha de Entrada</th>
            <th style="text-align: center;">Funcionario</th>
            <th style="text-align: center;">Nº de documento</th>
            <th style="text-align: center;">Nombre de Remitente</th>
            <th style="text-align: center;">Tipo de Documento</th>
          </tr>
        </thead>
        <tbody>
        <?php
          foreach ($listDoc as $valor) 
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
                  <?php echo $valor['fecha_entrada_formateada']; ?>
              </td>
              <td style="text-align: center;" class="project-actions text-left">
                  <?php echo $valor['usuario_completo']; ?>
              </td>
              <td style="text-align: center;" class="project-actions text-left">
                  <?php echo $valor['numero_doc']; ?>
              </td>
              <td style="text-align: center;" class="project-actions text-left">
                  <?php echo $valor['nombre_rem']; ?>
              </td>
              <td style="text-align: center;" class="project-actions text-left">
                  <?php echo $valor['nombre_doc']; ?>
              </td>
              </tr>
      <?php
          }?>
        </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer">
      <div class="d-flex justify-content-center">
        <button type="submit" id="nuevo" data-toggle="modal" class="form-btn primary-default-btn transparent-btn col-2 text-nowrap">Registrar Documento</button>
      </div>
    </div>
  </div>
    </main>
    <!-- ! Footer -->
    <?php include_once "bin/component/footer.php";?>

<script>
// Obtener elementos relevantes del formulario
var tipoDocumentoSelect = document.getElementById('inputTipoDocumento');
var remitenteSelect = document.getElementById('inputRemitente');
var fechaEntradaInput = document.getElementById('inputFecha');
var labelFechaEntrada = document.querySelector('label[for="inputFecha"]');
var labelRemitente = document.querySelector('label[for="inputRemitente"]');

// Función para habilitar o deshabilitar el campo de fecha de entrada y el selector de remitente
function habilitarFechaEntrada() {
    var tipoDocumento = tipoDocumentoSelect.value;

    // Habilitar o deshabilitar fecha de entrada y remitente basado en el tipo de documento seleccionado
    if (tipoDocumento === '1') {
        fechaEntradaInput.value = "";
        remitenteSelect.disabled = "";
        fechaEntradaInput.disabled = false;
        remitenteSelect.disabled = false;
        labelFechaEntrada.classList.remove('d-none');
        labelFechaEntrada.classList.add('d-flex');
        labelRemitente.classList.remove('d-none');
        labelRemitente.classList.add('d-flex');
        fechaEntradaInput.classList.remove('d-none');
        fechaEntradaInput.classList.add('d-flex');
        remitenteSelect.classList.remove('d-none');
        remitenteSelect.classList.add('d-flex');
    } else {
        fechaEntradaInput.value = "";
        remitenteSelect.disabled = "";
        fechaEntradaInput.disabled = true;
        remitenteSelect.disabled = true;
        labelFechaEntrada.classList.remove('d-flex');
        labelFechaEntrada.classList.add('d-none');
        labelRemitente.classList.remove('d-flex');
        labelRemitente.classList.add('d-none');
        fechaEntradaInput.classList.remove('d-flex');
        fechaEntradaInput.classList.add('d-none');
        remitenteSelect.classList.remove('d-flex');
        remitenteSelect.classList.add('d-none');
    }
}
// Escuchar el evento de cambio en el tipo de documento
tipoDocumentoSelect.addEventListener('change', function() {
    habilitarFechaEntrada();
});

// Llamar a la función inicialmente para establecer el estado inicial del formulario
habilitarFechaEntrada();
</script>

  </div>
</div>
<!-- Chart library -->
<script src="plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="content/js/script.js"></script>
<script src="content/js/datatables-docEntrada.js"></script>
<script src="content/js/documentos_entrada.js"></script>
</body>

</html>