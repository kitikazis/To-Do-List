<?php
use PHPUnit\Framework\TestCase;
use App\Classes\ActivityManager;

class ActivityManagerTest extends TestCase
{
    private $testJsonFile;

    protected function setUp(): void
    {
        $this->testJsonFile = 'tests/fixtures/test_actividades.json';
        if (file_exists($this->testJsonFile)) {
            unlink($this->testJsonFile);
        }
    }

    /** @test */
    public function debe_crear_nueva_actividad_con_datos_validos()
    {
        // ARRANGE - Preparar datos
        $activityManager = new ActivityManager($this->testJsonFile);
        $datosActividad = [
            'titulo' => 'Completar proyecto TDD',
            'descripcion' => 'Implementar TDD en aplicación To-Do',
            'estado' => 'pendiente'
        ];

        // ACT - Ejecutar acción
        $resultado = $activityManager->crear($datosActividad);

        // ASSERT - Verificar resultado
        $this->assertIsArray($resultado);
        $this->assertArrayHasKey('id', $resultado);
        $this->assertEquals('Completar proyecto TDD', $resultado['titulo']);
        $this->assertEquals('pendiente', $resultado['estado']);
        $this->assertArrayHasKey('fecha_creacion', $resultado);
    }

    /** @test */
    public function debe_fallar_al_crear_actividad_sin_titulo()
    {
        $activityManager = new ActivityManager($this->testJsonFile);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('El título es obligatorio');

        $activityManager->crear(['descripcion' => 'Sin título']);
    }
}