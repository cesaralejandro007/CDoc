<?php
use modelo\DocumentosSalidaModelo as DocumentosSalida;
use config\componentes\configSistema as configSistema;

$config = new configSistema;
$DS = new DocumentosSalida();
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
            $response = $DS->eliminar_salida($_POST['id_salida']);
            $response1 = $DS->eliminar($_POST['id_documento']);
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
            $datos = $DS->cargar($_POST['id_documento']);
            foreach ($datos as $valor) {
                echo json_encode([
                    'id_documento' => $valor['id_documento'],
                    'id_salida' => $valor['id_salida'],
                    'numero_doc' => $valor['numero_doc'],
                    'fecha_entrada' => $valor['fecha_entrada'],
                    'fecha_salida' => $valor['fecha_salida'],
                    'nombre_doc' => $valor['nombre_doc'],
                    'nombre_rem' => $valor['nombre_rem'],
                    'destinatario' => $valor['nombre_des'],
                    'descripcion' => $valor['descripcion'],
                    'usuario_completo' => $valor['usuario_completo'],
                    'cedula' => $valor['cedula']
                ]);
            }
            return 0;
        }else if ($accion == 'modificar') {
            $id_documento = $_POST['id_documento'];
            $id_salida = $_POST['id_salida'];
            $tipoDocumento = $_POST['tipoDocumento'];
            $numeroDocumento = $_POST['numeroDocumento'];
            $fecha = $_POST['fecha'];
            $fecha_salida = $_POST['fecha_s'];
            $remitente = $_POST['remitente'];
            $destinatario = $_POST['destinario'];
            $descripcion = $_POST['descripcion'];
            $id_usuario = $_SESSION['usuario']['id'];

            $response = $DS->modificar($id_documento,$id_salida,$fecha,$fecha_salida,$destinatario,$descripcion,$numeroDocumento,$remitente,$tipoDocumento,$id_usuario);
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
        }else if($accion=="migrar_documento_entrada"){

            $id_documento = $_POST['id_documento'];
            $id_salida = $_POST['id_salida'];
            $response = $DS->migrar_documento_entrada($id_documento,$id_salida);
            if ($response == true) {
                echo json_encode([
                    'estatus' => '2',
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
    $listDestinarios = $DS->listaDestinatarios();
    $listDocSal = $DS->listaDocumentosSalida();
    $listTDoc = $DS->listaTipoDocumentos();
    $listRemit = $DS->listaRemitentes();
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}