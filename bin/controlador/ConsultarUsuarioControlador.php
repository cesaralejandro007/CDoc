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
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if($accion=="registrar_usuario"){
            $cedula = $_POST['cedula'];
            $nombres = $_POST['inputNombres'];
            $apellidos = $_POST['inputApellidos'];
            $rol = $_POST['rol'];
            $sexo = $_POST['inputSexo'];
            $clave_encriptada = password_hash($_POST['inputPassword'], PASSWORD_DEFAULT);
            $seccion = $_POST['seccion'];

            $response = $Usuario->registrar_usuario($cedula,$nombres,$apellidos,$rol,$sexo,$clave_encriptada,$seccion);
            if ($response == true) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => 'Usuario',
                    'message' => 'Registro Exitoso.'
                ]);
                return 0;
            }else {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => 'Usuario',
                    'message' => 'El Usuario ya está registrado.'
                ]);
                return 0;
            }
        }else if($accion=="eliminar"){
            $response = $Usuario->eliminar($_POST['id_usuario']);
            if ($response) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => 'Eliminar Usuario',
                    'message' => 'Registro Eliminado'
                ]);
            }else{
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'error',
                    'title' => 'Eliminar Usuario',
                    'message' => 'Registro No Fue Eliminado'
                ]);
            }
        
            return 0;
            exit;
        } else if ($accion == 'editar') {
            $datos = $Usuario->cargar($_POST['id_persona']);
            foreach ($datos as $valor) {
                echo json_encode([
                    'id_persona' => $valor['id_usuario'],
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
            $id_usuario = $_POST['id'];
            $cedula = $_POST['cedula'];
            $nombres = $_POST['inputNombres'];
            $apellidos = $_POST['inputApellidos'];
            $rol = $_POST['rol'];
            $sexo = $_POST['inputSexo'];
            $clave_encriptada = password_hash($_POST['inputPassword'], PASSWORD_DEFAULT);
            $seccion = $_POST['seccion'];
            $response = $Usuario->modificar($id_usuario,$cedula,$nombres,$apellidos,$rol,$sexo,$clave_encriptada,$seccion);
            if ($response) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => 'Modificar Usuario',
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

    $list = $Usuario->listar_secciones();
    $list = $Usuario->listar_usuario();
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}