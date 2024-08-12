<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class DocumentosEntradaModelo extends connectDB
{

    public function listaDocumentos()
    {
        $resultado = $this->conex->prepare("SELECT *,DATE_FORMAT(documentos.fecha_entrada, '%d/%m/%Y') AS fecha_entrada_formateada, CONCAT(usuarios.cedula, ', ', usuarios.nombres, ' ', usuarios.apellidos) AS usuario_completo FROM documentos,tipos_documentos,remitentes,usuarios WHERE documentos.id_tipo_documento = tipos_documentos.id_tipo_documento AND documentos.id_remitente = remitentes.id_remitente AND documentos.id_usuario = usuarios.id_usuario AND documentos.estatus = '1'");
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

    public function cargarDataSelect()
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
    
    public function registrar_Documentos_Entrada($fecha,$descripcion,$numeroDocumento,$remitent,$tipoDocumento,$id_usuario)
    {
        $validar_registro = $this->validar_registro($numeroDocumento);
        if ($validar_registro) {
            return false;
        } else {
            try {
                $this->conex->query("INSERT INTO documentos(
        					fecha_entrada,
                            descripcion,
                            numero_doc,
        					estatus,
        					id_remitente,
                            id_tipo_documento,
                            id_usuario
        					)
        				VALUES(
                            '$fecha',
        					'$descripcion',
        					'$numeroDocumento',
                            '1',
        					'$remitent',
        					'$tipoDocumento',
                            '$id_usuario'
        				)");
                return true;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function registrar_documento_salida($fecha_salida,$id_documento,$id_destinatario)
    {
        try {
            $this->conex->query("INSERT INTO salidas(
                        fecha_salida,
                        id_documento,
                        id_destinatario
                        )
                    VALUES(
                        '$fecha_salida',
                        '$id_documento',
                        '$id_destinatario'
                    )");
            $this->conex->query("UPDATE documentos SET  estatus = '3' WHERE id_documento  = '$id_documento'");
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function registrar_Documentos_Sin_Entrada($descripcion,$numeroDocumento,$tipoDocumento,$id_usuario)
    {
        $validar_registro = $this->validar_registro($numeroDocumento);
        if ($validar_registro) {
            return false;
        } else {
            try {
                $this->conex->query("INSERT INTO documentos(
                            descripcion,
                            numero_doc,
        					estatus,
                            id_tipo_documento,
                            id_usuario
        					)
        				VALUES(
        					'$descripcion',
        					'$numeroDocumento',
                            '2',
        					'$tipoDocumento',
                            '$id_usuario'
        				)");
                return true;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function eliminar($id_documento)
    {
    try {
        $this->conex->query("DELETE FROM documentos WHERE id_documento = '$id_documento'");
        return true;
    } catch (Exception $e) {
        return false;
    }
    }

    public function cargar($id_documento)
    {
        $resultado = $this->conex->prepare("SELECT *,DATE_FORMAT(documentos.fecha_entrada, '%d/%m/%Y') AS fecha_entrada_formateada, CONCAT(usuarios.cedula, ', ', usuarios.nombres, ' ', usuarios.apellidos) AS usuario_completo FROM documentos,tipos_documentos,remitentes,usuarios WHERE documentos.id_tipo_documento = tipos_documentos.id_tipo_documento AND documentos.id_remitente = remitentes.id_remitente AND documentos.id_usuario = usuarios.id_usuario AND documentos.estatus = '1' AND documentos.id_documento ='$id_documento'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function modificar($id_documento ,$fecha,$descripcion,$numeroDocumento,$remitente,$tipoDocumento,$id_usuario)
    {
        $validar_modificar = $this->validar_modificar($id_documento, $numeroDocumento);
        if ($validar_modificar) {
            return false;
        }else {
            try {
                $this->conex->query("UPDATE documentos SET fecha_entrada = '$fecha', descripcion = '$descripcion', numero_doc = '$numeroDocumento', id_remitente = '$remitente', id_tipo_documento  = '$tipoDocumento', id_usuario   = '$id_usuario' WHERE id_documento  = '$id_documento'");
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
        return $respuesta;
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
    
    public function validar_registro($numeroDocumento)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM documentos WHERE numero_doc='$numeroDocumento'");
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