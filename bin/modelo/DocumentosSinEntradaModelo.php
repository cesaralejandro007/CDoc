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

    public function listaTipoDocumentos()
    {
        $resultado = $this->conex->prepare("SELECT * FROM tipos_documentos");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function cargarDataSelect()
    {
        $resultado = $this->conex->prepare("SELECT * FROM remitentes");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function eliminar($id_documento,$id_usuario,$accion)
    {
        try {
            $this->conex->query("DELETE FROM documentos WHERE id_documento = '$id_documento'");
            parent::registrar_bitacora($id_usuario,$accion);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function cargar($id_documento)
    {
        $resultado = $this->conex->prepare("SELECT *,DATE_FORMAT(documentos.fecha_entrada, '%d/%m/%Y') AS fecha_entrada_formateada, CONCAT(usuarios.cedula, ', ', usuarios.nombres, ' ', usuarios.apellidos) AS usuario_completo FROM documentos,tipos_documentos,usuarios WHERE documentos.id_tipo_documento = tipos_documentos.id_tipo_documento AND documentos.id_usuario = usuarios.id_usuario AND documentos.estatus = '2' AND documentos.id_documento ='$id_documento'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function modificar($id_documento ,$descripcion,$numeroDocumento,$tipoDocumento,$id_usuario,$accion)
    {
        $validar_modificar = $this->validar_modificar($id_documento, $numeroDocumento);
        if ($validar_modificar) {
            return false;
        }else {
            try {
                $this->conex->query("UPDATE documentos SET descripcion = '$descripcion', numero_doc = '$numeroDocumento', id_tipo_documento  = '$tipoDocumento', id_usuario   = '$id_usuario' WHERE id_documento  = '$id_documento'");
                parent::registrar_bitacora($id_usuario,$accion);
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
        return $respuesta;
    }

    public function migrar_documento_entrada($id_documento,$id_remitente,$fecha_entrada,$id_usuario,$accion)
    {
        try {
            $this->conex->query("UPDATE documentos SET fecha_entrada='$fecha_entrada', id_remitente='$id_remitente', estatus='1' WHERE id_documento = '$id_documento'");
            parent::registrar_bitacora($id_usuario,$accion);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function validar_modificar($id_documento, $numeroDocumento)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM documentos WHERE numero_doc='$numeroDocumento' AND id_documento <>'$id_documento'");
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