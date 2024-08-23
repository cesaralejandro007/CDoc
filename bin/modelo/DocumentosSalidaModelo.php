<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class DocumentosSalidaModelo extends connectDB
{
    public function listaDocumentosSalida()
    {
        $resultado = $this->conex->prepare("SELECT *, DATE_FORMAT(documentos.fecha_entrada, '%d/%m/%Y') AS fecha_entrada_formateada, DATE_FORMAT(salidas.fecha_salida, '%d/%m/%Y') AS fecha_salida_formateada, CONCAT(usuarios.cedula, ', ', usuarios.nombres, ' ', usuarios.apellidos) AS usuario_completo, documentos.fecha_entrada, salidas.fecha_salida, DATEDIFF(salidas.fecha_salida, documentos.fecha_entrada) AS diferencia_dias FROM documentos JOIN tipos_documentos ON documentos.id_tipo_documento = tipos_documentos.id_tipo_documento JOIN remitentes ON documentos.id_remitente = remitentes.id_remitente JOIN usuarios ON documentos.id_usuario = usuarios.id_usuario JOIN salidas ON documentos.id_documento = salidas.id_documento JOIN destinatarios ON salidas.id_destinatario = destinatarios.id_destinatario WHERE documentos.estatus = '3'");
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

    public function listaRemitentes()
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

    public function listaDestinatarios()
    {
        $resultado = $this->conex->prepare("SELECT * FROM destinatarios");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function eliminar_salida($id_salida)
    {
        try {
            $this->conex->query("DELETE FROM salidas WHERE id_salida = '$id_salida'");
            return true;
        } catch (Exception $e) {
            return false;
        }
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
        $resultado = $this->conex->prepare("SELECT *, DATE_FORMAT(documentos.fecha_entrada, '%d/%m/%Y') AS fecha_entrada_formateada, DATE_FORMAT(salidas.fecha_salida, '%d/%m/%Y') AS fecha_salida_formateada, CONCAT(usuarios.cedula, ', ', usuarios.nombres, ' ', usuarios.apellidos) AS usuario_completo, documentos.fecha_entrada, salidas.fecha_salida, DATEDIFF(salidas.fecha_salida, documentos.fecha_entrada) AS diferencia_dias FROM documentos JOIN tipos_documentos ON documentos.id_tipo_documento = tipos_documentos.id_tipo_documento JOIN remitentes ON documentos.id_remitente = remitentes.id_remitente JOIN usuarios ON documentos.id_usuario = usuarios.id_usuario JOIN salidas ON documentos.id_documento = salidas.id_documento JOIN destinatarios ON salidas.id_destinatario = destinatarios.id_destinatario WHERE documentos.estatus = '3' AND documentos.id_documento ='$id_documento'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    
    public function modificar($id_documento,$id_salida,$fecha,$fecha_salida,$destinatario,$descripcion,$numeroDocumento,$remitente,$tipoDocumento,$id_usuario,$accion)
    {
        $validar_modificar = $this->validar_modificar($id_documento, $numeroDocumento);
        if ($validar_modificar) {
            return false;
        }else {
            try {
                $this->conex->query("UPDATE documentos SET fecha_entrada = '$fecha', descripcion = '$descripcion', numero_doc = '$numeroDocumento', id_remitente = '$remitente', id_tipo_documento  = '$tipoDocumento', id_usuario   = '$id_usuario' WHERE id_documento  = '$id_documento'");
                $this->conex->query("UPDATE salidas SET fecha_salida = '$fecha_salida', id_destinatario = '$destinatario' WHERE id_salida  = '$id_salida'");
                parent::registrar_bitacora($id_usuario,$accion);
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
        return $respuesta;
    }

    public function migrar_documento_entrada($id_documento,$id_salida,$id_usuario,$accion)
    {
        try {
            $this->conex->query("UPDATE documentos SET estatus='1' WHERE id_documento = '$id_documento'");
            $this->conex->query("DELETE FROM salidas WHERE id_salida = '$id_salida'");
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