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
                $fechaAccion = date("d-m-Y H:i:s"); // Formato de fecha y hora
                $accion = "$fechaAccion -  Inició sesión en el sistema.";
                $res_usuario = $login->verificar_usuario($usuario,$clave,$accion);
                if($res_usuario == true){
                    $info_usuario = $login->datos_usuario($usuario);
                    if($info_usuario[0]['estatus']==1){
                        foreach ($info_usuario as $datos) {
                            $_SESSION['usuario'] = array('id' => $datos['id_usuario'],'cedula' => $datos['cedula'], 'nombres' => $datos['nombres'], 'apellidos' => $datos['apellidos'], 'rol' => $datos['rol'],'sexo' => $datos['sexo'], 'seccion' => $datos['id_seccion']);
                        }
                        echo json_encode([
                            'estatus' => '1',
                            'icon' => 'success',
                            'title' => 'Login',
                            'message' => 'Inicio exitoso!'
                        ]);
                        return 0;                         
                    }else{
                        echo json_encode([
                            'estatus' => '2',
                            'icon' => 'info',
                            'title' => 'Login',
                            'message' => 'La persona esta deshabilitada!'
                        ]);
                        return 0;
                    }
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
            $sexo = $_POST['sexo'];
            $clave_encriptada = password_hash($_POST['clave'], PASSWORD_DEFAULT);
            $seccion = $_POST['seccion'];

            $login->set_cedula($cedula);
            $login->set_nombres($nombres);
            $login->set_apellidos($apellidos);
            $login->set_rol($rol);
            $login->set_sexo($sexo);
            $login->set_clave_encriptada($clave_encriptada);
            $login->set_seccion($seccion);
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
            if (isset($_SESSION['usuario'])) {
                $id_usuario = $_SESSION['usuario']['id'];
                $fechaAccion = date("d-m-Y H:i:s"); // Formato de fecha y hora
                $accion = "$fechaAccion -  Cerró sesión en el sistema.";
                $login->cerrar_sesion($id_usuario,$accion);
            }
            session_destroy();  
        }
    }else {
        if (isset($_SESSION['usuario'])) {
            $id_usuario = $_SESSION['usuario']['id'];
            $fechaAccion = date("d-m-Y H:i:s"); // Formato de fecha y hora
            $accion = "$fechaAccion -  Cerró sesión en el sistema.";
            $login->cerrar_sesion($id_usuario,$accion);
        }
        session_destroy();
    }
    $list = $login->listar_secciones();
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}