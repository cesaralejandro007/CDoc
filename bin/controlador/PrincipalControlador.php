<?php
use modelo\PrincipalModelo as Principal;
use config\componentes\configSistema as configSistema;

$config = new configSistema;
$principal = new Principal();
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
        if ($accion == 'reporte_doc') {
            $datos = $principal->reporte_documentos();
            echo json_encode($datos);
            return 0;
            exit;
        }else if ($accion == 'comprobar_meta') {
            $resultado = $principal->comprobar_meta();
            if($resultado == false){
                echo 1;
            }else{
                echo 0;
            }
            return 0;
            exit;
        }else if ($accion == 'registrar_meta_mes') {
            $resultado = $principal->registrar_meta_mes($_POST['fecha'],$_POST['meta']);
            if($resultado){
                echo true;
            }else{
                echo false;
            }
            return 0;
            exit;
        }
        
    }

    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}