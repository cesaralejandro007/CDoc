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
     
    public function reporte_documentos()
    {
        try {
            // Obtén el año actual
            $año_actual = date('Y');            
            // Consulta para obtener documentos por estatus y mes, incluyendo meta
            $queries = [
                'todos' => "SELECT meta.meta, MONTH(documentos.fecha_registro) AS mes, COUNT(*) AS cantidad FROM documentos,usuarios,secciones,meta WHERE documentos.id_usuario = usuarios.id_usuario AND usuarios.id_seccion = secciones.id_seccion AND secciones.id_meta AND meta.id_meta AND YEAR(documentos.fecha_registro) = YEAR(meta.fecha) AND MONTH(documentos.fecha_registro) = MONTH(meta.fecha) AND YEAR(documentos.fecha_registro) = $año_actual GROUP BY(mes)",
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
    
            // Inicializar el objeto para almacenar los resultados
            $documentos = [
                'todos' => array_fill(1, 12, ['cantidad' => 0, 'meta' => 0]),
                'entrada' => array_fill(1, 12, 0),
                'sin_entrada' => array_fill(1, 12, 0),
                'salida' => array_fill(1, 12, 0)
            ];
    
            // Ejecutar cada consulta y almacenar los resultados
            foreach ($queries as $key => $query) {
                $stmt = $this->conex->prepare($query);
                $stmt->execute();
                $resultados = $stmt->fetchAll();
    
                foreach ($resultados as $fila) {
                    $mes = (int)$fila['mes'];
                    $cantidad = (int)$fila['cantidad'];
    
                    if ($key === 'todos') {
                        $meta = isset($fila['meta']) ? (int)$fila['meta'] : 0; // Convertir null a 0
                        $documentos[$key][$mes] = [
                            'cantidad' => $cantidad,
                            'meta' => $meta
                        ];
                    } else {
                        $documentos[$key][$mes] = $cantidad;
                    }
                }
            }
    
            return $documentos;
        } catch (Exception $e) {
            // Manejo de errores, puedes registrar el error si lo deseas
            return [
                'todos' => array_fill(1, 12, ['cantidad' => 0, 'meta' => 0]),
                'entrada' => array_fill(1, 12, 0),
                'sin_entrada' => array_fill(1, 12, 0),
                'salida' => array_fill(1, 12, 0)
            ];
        }
    }
    

    
}