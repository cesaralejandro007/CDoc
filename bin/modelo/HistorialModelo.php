<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class HistorialModelo extends connectDB
{
    public function listar_historial()
    {
        $resultado = $this->conex->prepare("
            SELECT CONCAT(usuarios.cedula, ', ', usuarios.nombres, ' ', usuarios.apellidos) AS nombre_completo, historial.accion 
            FROM usuarios, historial 
            WHERE usuarios.id_usuario = historial.id_usuario;
        ");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $historiales = $resultado->fetchAll();
    
            // Arreglo para los nombres de los meses en español
            $mesesEspanol = [
                1 => 'enero',
                2 => 'febrero',
                3 => 'marzo',
                4 => 'abril',
                5 => 'mayo',
                6 => 'junio',
                7 => 'julio',
                8 => 'agosto',
                9 => 'septiembre',
                10 => 'octubre',
                11 => 'noviembre',
                12 => 'diciembre'
            ];
    
            foreach ($historiales as $historial) {
                $accionesSeparadas = explode(' / ', $historial['accion']);
                $accionesFormateadas = [];
    
                foreach ($accionesSeparadas as $accion) {
                    list($fecha, $mensaje) = explode(' - ', $accion);
    
                    // Convertir la fecha en un formato legible
                    $fechaFormateada = date("d-m-Y H:i:s", strtotime($fecha));
                    $partesFecha = date_parse($fechaFormateada);
    
                    // Formatear el mensaje final con los meses en español
                    $mensajeFormateado = "El día " . $partesFecha['day'] . " de " . $mesesEspanol[$partesFecha['month']] . " del " . $partesFecha['year'] . " a las " . $partesFecha['hour'] . ":" . $partesFecha['minute'] . ":" . $partesFecha['second'] . " realizó la siguiente accion: <strong class='text-danger'>" . $mensaje . ".</strong>";
    
                    $accionesFormateadas[] = $mensajeFormateado;
                }
    
                $respuestaArreglo[] = [
                    'nombre_completo' => $historial['nombre_completo'],
                    'acciones' => $accionesFormateadas
                ];
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }
    
}