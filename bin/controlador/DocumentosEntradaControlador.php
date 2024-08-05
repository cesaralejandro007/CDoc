<?php
use modelo\DocumentosEntradaModelo as DocumentosEntrada;
use config\componentes\configSistema as configSistema;

$config = new configSistema;
$DE = new DocumentosEntrada();
session_start();
if (!isset($_SESSION['usuario'])) {
	$redirectUrl = '?pagina=' . configSistema::_INICIO_();
    echo '<script>window.location="' . $redirectUrl . '"</script>';
    die();
}
if (!is_file($config->_Dir_Model_().$pagina.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}
if (is_file("vista/" . $pagina . "Vista.php")) {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if($accion=="registrar_documento_entrada"){

            $tipoDocumento = $_POST['tipoDocumento'];
            $numeroDocumento = $_POST['numeroDocumento'];
            $fecha = $_POST['fecha'];
            $remitente = $_POST['remitente'];
            $descripcion = $_POST['descripcion'];
            $id_usuario = $_SESSION['usuario']['id'];

            $response = $DE->registrar_Documentos_Entrada($fecha,$descripcion,$numeroDocumento,$remitente,$tipoDocumento,$id_usuario);
            if ($response == true) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => 'Registro de Documentos',
                    'message' => 'Registro Exitoso.'
                ]);
                return 0;
            }else {
                echo json_encode([
                    'estatus' => '3',
                    'icon' => 'info',
                    'title' => 'Registro de Documentos',
                    'message' => 'El registro ya existe.'
                ]);
                return 0;
            }
        }else if($accion=="registrar_documento_sin_entrada"){

            $tipoDocumento = $_POST['tipoDocumento'];
            $numeroDocumento = $_POST['numeroDocumento'];
            $descripcion = $_POST['descripcion'];
            $id_usuario = $_SESSION['usuario']['id'];

            $response = $DE->registrar_Documentos_Sin_Entrada($descripcion,$numeroDocumento,$tipoDocumento,$id_usuario);
            if ($response == true) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'success',
                    'title' => 'Registro de Documentos Sin Entrada',
                    'message' => 'Registro Exitoso.',
                    'url' => configSistema::_docSinEntrada_()
                ]);
                return 0;
            }else {
                echo json_encode([
                    'estatus' => '3',
                    'icon' => 'info',
                    'title' => 'Registro de Documentos Sin Entrada',
                    'message' => 'El registro ya existe.'
                ]);
                return 0;
            }
        }
    }
    $listDoc = $DE->listaDocumentos();
    $listTDoc = $DE->listaTipoDocumentos();
    $listRemit = $DE->listaRemitentes();
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}