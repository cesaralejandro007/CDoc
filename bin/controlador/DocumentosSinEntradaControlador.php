<?php
use modelo\DocumentosSinEntradaModelo as DocumentosSinEntrada;
use config\componentes\configSistema as configSistema;

$config = new configSistema;
$DSE = new DocumentosSinEntrada();
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
        if ($accion == 'eliminar') {
            $response = $DSE->eliminar($_POST['id_documento']);
            if ($response) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => 'Eliminar Documentos',
                    'message' => 'Registro Eliminado'
                ]);
            }else{
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'error',
                    'title' => 'Eliminar Documentos',
                    'message' => 'Registro No Fue Eliminado'
                ]);
            }
            return 0;
            exit;
        }else if ($accion == 'editar') {
            $datos = $DSE->cargar($_POST['id_documento']);
            foreach ($datos as $valor) {
                echo json_encode([
                    'id_documento' => $valor['id_documento'],
                    'numero_doc' => $valor['numero_doc'],
                    'nombre_doc' => $valor['nombre_doc'],
                    'descripcion' => $valor['descripcion'],
                    'usuario_completo' => $valor['usuario_completo'],
                    'cedula' => $valor['cedula']
                ]);
            }
            return 0;
        }else if ($accion == 'modificar') {
            $id_documento = $_POST['id_documento'];
            $tipoDocumento = $_POST['tipoDocumento'];
            $numeroDocumento = $_POST['numeroDocumento'];
            $descripcion = $_POST['descripcion'];
            $id_usuario = $_SESSION['usuario']['id'];

            $response = $DSE->modificar($id_documento ,$descripcion,$numeroDocumento,$tipoDocumento,$id_usuario);
            if ($response) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => 'Modificar Documento',
                    'message' => 'Modificación exitosa.'
                ]);
            }else {
                echo json_encode([
                    'estatus' => '3',
                    'icon' => 'info',
                    'title' => 'Modificar Documento',
                    'message' => 'El Documento ya se encuetra registrado.'
                ]);
            }
            return 0;
            exit;
        }else if ($accion == 'buscarData') {
            $datos = $DSE->cargarDataSelect();
            echo json_encode($datos);
            return 0;
        }else if($accion=="migrar_documento_entrada"){
            $id_documento = $_POST['id_documento'];
            $id_remitente = $_POST['id_remitente'];
            $fecha_entrada = $_POST['fecha_entrada'];
            $response = $DSE->migrar_documento_entrada($id_documento,$id_remitente,$fecha_entrada);
            if ($response == true) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => 'Registro de Documentos de entrada',
                    'message' => 'Registro Exitoso.',
                    'url' => configSistema::_docEntrada_()
                ]);
                return 0;
            }else {
                echo json_encode([
                    'estatus' => '3',
                    'icon' => 'info',
                    'title' => 'Registro de Documentos de entrada',
                    'message' => 'El registro no se completo.'
                ]);
                return 0;
            }
        }
    }
    $listTDoc = $DSE->listaTipoDocumentos();
    $listDocSinEntr = $DSE->listaDocumentosSinEntrada();
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}