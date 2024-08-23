<?php
use modelo\HistorialModelo as Historial;
use config\componentes\configSistema as configSistema;

$config = new configSistema;
$historial = new Historial;
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
    }

    $list = $historial->listar_historial();
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}