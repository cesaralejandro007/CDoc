<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class PrincipalModelo extends connectDB
{
    public function count_doc_entrada()
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM documentos WHERE estatus=1");
            $resultado->execute();
            $numero_filas = $resultado->rowCount(); 
            return $numero_filas;
        } catch (Exception $e) {

            return 0; 
        }
    }  

    public function count_doc_salida()
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM documentos WHERE estatus=3");
            $resultado->execute();
            $numero_filas = $resultado->rowCount(); 
            return $numero_filas;
        } catch (Exception $e) {

            return 0; 
        }
    }    
    public function count_doc_sin_entrada()
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM documentos WHERE estatus=2");
            $resultado->execute();
            $numero_filas = $resultado->rowCount(); 
            return $numero_filas;
        } catch (Exception $e) {

            return 0; 
        }
    }    
    public function count_doc_total()
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM documentos");
            $resultado->execute();
            $numero_filas = $resultado->rowCount(); 
            return $numero_filas;
        } catch (Exception $e) {

            return 0; 
        }
    }   

    public function comprobar_meta($id_seccion)
    {
        $año = date('Y');
        $mesActual = date('n'); // Obtiene el mes actual sin ceros a la izquierda
    
        try {
            // Verificar si hay datos para el mes actual y el año actual
            $query = "SELECT * FROM seccionesxmeta WHERE YEAR(fecha) = $año AND MONTH(fecha) = $mesActual AND id_seccion = $id_seccion";
            $resultado = $this->conex->prepare($query);
            $resultado->execute();
    
            if ($resultado->rowCount() == 0) {
               return true;
            }else{
                return false;
            }
    
            return true;
        } catch (Exception $e) {
            return json_encode(false);
        }
    }

    public function comprobar_meta_user()
    {
        $año = date('Y');
        $mesActual = date('n'); // Obtiene el mes actual sin ceros a la izquierda
        try {
            // Verificar si hay datos para el mes actual y el año actual
            $query2 = "SELECT meta.meta FROM seccionesxmeta,meta WHERE  YEAR(seccionesxmeta.fecha) = $año AND MONTH(seccionesxmeta.fecha) = $mesActual AND seccionesxmeta.id_meta = meta.id_meta";
            $resultado = $this->conex->prepare($query2);
            $resultado->execute();
            if ($resultado->rowCount() == '') {
               return false;
            }else{
                return true;
            }
            return true;
        } catch (Exception $e) {
            return json_encode(false);
        }
    }
    
    public function registrar_meta_mes($fecha,$meta,$id_seccion,$id_usuario,$accion)
    {
        try {
            $this->conex->query("INSERT INTO meta (meta) VALUES ('$meta')");
            $id_meta = $this->conex->lastInsertId();
            $this->conex->query("INSERT INTO seccionesXmeta (id_meta,id_seccion,fecha) VALUES ('$id_meta','$id_seccion','$fecha')");
            parent::registrar_bitacora($id_usuario,$accion);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function registrar_meta_mes_user($fecha, $id_seccion)
    {
        $año = date('Y');
        $mesActual = date('n'); 
        try {
            $validar_registro = "SELECT meta.id_meta FROM seccionesxmeta, meta 
            WHERE YEAR(seccionesxmeta.fecha) =  $año
            AND MONTH(seccionesxmeta.fecha) = $mesActual
            AND seccionesxmeta.id_meta = meta.id_meta AND seccionesxmeta.id_seccion = $id_seccion";
            $resultado_validar = $this->conex->prepare($validar_registro);
            $resultado_validar->execute();
            if ($resultado_validar->rowCount() == 0) {
                $query = "SELECT meta.id_meta FROM seccionesxmeta, meta 
                        WHERE YEAR(seccionesxmeta.fecha) = $año 
                        AND MONTH(seccionesxmeta.fecha) = $mesActual 
                        AND seccionesxmeta.id_meta = meta.id_meta";
                $resultado = $this->conex->prepare($query);
                $resultado->execute();
                $fila = $resultado->fetchAll();
                $id_meta = $fila[0]['id_meta'];
                $this->conex->query("INSERT INTO seccionesXmeta (id_meta, id_seccion, fecha) VALUES ('$id_meta', '$id_seccion', '$fecha')");
                return true;
            }else{
                return true;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function reporte_documentos()
    {
        try {
            // Obtén el año actual
            $año_actual = date('Y');
    
            // Consulta 1: Obtener la cantidad de documentos por mes
            $sql_documentos = "SELECT 
                                    MONTH(fecha_registro) AS mes, 
                                    YEAR(fecha_registro) AS año, 
                                    COUNT(id_documento) AS cantidad 
                               FROM 
                                    documentos 
                               WHERE 
                                    YEAR(fecha_registro) = $año_actual
                               GROUP BY 
                                    mes, 
                                    año 
                               ORDER BY 
                                    año, 
                                    mes";
            $stmt_documentos = $this->conex->prepare($sql_documentos);
            $stmt_documentos->execute();
            $resultado_documentos = $stmt_documentos->fetchAll();
    
            // Consulta 2: Obtener las metas por mes
            $sql_meta = "SELECT 
                             MONTH(fecha) AS mes, 
                             YEAR(fecha) AS año, 
                             meta 
                         FROM 
                             meta 
                         JOIN 
                             seccionesxmeta ON meta.id_meta = seccionesxmeta.id_meta
                         WHERE 
                             YEAR(fecha) = $año_actual";
            $stmt_meta = $this->conex->prepare($sql_meta);
            $stmt_meta->execute();
            $resultado_meta = $stmt_meta->fetchAll();
    
            // Inicializar el objeto para almacenar los resultados
            $documentos = [
                'todos' => array_fill(1, 12, ['cantidad' => 0, 'meta' => 'Sin Meta']),
                'entrada' => array_fill(1, 12, 0),
                'sin_entrada' => array_fill(1, 12, 0),
                'salida' => array_fill(1, 12, 0)
            ];
    
            // Combinar los resultados para 'todos'
            foreach ($resultado_documentos as $doc) {
                $mes = (int)$doc['mes'];
                $cantidad = (int)$doc['cantidad'];
    
                // Buscar la meta correspondiente para el mismo mes y año
                $meta_encontrada = 'Sin Meta';
                foreach ($resultado_meta as $meta) {
                    if ($meta['mes'] == $mes && $meta['año'] == $doc['año']) {
                        $meta_encontrada = $meta['meta'];
                        break;
                    }
                }
    
                // Almacenar el resultado en el arreglo 'todos'
                $documentos['todos'][$mes] = [
                    'cantidad' => $cantidad,
                    'meta' => $meta_encontrada
                ];
            }
    
            // Consulta y combinación para 'entrada', 'sin_entrada', y 'salida' (mantén las consultas que ya tienes)
            $queries = [
                'entrada' => "SELECT MONTH(fecha_registro) AS mes, COUNT(*) AS cantidad
                              FROM documentos
                              WHERE estatus = 1 AND YEAR(fecha_registro) = $año_actual
                              GROUP BY MONTH(fecha_registro)
                              ORDER BY mes",
                'sin_entrada' => "SELECT MONTH(fecha_registro) AS mes, COUNT(*) AS cantidad
                                  FROM documentos
                                  WHERE estatus = 2 AND YEAR(fecha_registro) = $año_actual
                                  GROUP BY MONTH(fecha_registro)
                                  ORDER BY mes",
                'salida' => "SELECT MONTH(fecha_registro) AS mes, COUNT(*) AS cantidad
                             FROM documentos
                             WHERE estatus = 3 AND YEAR(fecha_registro) = $año_actual
                             GROUP BY MONTH(fecha_registro)
                             ORDER BY mes"
            ];
    
            foreach ($queries as $key => $query) {
                $stmt = $this->conex->prepare($query);
                $stmt->execute();
                $resultados = $stmt->fetchAll();
    
                foreach ($resultados as $fila) {
                    $mes = (int)$fila['mes'];
                    $cantidad = (int)$fila['cantidad'];
                    $documentos[$key][$mes] = $cantidad;
                }
            }
    
            return $documentos;
        } catch (Exception $e) {
            // Manejo de errores, puedes registrar el error si lo deseas
            return [
                'todos' => array_fill(1, 12, ['cantidad' => 0, 'meta' => 'Sin Meta']),
                'entrada' => array_fill(1, 12, 0),
                'sin_entrada' => array_fill(1, 12, 0),
                'salida' => array_fill(1, 12, 0)
            ];
        }
    }
    
    
}