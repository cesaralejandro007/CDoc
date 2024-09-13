<?php
use modelo\BitacoraSistemaModelo as Bitacora;
use config\componentes\configSistema as configSistema;
use modelo\LoginModelo as Login;

$config = new configSistema;
$bitacora = new Bitacora;
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
        $accion =$_POST['accion'];
        if ($accion == 'actualizar_clave') {
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

    $list = $bitacora->listarBitacoraSistema();

    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}