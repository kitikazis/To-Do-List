<?php
namespace App\Classes;

use InvalidArgumentException;

class ActivityManager
{
    private $archivoJson;

    public function __construct($archivoJson = 'JSON/actividades.json')
    {
        $this->archivoJson = $archivoJson;
    }

    public function crear($datos)
    {

        if (empty($datos['titulo'])) {
            throw new InvalidArgumentException('El título es obligatorio');
        }

        // Crear actividad mínima para el test de "debe_crear_nueva_actividad_con_datos_validos"
        $actividad = [
            'id' => $this->generarId(),
            'titulo' => $datos['titulo'],
            'descripcion' => $datos['descripcion'] ?? '',
            'estado' => $datos['estado'] ?? 'pendiente',
            'fecha_creacion' => date('Y-m-d H:i:s')
        ];

        // Guardar en JSON (implementación mínima para que no falle por archivo)
        $this->guardarActividad($actividad);

        return $actividad;
    }

    private function generarId()
    {
        return uniqid('act_', true);
    }

    private function guardarActividad($actividad)
    {
        $actividades = $this->cargarActividades();
        $actividades[] = $actividad;
        // Asegúrate de que la ruta al JSON sea correcta desde la perspectiva de ActivityManager
        // Si el archivo JSON está en la raíz del proyecto, y ActivityManager se instancia desde pages/,
        // la ruta podría necesitar ser '../JSON/actividades.json' o similar.
        // Para los tests, usamos 'tests/fixtures/test_actividades.json'
        file_put_contents($this->archivoJson, json_encode($actividades, JSON_PRETTY_PRINT));
    }

    private function cargarActividades()
    {
        if (!file_exists($this->archivoJson)) {
            return [];
        }
        return json_decode(file_get_contents($this->archivoJson), true) ?: [];
    }
}