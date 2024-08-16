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
    
            // Consulta para obtener documentos por estatus y mes
            $queries = [
                'todos' => "SELECT MONTH(fecha_registro) AS mes, COUNT(*) AS cantidad
                            FROM documentos
                            WHERE YEAR(fecha_registro) = $año_actual
                            GROUP BY MONTH(fecha_registro)
                            ORDER BY mes",
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
                'todos' => array_fill(1, 12, 0),
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
                    $documentos[$key][$mes] = $cantidad;
                }
            }
    
            return $documentos;
        } catch (Exception $e) {
            // Manejo de errores, puedes registrar el error si lo deseas
            return [
                'todos' => array_fill(1, 12, 0),
                'entrada' => array_fill(1, 12, 0),
                'sin_entrada' => array_fill(1, 12, 0),
                'salida' => array_fill(1, 12, 0)
            ];
        }
    }
    

    
}