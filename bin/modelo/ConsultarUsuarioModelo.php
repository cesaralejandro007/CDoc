<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class ConsultarUsuarioModelo extends connectDB
{
    public function registrar_usuario($cedula,$nombres,$apellidos,$sexo,$clave_encriptada,$seccion)
    {
        $validar_registro = $this->validar_registro($cedula);
        if ($validar_registro) {
            return false;
        } else {
            try {
                $this->conex->query("INSERT INTO usuarios(
        					cedula,
                            nombres,
                            apellidos,
        					sexo,
        					contrasena,
                            id_seccion,
                            estatus
        					)
        				VALUES(
                            '$cedula',
        					'$nombres',
        					'$apellidos',
        					'$sexo',
        					'$clave_encriptada',
                            '$seccion',
                            '1'
        				)");
                return true;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function listar_usuario()
    {
        $resultado = $this->conex->prepare("SELECT * FROM usuarios,secciones WHERE secciones.id_seccion = usuarios.id_seccion AND usuarios.estatus ='1'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
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

    public function eliminar($id_usuario)
    {
        try {
            $this->conex->query("UPDATE usuarios SET estatus='0' WHERE id_usuario = '$id_usuario'");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function cargar($id_usuario)
    {
        $resultado = $this->conex->prepare("SELECT * FROM usuarios,secciones WHERE usuarios.id_seccion = secciones.id_seccion AND usuarios.id_usuario ='$id_usuario'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function modificar($id_usuario,$cedula,$nombres,$apellidos,$sexo,$clave_encriptada,$seccion)
    {
        $validar_modificar = $this->validar_modificar($id_usuario, $cedula);
        if ($validar_modificar) {
            return false;
        }else {
            try {
                $this->conex->query("UPDATE usuarios SET cedula = '$cedula', nombres = '$nombres', apellidos = '$apellidos', sexo = '$sexo', contrasena = '$clave_encriptada', id_seccion = '$seccion' WHERE id_usuario  = '$id_usuario'");
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
        return $respuesta;
    }

    public function validar_modificar($id_usuario, $cedula)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM usuarios WHERE cedula='$cedula' AND id_usuario <>'$id_usuario'");
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

}