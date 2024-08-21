<?php
use modelo\SeccionesModelo as Secciones;
use config\componentes\configSistema as configSistema;

$config = new configSistema;
$secciones = new Secciones;
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
        if ($accion == 'editar') {
            $datos = $secciones->cargar($_POST['id_seccion']);
            foreach ($datos as $valor) {
                echo json_encode([
                    'id_seccion' => $valor['id_seccion'],
                    'nombre_seccion' => $valor['nombre_seccion'],
                    'cantidad_documentos' => $valor['cantidad_documentos']
                ]);
            }
            return 0;
        }else if ($accion == 'modificar') {
            $id_seccion = $_POST['id'];
            $cantidad = $_POST['cantidad'];
            $response = $secciones->modificar($id_seccion,$cantidad);
            if ($response) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => 'Modificar secciones',
                    'message' => 'Modificación exitosa.'
                ]);
            }else {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => 'Modificar modificar',
                    'message' => 'El Documento ya se encuetra registrado.'
                ]);
            }
            return 0;
            exit;
        }
    }

    $list = $secciones->listar_secciones();

    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}