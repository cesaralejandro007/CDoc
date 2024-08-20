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
        if($accion=="registrar_secciones"){
            $cedula = $_POST['cedula'];
            $nombres = $_POST['inputNombres'];
            $apellidos = $_POST['inputApellidos'];
            $rol = $_POST['rol'];
            $sexo = $_POST['inputSexo'];
            $clave_encriptada = password_hash($_POST['inputPassword'], PASSWORD_DEFAULT);
            $seccion = $_POST['seccion'];

            $response = $secciones->registrar_secciones($cedula,$nombres,$apellidos,$rol,$sexo,$clave_encriptada,$seccion);
            if ($response == true) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => 'secciones',
                    'message' => 'Registro Exitoso.'
                ]);
                return 0;
            }else {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => 'secciones',
                    'message' => 'El secciones ya está registrado.'
                ]);
                return 0;
            }
        }else if($accion=="eliminar"){
            $response = $secciones->eliminar($_POST['id_secciones']);
            if ($response) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => 'Eliminar secciones',
                    'message' => 'Registro Eliminado'
                ]);
            }else{
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'error',
                    'title' => 'Eliminar secciones',
                    'message' => 'Registro No Fue Eliminado'
                ]);
            }
        
            return 0;
            exit;
        } else if ($accion == 'editar') {
            $datos = $secciones->cargar($_POST['id_persona']);
            foreach ($datos as $valor) {
                echo json_encode([
                    'id_persona' => $valor['id_secciones'],
                    'cedula' => $valor['cedula'],
                    'nombres' => $valor['nombres'],
                    'apellidos' => $valor['apellidos'],
                    'rol' => $valor['rol'],
                    'sexo' => $valor['sexo'],
                    'id_seccion' => $valor['nombre_seccion']
                ]);
            }
            return 0;
        }else if ($accion == 'modificar') {
            $id_secciones = $_POST['id'];
            $cedula = $_POST['cedula'];
            $nombres = $_POST['inputNombres'];
            $apellidos = $_POST['inputApellidos'];
            $rol = $_POST['rol'];
            $sexo = $_POST['inputSexo'];
            $clave_encriptada = password_hash($_POST['inputPassword'], PASSWORD_DEFAULT);
            $seccion = $_POST['seccion'];
            $response = $secciones->modificar($id_secciones,$cedula,$nombres,$apellidos,$rol,$sexo,$clave_encriptada,$seccion);
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
   
    $list = $secciones->listar_secciones();

    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}