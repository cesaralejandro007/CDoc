<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class DocumentosSinEntradaModelo extends connectDB
{

    public function listaDocumentosSinEntrada()
    {
        $resultado = $this->conex->prepare("SELECT *, CONCAT(usuarios.cedula, ', ', usuarios.nombres, ' ', usuarios.apellidos) AS usuario_completo FROM documentos,tipos_documentos,usuarios WHERE documentos.id_tipo_documento = tipos_documentos.id_tipo_documento AND documentos.id_usuario = usuarios.id_usuario AND documentos.estatus = '2'");
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