<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class ConsultarUsuarioModelo extends connectDB
{
    public function listar_usuario()
    {
        $resultado = $this->conex->prepare("SELECT * FROM usuarios,secciones WHERE secciones.id_seccion = usuarios.id_seccion");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }
}