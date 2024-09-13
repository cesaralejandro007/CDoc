<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class BitacoraSistemaModelo extends connectDB
{
    public function listarBitacoraSistema()
    {
        $respuestaArreglo = [];
        try {
            // Consulta SQL para obtener bitácora y ordenar por cédula, IP, y fecha
            $sql = "
            SELECT 
                CONCAT_WS(' ', usuarios.cedula, usuarios.nombres, usuarios.apellidos) AS nombre_completo,
                bitacora_sistema.ip_cliente, 
                bitacora_sistema.nombre_servidor, 
                bitacora_sistema.ruta_script, 
                bitacora_sistema.user_agent, 
                DATE_FORMAT(bitacora_sistema.fecha, '%Y-%m-%d %H:%i:%s') AS fecha 
            FROM 
                usuarios
            JOIN 
                bitacora_sistema 
            ON 
                bitacora_sistema.id_usuario = usuarios.id_usuario
            ORDER BY 
                usuarios.cedula, bitacora_sistema.ip_cliente, bitacora_sistema.fecha DESC";
            
            // Ejecutar la consulta
            $stmt = $this->conex->prepare($sql);
            $stmt->execute();
            $resultados = $stmt->fetchAll();
            
            // Organizar los datos por usuario e IP
            $list = [];
            foreach ($resultados as $fila) {
                $nombre_completo = $fila['nombre_completo'];
                $ip_cliente = $fila['ip_cliente'];
                
                // Si el usuario aún no está en la lista, inicialízalo
                if (!isset($list[$nombre_completo])) {
                    $list[$nombre_completo] = [];
                }
            
                // Si la IP aún no está en la lista para el usuario, inicialízala
                if (!isset($list[$nombre_completo][$ip_cliente])) {
                    $list[$nombre_completo][$ip_cliente] = [];
                }
            
                // Añadir los datos de la bitácora bajo la IP correspondiente
                $list[$nombre_completo][$ip_cliente][] = [
                    'nombre_servidor' => $fila['nombre_servidor'],
                    'ruta_script' => $fila['ruta_script'],
                    'user_agent' => $fila['user_agent'],
                    'fecha' => $fila['fecha']
                ];
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $list;
    }
    
    
}