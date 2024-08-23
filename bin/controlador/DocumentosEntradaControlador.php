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
            $fechaAccion = date("d-m-Y H:i:s"); // Formato de fecha y hora
            $accion = "$fechaAccion - Registró el documento de entrada con el número de documento: $numeroDocumento";
            
            $response = $DE->registrar_Documentos_Entrada($fecha,$descripcion,$numeroDocumento,$remitente,$tipoDocumento,$id_usuario,$accion);
            if ($response == true) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => 'Registro de Documento',
                    'message' => 'Registro Exitoso.'
                ]);
                return 0;
            }else {
                echo json_encode([
                    'estatus' => '3',
                    'icon' => 'info',
                    'title' => 'Registro de Documento',
                    'message' => 'El registro ya existe.'
                ]);
                return 0;
            }
        }else if($accion=="registrar_documento_sin_entrada"){

            $tipoDocumento = $_POST['tipoDocumento'];
            $numeroDocumento = $_POST['numeroDocumento'];
            $descripcion = $_POST['descripcion'];
            $id_usuario = $_SESSION['usuario']['id'];
            $fechaAccion = date("d-m-Y H:i:s"); // Formato de fecha y hora
            $accion = "$fechaAccion - Registró el documento de sin entrada con el número de documento: $numeroDocumento";

            $response = $DE->registrar_Documentos_Sin_Entrada($descripcion,$numeroDocumento,$tipoDocumento,$id_usuario,$accion);
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
        }else if ($accion == 'eliminar') {
            $numeroDocumento = $_POST['numeroDocumento'];
            $id_usuario = $_SESSION['usuario']['id'];
            $fechaAccion = date("d-m-Y H:i:s"); // Formato de fecha y hora
            $accion = "$fechaAccion - Eliminó el documento de entrada con el número de documento: $numeroDocumento";

            $response = $DE->eliminar($_POST['id_documento'],$id_usuario,$accion);
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
        } else if ($accion == 'editar') {
            $datos = $DE->cargar($_POST['id_documento']);
            foreach ($datos as $valor) {
                echo json_encode([
                    'id_documento' => $valor['id_documento'],
                    'numero_doc' => $valor['numero_doc'],
                    'fecha_entrada' => $valor['fecha_entrada'],
                    'nombre_doc' => $valor['nombre_doc'],
                    'nombre_rem' => $valor['nombre_rem'],
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
                $fecha = $_POST['fecha'];
                $remitente = $_POST['remitente'];
                $descripcion = $_POST['descripcion'];
                $id_usuario = $_SESSION['usuario']['id'];
                $fechaAccion = date("d-m-Y H:i:s"); // Formato de fecha y hora
                $accion = "$fechaAccion - Modificó el documento de entrada con el número de documento: $numeroDocumento";

                $response = $DE->modificar($id_documento,$fecha,$descripcion,$numeroDocumento,$remitente,$tipoDocumento,$id_usuario,$accion);
                if ($response) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => 'Modificar Documento',
                        'message' => 'Modificación exitosa.'
                    ]);
                }else {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => 'Modificar Documento',
                        'message' => 'El Documento ya se encuetra registrado.'
                    ]);
                }
                return 0;
                exit;
            }else if ($accion == 'buscarData') {
                $datos = $DE->cargarDataSelect();
                echo json_encode($datos);
                return 0;
            }else if($accion=="migrar_documento"){

                $fecha_salida = $_POST['fecha_salida'];
                $id_documento = $_POST['id_documento'];
                $id_destinatario = $_POST['id_destinatario'];
                $numeroDocumento = $_POST['numeroDocumento'];
                $id_usuario = $_SESSION['usuario']['id'];
                $fechaAccion = date("d-m-Y H:i:s"); // Formato de fecha y hora
                $accion = "$fechaAccion - Migró el documento de entrada a los documentos de salida con el número de documento: $numeroDocumento";
                
                $response = $DE->registrar_documento_salida($fecha_salida,$id_documento,$id_destinatario,$id_usuario,$accion);
                if ($response == true) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => 'Registro de Documentos de Salida',
                        'message' => 'Registro Exitoso.',
                        'url' => configSistema::_docSilida_()
                    ]);
                    return 0;
                }else {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => 'Registro de Documentos de Salida',
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