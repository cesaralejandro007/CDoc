<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class loginModelo extends connectDB
{
    private $cedula;
    private $nombres;
    private $apellidos;
    private $rol;
    private $sexo;
    private $password;
    private $seccion;
    public function set_cedula($valor)
    {
        $this->cedula = $valor;
    }
    public function set_nombres($valor)
    {
        $this->nombres = $valor;
    }
    public function set_apellidos($valor)
    {
        $this->apellidos = $valor;
    }
    public function set_rol($valor)
    {
        $this->rol = $valor;
    }
    public function set_sexo($valor)
    {
        return $this->sexo = $valor;
    }
    public function set_clave($valor)
    {
        $this->password = $valor;
    }
    public function set_clave_encriptada($valor)
    {
        $this->password = $valor;
    }
    public function set_seccion($valor)
    {
        $this->seccion = $valor;
    }

    public function registrar_usuario()
    {
        $validar_registro = $this->validar_registro($this->cedula);
        if ($validar_registro) {
            return false;
        } else {
            try {
                $this->conex->query("INSERT INTO usuarios(
        					cedula,
                            nombres,
                            apellidos,
                            rol,
        					sexo,
        					contrasena,
                            id_seccion,
                            estatus
        					)
        				VALUES(
                            '$this->cedula',
        					'$this->nombres',
        					'$this->apellidos',
                            '$this->rol',
        					'$this->sexo',
        					'$this->password',
                            '$this->seccion',
                            '1'
        				)");
                return true;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function verificar_usuario($usuario,$password,$accion)
    {
        $resultado = $this->conex->prepare("SELECT * FROM usuarios WHERE cedula ='$usuario'");
        try {
            $resultado->execute();
            $respuesta1 = $resultado->fetchAll();
            if (!empty($respuesta1)) {
                if(password_verify($password, $respuesta1[0]['contrasena'])) {
                    parent::registrar_bitacora($respuesta1[0]['id_usuario'],$accion);
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (Exception $e) {
                return $e->getMessage();
        }
    }

    public function datos_usuario($cedula)
    {
        $resultado = $this->conex->prepare("SELECT * FROM usuarios WHERE cedula ='$cedula'");
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }
    
    public function validar_registro($cedula)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM usuarios WHERE cedula='$cedula'");
            $resultado->execute();
            $fila = $resultado->fetchAll();
            if ($fila) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function listar_secciones()
    {
        $resultado = $this->conex->prepare("SELECT * FROM secciones");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function cerrar_sesion($id_usuario,$accion)
    {
        parent::registrar_bitacora($id_usuario,$accion);
    }

    public function actualizar_contrasena($id_usuario,$clave_encriptada,$accion)
    {
        try {
            $this->conex->query("UPDATE usuarios SET contrasena = '$clave_encriptada' WHERE id_usuario  = '$id_usuario'");
            parent::registrar_bitacora($id_usuario,$accion);
            return true;
        } catch (Exception $e) {
            return false;
        }
        return $respuesta;
    }

}