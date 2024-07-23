<?php
use modelo\ConsultarUsuarioModelo as ConsultarUsuario;
use config\componentes\configSistema as configSistema;

$config = new configSistema;
$Usuario = new ConsultarUsuario;
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
    $list = $Usuario->listar_usuario();
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}