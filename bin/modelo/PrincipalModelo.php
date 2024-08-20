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
    
    public function registrar_meta_mes($fecha,$meta,$id_seccion)
    {
        try {
                $query = "SELECT id_meta FROM meta WHERE meta = '$meta'";
                $resultado = $this->conex->query($query);
                
                if ($resultado->rowCount() == 0) {
                    // Si no existe el registro, inserta un nuevo valor
                    $this->conex->query("INSERT INTO meta (meta) VALUES ('$meta')");
                    $id_meta = $this->conex->lastInsertId();  // Captura el ID del registro insertado
                } else {
                    // Si ya existe el registro, captura el ID
                    $fila = $resultado->fetchAll();
                    $id_meta = $fila[0]['id_meta'];
                }
            
                $this->conex->query("INSERT INTO seccionesXmeta (id_meta,id_seccion,fecha) VALUES ('$id_meta','$id_seccion','$fecha')");
        
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
            // Consulta para obtener documentos por estatus y mes, incluyendo meta
            $queries = [
                'todos' => "SELECT 
                                MONTH(documentos.fecha_registro) AS mes,
                                YEAR(documentos.fecha_registro) AS año,
                                COUNT(documentos.id_documento) AS cantidad,
                                COALESCE(meta.meta, 'Sin Meta') AS meta
                            FROM 
                                documentos
                                LEFT JOIN seccionesxmeta ON MONTH(documentos.fecha_registro) = MONTH(seccionesxmeta.fecha)
                                AND YEAR(documentos.fecha_registro) = YEAR(seccionesxmeta.fecha)
                                LEFT JOIN meta ON seccionesxmeta.id_meta = meta.id_meta
                            WHERE 
                                YEAR(documentos.fecha_registro) = $año_actual
                            GROUP BY 
                                mes, 
                                año, 
                                meta
                            ORDER BY 
                                año, 
                                mes;
                            ",
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