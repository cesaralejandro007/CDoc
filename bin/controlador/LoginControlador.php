<?php
use modelo\LoginModelo as Login;
use config\componentes\configSistema as configSistema;
session_start();
$config = new configSistema;
$login = new Login;
if (!is_file($config->_Dir_Model_().$pagina.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}
if (is_file("vista/" . $pagina . "Vista.php")) {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if($accion=="ingresar"){
            $usuario = $_POST['usuario'];
            $clave = $_POST['password'];
            if($usuario != "" && $clave != ""){
                $res_usuario = $login->verificar_usuario($usuario,$clave);
                if($res_usuario == true){
                    $info_usuario = $login->datos_usuario($usuario);
                    foreach ($info_usuario as $datos) {
                        $_SESSION['usuario'] = array('id' => $datos['id_usuario'],'cedula' => $datos['cedula'], 'nombres' => $datos['nombres'], 'apellidos' => $datos['apellidos'], 'rol' => $datos['cargo']);
                    }
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => 'Login',
                        'message' => 'Inicio exitoso!'
                    ]);
                    return 0;
                }
                else{
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => 'Login',
                        'message' => 'Verifique sus datos!'
                    ]);
                    return 0;
                }
            }else{
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'error',
                    'title' => 'Login',
                    'message' => 'Ingrese usuario y contraseña!'
                ]);
                return 0;
            }
        }else if ($accion == 'codificarURL') {
            echo configSistema::_PRINCIPAL_();
            return 0;
        }else if($accion=="registrar_usuario"){
            $cedula = $_POST['cedula'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $rol = $_POST['rol'];
            $clave_encriptada = password_hash($_POST['clave'], PASSWORD_DEFAULT);

            $login->set_cedula($cedula);
            $login->set_nombres($nombres);
            $login->set_apellidos($apellidos);
            $login->set_rol($rol);
            $login->set_clave_encriptada($clave_encriptada);
            $response = $login->registrar_usuario();
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
        }else{
            session_destroy();  
        }
    }else {
        session_destroy();
    }
   
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}