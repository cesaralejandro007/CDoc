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
}