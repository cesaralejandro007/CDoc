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

    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}