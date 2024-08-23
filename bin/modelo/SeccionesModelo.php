<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class SeccionesModelo extends connectDB
{

    public function listar_usuario()
    {
        $usuarios = [];
        $metas = [];
    
        try {
            // Primera consulta: obtener todos los usuarios activos
            $resultadoUsuarios = $this->conex->prepare("
                SELECT *
                FROM usuarios 
                JOIN secciones ON secciones.id_seccion = usuarios.id_seccion 
                WHERE usuarios.estatus = '1'
            ");
            $resultadoUsuarios->execute();
            $usuarios = $resultadoUsuarios->fetchAll();
    
            // Consulta de metas para cada usuario
            foreach ($usuarios as $usuario) {
                $cedula = $usuario['cedula'];
                $resultadoMetas = $this->conex->prepare("
                    SELECT MONTH(meta.fecha) as mes, meta.meta 
                    FROM usuarios
                    JOIN secciones ON secciones.id_seccion = usuarios.id_seccion
                    JOIN seccionesxmeta ON secciones.id_seccion = seccionesxmeta.id_seccion
                    JOIN meta ON seccionesxmeta.id_meta = meta.id_meta
                    WHERE usuarios.cedula = $cedula
                ");
                $resultadoMetas->execute();
                $metas[$cedula] = $resultadoMetas->fetchAll();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    
        // Combinar los resultados
        foreach ($usuarios as &$usuario) {
            $cedula = $usuario['cedula'];
            $usuario['metas'] = $metas[$cedula] ?? [];
        }
    
        return $usuarios;
    }
    

    public function listar_secciones()
    {
        $resultado = $this->conex->prepare("
            SELECT 
                secciones.id_seccion AS id_seccion,
                secciones.nombre_seccion AS nombre_seccion, 
                secciones.cantidad_documentos AS total_documentos, 
                COUNT(documentos.id_documento) AS cantidad_documentos,
                (COUNT(documentos.id_documento) / secciones.cantidad_documentos) * 100 AS porcentaje_documentos
            FROM 
                secciones
            JOIN 
                usuarios ON secciones.id_seccion = usuarios.id_seccion
            JOIN 
                documentos ON usuarios.id_usuario = documentos.id_usuario
            GROUP BY 
                secciones.id_seccion, 
                secciones.nombre_seccion, 
                secciones.cantidad_documentos;
        ");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function cargar($id_seccion)
    {
        $resultado = $this->conex->prepare("SELECT * FROM secciones WHERE id_seccion = '$id_seccion'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }
    
    public function cargar_meta()
    {
        $año = date('Y');
        $mesActual = date('n'); 
        $resultado = $this->conex->prepare("SELECT meta.meta FROM meta,seccionesxmeta WHERE meta.id_meta = seccionesxmeta.id_meta AND YEAR(seccionesxmeta.fecha) = $año AND MONTH(seccionesxmeta.fecha) = $mesActual GROUP BY meta.meta");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function modificar($id_seccion,$cantidad,$id_usuario,$accion)
    {
            try {
                $this->conex->query("UPDATE secciones SET cantidad_documentos = '$cantidad' WHERE id_seccion  = '$id_seccion'");
                parent::registrar_bitacora($id_usuario,$accion);
                return true;
            } catch (Exception $e) {
                return false;
            }
        return $respuesta;
    }

    public function modificar_meta($meta,$id_usuario,$accion)
    {
            $año = date('Y');
            $mesActual = date('n'); 
            try {
                $this->conex->query("
                    UPDATE meta 
                    JOIN seccionesxmeta 
                    ON meta.id_meta = seccionesxmeta.id_meta 
                    SET meta.meta = $meta 
                    WHERE YEAR(seccionesxmeta.fecha) = $año 
                    AND MONTH(seccionesxmeta.fecha) = $mesActual;
                ");
                parent::registrar_bitacora($id_usuario,$accion);
                return true;
            } catch (Exception $e) {
                return false;
            }
        return $respuesta;
    }

}