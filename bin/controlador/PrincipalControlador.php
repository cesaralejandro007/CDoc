<?php
use modelo\PrincipalModelo as Principal;
use modelo\LoginModelo as Login;
use config\componentes\configSistema as configSistema;

$config = new configSistema;
$principal = new Principal();
$login = new Login;
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
            $resultado = $principal->comprobar_meta($_SESSION['usuario']['seccion']);
            if($resultado == false){
                echo 1;
            }else{
                echo 0;
            }
            return 0;
            exit;
        }else if ($accion == 'comprobar_meta_user') {
            $resultado = $principal->comprobar_meta_user();
            if($resultado == true){
                echo 1;
            }else{
                echo 0;
            }
            return 0;
            exit;
        }else if ($accion == 'registrar_meta_mes') {
            $id_usuario = $_SESSION['usuario']['id'];
            $fechaAccion = date("d-m-Y H:i:s"); // Formato de fecha y hora
            $mes = date('m');
            $meta = $_POST['meta'];
            $accion = "$fechaAccion - Registró la meta general del mes $mes con un valor: $meta";
            $resultado = $principal->registrar_meta_mes($_POST['fecha'],$meta,$_SESSION['usuario']['seccion'],$id_usuario,$accion);
            if($resultado){
                echo true;
            }else{
                echo false;
            }
            return 0;
            exit;
        }else if ($accion == 'registrar_meta_mes_user') {
            $resultado = $principal->registrar_meta_mes_user($_POST['fecha'],$_SESSION['usuario']['seccion']);
            if($resultado){
                echo true;
            }else{
                echo false;
            }
            return 0;
            exit;
        }else if ($accion == 'actualizar_clave') {
            $id_usuario = $_SESSION['usuario']['id'];
            $fechaAccion = date("d-m-Y H:i:s"); // Formato de fecha y hora
            $accion = "$fechaAccion - Cambió su contraseña";
            $clave_encriptada = password_hash($_POST['clave'], PASSWORD_DEFAULT);
            $resultado = $login->actualizar_contrasena($_SESSION['usuario']['id'],$clave_encriptada,$accion);
            if($resultado){
                echo json_encode([
                    'estatus' => 1
                ]);
            }
            return 0;
            exit;
        }
        
    }

    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}